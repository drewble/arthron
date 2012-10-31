<?
// file modified on 7/22 for v1.2 to keep people from uploading non image files
// file modified on 10/7/2003 for v1.3 to improve image field fuctionality
// file modified on 11/17/2003 for v1.3.0 to resolve Windows server uploading problems
// file modified on 12/03/2003 for v1.4.0 to resolve blank values for existing images when no gd support is present
// file modified on 12/7/2003 for v1.4.0 - to generate errors if GD is not 2.0.1 or newer
//
// this file controls the display of image fields, and also handles the uploading of the images themselves
//

// set path prefix....this is the path from the web root that when added to the field value of the image
// will result in the path to the image.

if($table == "Cart_Images" || $table == "Payment_Methods"){
	$path_prefix="";
 } else {
	$path_prefix=$SC['image_folder']."/";
}
// if in Images table, which is for themes, set $path_prefix eq. to the name of the theme folder
if($table == "Images") $path_prefix = "squirrelcart/themes/".get_field_val("Themes","Path_to_Files","record_number = \"$SC[theme_rn]\"");

$MAX_FILE_SIZE = 2000000;
$allowed_mime_type = "";

// special case for Images table because it is themed
if($table == "Images") {
	if (file_exists($SC['theme_dir']."/$Name.jpg")) {
		$field_value = "/$Name.jpg";
	} else {
		if (file_exists($SC['theme_dir']."/$Name.gif")) {
			$field_value = "/$Name.gif";
		} else {
			unset ($field_value);
		}
	}
}

