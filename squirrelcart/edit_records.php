<?
// file modified on 10/7/2003 for v1.3 to improve image field fuctionality
// file modified on 11/17/2003 for v1.3.0 to resolve Windows server uploading problems

	// if submitting a change to a record, include the page that processes the changes
	if ($sql_action=="Submit Record") 	include "$SC[cart_isp_root]/edit_record_process.php";

	//-------------trigger delete of record -------------------------------------//	
	//position dependent!!!! must be before any references to records are displayed.
	//becuase it deletes a record. if moved, the record may still show up until a page refresh
	if($sql_action=="Click this button to confirm deletion...") {
		$record_message = delete_record($table,$selected_record_number);
		$record_message = $record_message['Message'];
	}
	if($sql_action=="Delete Record"){
		print "<form action=\"\" method=\"post\">\r";
		print "<br><br><input type=\"submit\" name=\"sql_action\" value=\"Click this button to confirm deletion...\">\r";
		print "</form>\r";
	}
	// ------------- end of delete record section ---------------------------------//
			
		
	if(isset($old_table) && ($table !=$old_table)) unset($record_message);
	if (!$selected_record_number && $select_key1 && $table) $record_message = "Choose a record to modify.";
		
	//-----------message to report back -----------------------------------//
	if($record_message) print "<font class=\"edit_record_message\">$record_message\n</font><br><br>";

	if ($sql_action == "Submit Record") {
		//----------trigger upload of file ---------------------------//
		//position dependent!!!! must be after above line, becuase it sets the values of the upload fields AFTER they have already
		// been set above to the temp file on the web server
		
		// set path prefix....this is the path from the web root that when added to the field value of the image
		// will result in the path to the image.
		if($table == "Cart_Images" || $table == "Payment_Methods"){
			$path_prefix="";
		 } else {
			$path_prefix=$SC['image_folder']."/";
		}
		// if in Images table, which is for themes, set $path_prefix eq. to the name of the theme folder
		if($table == "Images") $path_prefix = "squirrelcart/themes/".get_field_val("Themes","Path_to_Files","record_number = \"$SC[theme_rn]\"");

		// $upload_file[$x] is equal to the name of the field that is an upload
		for($x=0;$upload_file[$x];$x++){
			$field_name = $upload_file[$x];
			// figure out what action to take
			$image_action = "image_action_$field_name";
			$image_action = $$image_action;
			
			if ($image_action == "new") {
				$upload_value = $$field_name;
				// $upload_value just set above to the value of the image upload field named by $upload_file[$x]. this is equivelant to the local path to the file set in the upload field on the form
				$upload_not_set = $upload_value == "none";
				$run_upload = $upload_value['name'] && !$upload_not_set;
				$mode="upload";
				if ($run_upload) {
					include "$SC[cart_isp_root]/upload.php";
				} else {
					// if copying records, the image upload fields where losing their copied value. this fixed that
					if ($copy_record) {
						if($field_name && $orig_path[$x] != "no value") set_field_val($table,$field_name,$orig_path[$x],"record_number = '$selected_record_number'");
					}
				}
			}			
			if ($image_action == "edit") {
				// if a new image path is specified
				$new_path = "new_image_path_$field_name";
				$new_path = $$new_path;
				if ($new_path) {
					// need to reformat $new_path specified by user to account for variations in entering data
					$new_path = trim($new_path); // remove leading and trailing spaces
					// if path entered starts with a "/" strip it out
					if ($new_path[0] == "/") $new_path = substr_replace($new_path, '', 0,1);
					// if path entered has the image folder at the beginning of it, strip it out
					$img_folder_chrs = strlen($SC['image_folder']); // number of chars in image folder name - no slashes
					$compare = substr($new_path,0,$img_folder_chrs); // same set of chars from the path entered by merchant
					if ($compare == $SC['image_folder']) {
						$new_path = substr($new_path,$img_folder_chrs + 1);
					}
					// if path entered does not contain a directory, add the default directory to the beginning of the path
					if (!strstr($new_path,"/")) $new_path = $upload_path[$x]."/".$new_path;
					// if the new image path specified does not match the one in the DB, update the DB
					if ($orig_path[$x] != $new_path) {
						$path_on_server = "$SC[site_isp_root]/$path_prefix$new_path";
						// if file specified by merchant actually exists, and is an image, THEN update DB
						if (is_file($path_on_server) && getimagesize($path_on_server)) {
							set_field_val($table,$field_name,$new_path,"record_number = '$selected_record_number'");
						} else {
							print "<b>Error: </b>Path specified for ".str_replace("_"," ",$field_name)." is not an image!<br>";
						}
					}
				} else {
					// new_path not available, which means it was cleared....update DB accordingly to wipe out image path
					set_field_val($table,$field_name,"","record_number = '$selected_record_number'");
				}
			}
		}
		// image resizing is done after ALL images are uploaded, otherwise this section would be part of the above for loop, instead of in it's own
		// this is triggered by the "autogenerate" option when modifying an image type field
		for($x=0;$upload_file[$x];$x++){
			$field_name = $upload_file[$x];
			// figure out whether to autogenerate image for this field
			$autogen = "autogen_$field_name";
			$autogen = $$autogen;
			if ($autogen) {
				// code to resize images here
				// check to see if image they specified to resize from exists!
				$from_field = "autogen_from_$field_name";
				$from_field = $$from_field;
				$from_image = get_field_val($table,$from_field,"record_number = $selected_record_number");
				$from_image = $SC['site_isp_root']."/$path_prefix$from_image";
				if ($from_image) {
					$new_x = "autogen_x_$field_name";
					$new_x = $$new_x;
					if ($new_x == "auto") unset ($new_x);
					$new_y = "autogen_y_$field_name";
					$new_y = $$new_y;
					if ($new_y == "auto") unset ($new_y);
					$dest_filename = strtolower($selected_record_number."_".$upload_file[$x]);
					$dest_path = $SC['site_isp_root']."/$path_prefix".$upload_path[$x]."/".$dest_filename;
					$image = image_manipulate($from_image,$dest_path,$new_x,$new_y);
					if (!$image['error']) {
							$fs_path = $image['image']; // full path to image on server
							$new_path = str_replace($SC['site_isp_root']."/$path_prefix","",$image['image']); // path below images folder
							$uri_path = $SC['site_www_root']."/$path_prefix$new_path"; // full URI to image
							set_field_val($table,$field_name,$new_path,"record_number = '$selected_record_number'");
							if(is_file($fs_path)) {
								print "Successfully resized image $new_path:<br>";
								// in the link below, the time is added to the URL of the image to make your browser think it is a new link, so you don't have to refresh to see the new image changes
								print "<img src=\"$uri_path?".time()."\"><br>";
							}
					} else {
						print "$image[error]<br>";
					}
				}
			}
		}		
	}

		
	// -----------display form to edit record ------------------------------ //
	if($add_new_item==1) unset($selected_record_number);
	if ($sql_action=="Submit Record" || $sql_action == "Click this button to confirm deletion...") {
		if($add_new_item) {
			$pagenum = 3;
		} else {
			$pagenum = 2;
		}
		$return_page = $SC['return_page'];
		unset($SC['return_page']);
		print "
		<head>
		<meta http-equiv=\"Refresh\" content=\"3; URL=$return_page\">
		</head>
		<font size=\"2\" face=\"tahoma\"><b>Returning to previous page...</b></font><br>
		";
	} else {
		if ($edit_records || $add_new_item) eval(content("edit record")); //show record with template window.php
	}

// -----------END OF display form to edit record ------------------------------ //
//}
//}
?>
