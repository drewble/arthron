<?
	// purpose of this file is to choose an image in the admin section, which will close this popup and update the image field on the parent page
	include "config.php";
	if (!security_level("Store Admin")) die;
?>
<html>
<head>
<title>Image Chooser</title>
</head>
<body style="font-family: tahoma; font-size: 8pt">

<?
//	$dir = "products";
//	$field_name="Thumbnail_Image";

	// set path prefix....this is the path from the web root that when added to the field value of the image
	// will result in the path to the image.

	if($HTTP_GET_VARS['table'] == "Cart_Images" || $HTTP_GET_VARS['table'] == "Payment_Methods"){
		$path_prefix="";
	 } else {
		$path_prefix=$SC['image_folder']."/";
	}
	// if in Images table, which is for themes, set $path_prefix eq. to the name of the theme folder
	if($HTTP_GET_VARS['table'] == "Images") $path_prefix = "squirrelcart/themes/".get_field_val("Themes","Path_to_Files","record_number = \"$SC[theme_rn]\"");

	$server_path="$site_isp_root/$path_prefix$dir";
	$www_path = "$site_www_root/$path_prefix$dir";
	$field_path = "$path_prefix$dir";

	//Load Directory Into Array 
	$handle=opendir($server_path); 
	while ($file = readdir($handle)) {
		if ($file != "." && $file != ".." && @getimagesize("$server_path/$file")) {
			$image['name'] = $file;
//			$image['mod_date'] = filemtime($file);
			$images[] = $image; 
		}
	}
	unset($image);
	//Clean up and sort 
	closedir($handle); 

	if (!$images) {
		print "<div align=\"center\" style=\"font-size: 18pt\">There are no images in this directory</div>";
	} else {
		// we want to display the newest images at the top of the page...so just reverse the array
		$images = array_reverse($images); 
		for($x=0;$images[$x];$x++){
			$image = $images[$x];
			$image_name = $image['name'];
			print "<a href=\"javascript: void(null) ; self.close(); self.opener.record_form.new_image_path_$field_name.value='$field_path/$image_name'\"><img src=\"$www_path/$image_name\" border=\"0\"></a>";
		}
	}
?>
</body>
</html>