// this section controls displaying the form fields to handle an image field
if ($mode=="form"){
	if ($selected_record_number) $field_value = get_field_val($table,$field_name,"record_number = $selected_record_number"); 
	$img_path = $SC['site_isp_root']."/$path_prefix$field_value";

	// determine if GD is supported
	$gif_read = function_exists("imagecreatefromgif");
	$gif_write = function_exists("imagegif");
	$jpg_read = function_exists("imagecreatefromjpeg");
	$jpg_write = function_exists("imagejpeg");
	$png_read = function_exists("imagecreatefrompng");
	$png_write = function_exists("imagepng");

	// check and see if we can write any file formats...if not, then do not attempt to resize image for display
	if ($jpg_write && $png_write && function_exists("imagecreatetruecolor")) $gd_support = 1;


	// if there is an existing image, set image tag code
	if ($field_value && is_file($img_path) && $gd_support){
		$img_size = getimagesize($img_path);
		$file_size = filesize($img_path); // file size in bytes
		$file_size = round($file_size / 1024); // file size in KB
		$img_width = $img_size[0];
		$img_height = $img_size[1];
		$max_width = 130; // max width of img to show in edit form
		$max_height = 100; // max height of img to show in edit form
		
		if ($img_width > $max_width && $img_height > $max_height) {
			if ($img_height >= $img_width) $dim = "height=$max_height";
			if ($img_width >= $img_height) $dim = "width=$max_width";
		}
		if ($img_height < $max_height && $img_width > $max_width) $dim = "width=$max_width";
		if ($img_height > $max_height && $img_width < $max_width) $dim = "height=$max_height";
		if ($img_height <= $max_height && $img_width <= $max_width) $same_dim  = 1;
		$edit_value = $path_prefix.$field_value;
		$image_edit_link = $SC['cart_www_root']."/"."image_edit_popup.php?path=$path_prefix$field_value&rn=$selected_record_number&field_name=$field_name&table=$table";

		if ($same_dim) {
			$image_src = $SC['site_www_root']."/$path_prefix$field_value";
		} else {
			$image_src = "image_output.php?img_path=".$SC['site_isp_root']."/$path_prefix$field_value&$dim";
		}
		$image_code .= "<img src=\"$image_src\" border=\"0\" alt=\"Click here to edit this image.\">";

		$pencil = get_image("Cart_Images","edit record",0,0,1);
		$image_code .= "<img style=\"position: relative; right: 10px\" src=\"$pencil\" alt=\"Click here to edit image.\" border=\"0\">";
		$orig_path_value = $field_value;
		// calculate dimensions for popup window
		$image_code = Popup_Window($image_edit_link,$image_code,700,600,1,1);
		$image_code .= "<br>$img_width x $img_height - $file_size KB";
	} else {
		//	$image_code = "no image specified";
		$orig_path_value = "no value";
		if ($field_value) $edit_value = $path_prefix.$field_value;
	}
	$field_name_fixed=str_replace("_"," ",$field_name);
	$field_name_fixed=fix_reserved_mysql_values($field_name_fixed);

	$eraser_image = get_image("Cart_Images","Eraser");
	$folder_image = get_image("Cart_Images","Open Folder");

	// grab default settings
	$image_settings = get_records("Image_Settings","*","Table_Name = '$table' AND Field_Name = '$field_name'");
	$image_settings = $image_settings[0];
	$image_settings_rn = $image_settings['record_number'];

	if (!$HTTP_POST_VARS && $image_settings && $gd_support) {
		$default_autogen = $image_settings['Autogenerate'];
		if ($default_autogen) {
			$temp = "autogen_$field_name";
			$$temp = 1;
		}
		$default_from = $image_settings['From_Image'];
		if ($default_from) {
			$temp = "autogen_from_$field_name";
			$$temp = $default_from;
		}
		$autogen_x_default = $image_settings['Width'];
		$autogen_y_default = $image_settings['Height'];
	}

	// set the options for the "from" field below "autogenerate"
	// grab all image fields in this table
	$image_fields = get_records("Field_Definition","Field_Name","Table_Name = '$table' AND Display_As = 'Image Upload'","record_number","ASC");
	if ($image_fields) {
		foreach($image_fields as $image_field) {
			$value = $image_field['Field_Name'];
			$check = "autogen_from_$field_name";
			unset ($selected);
			if ($HTTP_POST_VARS[$check] == $value || (!$HTTP_POST_VARS && $default_from == $value)) {
				$selected = "selected";
			} 
			if (!$HTTP_POST_VARS[$check] && $field_name != "Large_Image" && $value == "Large_Image") $selected = "selected";
			$choice = str_replace("_"," ",$value);
			$autogen_from_options .= "<option value=\"$value\" $selected>$choice</option>\n";
		}
	}
	
	// set values for form fields
	$autogen_check = "autogen_$field_name";
	if ($HTTP_POST_VARS[$autogen_check] == "1" || (!$HTTP_POST_VARS && $default_autogen)) {
		$autogen_value = "checked";
		$autogen_default_vis = "";
	} else {
		$autogen_default_vis = "none";
	}
	$autogen_x = "autogen_x_$field_name";
	if ($HTTP_POST_VARS[$autogen_x]) {
		$autogen_x = $HTTP_POST_VARS[$autogen_x];
	} else {
		if ($autogen_x_default) {
			$autogen_x = $autogen_x_default;
		} else {
			unset($autogen_x);
		}
	}
	$autogen_y = "autogen_y_$field_name";
	if ($HTTP_POST_VARS[$autogen_y]) {
		$autogen_y = $HTTP_POST_VARS[$autogen_y];
	} else {
		if ($autogen_y_default) {
			$autogen_y = $autogen_y_default;
		} else {
			unset($autogen_y);
		}
	}
	$autogen_lock = "autogen_lockaspect_$field_name";
	if ($HTTP_POST_VARS['upload_file']) {
		if ($HTTP_POST_VARS[$autogen_lock]) {
			$autogen_lock = "checked";
		} else {
			unset($autogen_lock);
		}
	} else {
		$autogen_lock = "checked"; // default value for new records
	}
	if ($SC['row_style']) {
		$row_style="style = \"background-color: #F8F5FE; border-top: solid 1px #C5C3C8; border-bottom: solid 1px #C5C3C8\"";
		unset ($SC['row_style']);
	} else {
		unset ($row_style);
		
		// check to see if there is an image field right after this one
		$fields = get_fields($db,$table);
		// loop through $fields until we find the field we are currently on
		for($x=0;$fields[$x];$x++){
			$field = $fields[$x];
			if ($field == $field_name) $next_field = $fields[$x+1]; // set $next_field to the name of the next field in the DB after the current one
		}
		if ($next_field) {
			// figure out if next field is an image field
			$next_field_type = get_field_val("Field_Definition","Display_As","Table_Name = '$table' AND Field_Name = '$next_field'");
			if ($next_field_type == "Image Upload") $SC['row_style'] = 1; // setting this will then trigger an alternate row next time this is called
		}
	}
	$autogen = "autogen_$field_name";


	$np_autogen_default = "autogen_$field_name";

	if ($HTTP_POST_VARS[$autogen] || $$np_autogen_default ) $autogen_value = "checked";
	
	if ($image_settings) $default_link = "<div align=\"right\"><a target=\"new\" href=\"index.php?table=Image_Settings&edit_records=1&selected_record_number=$image_settings_rn\">edit defaults</a></div>";
	
	// grab the template file, and replace variables accordingly	
	$file_array = file("$SC[cart_isp_root]/includes/edit_image_field.php");
	for($x=0;$file_array[$x];$x++){
		$file = $file.$file_array[$x];
	}
	if (!$gd_support) $file = str_replace('<?=$autogen_section_vis?>',"none",$file); // controls whether autogen option will be visible or not
	$file = str_replace('<?=$descriptor?>',$descriptor,$file);
	$file = str_replace('<?=$image_link?>',$image_link,$file);
	$file = str_replace('<?=$orig_path_value?>',$orig_path_value,$file);
	$file = str_replace('<?=$field_name?>',$field_name,$file);
	$file = str_replace('<?=$edit_value?>',$edit_value,$file);
	$file = str_replace('<?=$field_def[\'Path\']?>',$field_def['Path'],$file);
	$file = str_replace('<?=$eraser_image?>',$eraser_image,$file);
	$file = str_replace('<?=$folder_image?>',$folder_image,$file);
	$file = str_replace('<?=$autogen_from_options?>',$autogen_from_options,$file);
	$file = str_replace('<?=$autogen_value?>',$autogen_value,$file);
	$file = str_replace('<?=$autogen_default_vis?>',$autogen_default_vis,$file);
	$file = str_replace('<?=$autogen_x?>',$autogen_x,$file);
	$file = str_replace('<?=$autogen_y?>',$autogen_y,$file);
	$file = str_replace('<?=$autogen_lock?>',$autogen_lock,$file);
	$file = str_replace('<?=$row_style?>',$row_style,$file);
	$file = str_replace('<?=$table?>',$table,$file);
	$file = str_replace('<?=$image_code?>',$image_code,$file);
	$file = str_replace('<?=$default_link?>',$default_link,$file);
	$file = str_replace('<?=$default_autogen?>',$default_autogen,$file);
	$return_value .= $file;
}


