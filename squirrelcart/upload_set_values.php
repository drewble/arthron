<?
	// filename: upload_set_values.php 
	// purpose: set value of a field in MySQL DB, if the field is defined as a file upload field
	// in the Field_Definition table AND user is uploading an image in that field for the DB record
	
	
	$set_string = "$upload_file[$x] = '$path/$new_img_name'";
	
	$query="
	UPDATE $table SET 
	$set_string  WHERE record_number = '$selected_record_number'";
	
	//run query
	mysql_query($query) or die ("Query Failed");
 ?>