// this section handles the uploading of images
if ($mode=="upload"){
	$img_field_name=$upload_file[$x]; // name of field in DB
	$img = $HTTP_POST_FILES[$img_field_name]; // actual variable with image info
	$img_name = $img['name']; // original file name
	$img_tmp_name = $img['tmp_name']; // temp file name - location of the image that was uploaded
	$img_size = $img['size'];
	$img_type = $img['type']; // mime type
	if ($table == "Images") {
		$extension = strtolower(substr($img_name,-3));
		$img_name = "$Name.$extension";
	} 

	$path = $upload_path[$x]; // path to copy the image to
	// test section for confirming variables
	// print "upload file is: $img <br>";
	// print "upload file name is: $img_name<br>";
	// print "upload file size is: $img_size<br>";
	// print "upload file type is: $img_type <br>";
	if ($img_name != "") {
		// failure conditions
		$no_web_root = !file_exists($site_isp_root);
		$no_path = !file_exists("$site_isp_root/$path_prefix$path");
		$not_image = !strstr(strtolower($img_type),"image");
		$already_exists = file_exists($site_isp_root."/$path/$img_name");
		if($no_web_root) {
			print "<b>Error: </b>Unable to find path to web root - \"$site_isp_root\"!<br>";
			return;
		}
		if($no_path) {
			print "<b>Error: </b>Unable to find default path for this upload - \"$site_isp_root/$path_prefix$path\"!<br>";
			return;
		}
		if($not_image) {
			print "<b>Error: </b>File must be an image!<br><br>";
			return;
		}
		//---------------------------- left for possible future use -------------------------------------------------------//
		//		if($already_exists){
		//			print "$isp_www_root/$path/$img_name already exists...<br>";
		//			return;
		//			}
		 // everything is cool path wise - check for permission to write
		if(!is_writeable($site_isp_root."/$path_prefix$path")) {
			print "<b>Error: </b>Insufficient permissions to write to - \"$site_isp_root/$path_prefix$path\"!<br>";
			return;
		} else { //excetue the upload. all conditions have been met.
			// rename image according to standards
			$extension = strrchr($img_name, ".");

			if ($table == "Images" || $table == "Cart_Images" || $table == "Payment_Methods") { // images in Images table can't be renamed
				$new_img_name = $img_name;
			} else {
				$new_img_name = strtolower($selected_record_number."_".$field_name.$extension);
			}

			copy($img_tmp_name, "$site_isp_root/$path_prefix$path/$new_img_name") 
			or print("<b>Error!</b> Couldn't copy file - $new_img_name!<br>");  
			if (file_exists("$site_isp_root/$path_prefix$path/$new_img_name")){
				print "Succesfully uploaded file \"$new_img_name\"<br><img src=\"$site_www_root/$path_prefix$path/$new_img_name\"><br>";
				if ($table == "Images") {
					$orig_img = "$SC[theme_dir]$orig_path[$x]";
				} else {
					$orig_img = "$site_isp_root/$SC[image_folder]/$orig_path[$x]";
				}
				$new_img = "$site_isp_root/$path_prefix$path/$new_img_name";

				// delete original image if store settings allows it
				if(get_field_val("Store_Information","Delete_Unused_Images")){
					if (file_exists($orig_img) && ($orig_img != $new_img)) {
						$deleted = delete_image($orig_path[$x],$table,$selected_record_number);
						if($deleted == "deleted") print "Deleted original image: ".$orig_path[$x]."<br>";
						if($deleted == "failed") print "Failed to delete original image: ".$orig_path[$x]."<br>";
					}
				}
				// section below is for theme images
				if($table == "Images") {
					//if we just uploaded a jpg, we need to delete any existing same name gifs, and vice versa
					if ($extension == "jpg") $old_extension = "gif";
					if ($extension == "gif") $old_extension = "jpg";
					$remove_file = str_replace($extension, $old_extension, $new_img);
					if(file_exists($remove_file)) unlink($remove_file);
				}
				include "$SC[cart_isp_root]/upload_set_values.php";
			};
		}
	} else {
		print("<b>Error!</b> No input file specified for field \"$upload_file[$x]\"<br>");
	}
}
?>