<?
// file created on 10/26/2003 for v1.3.0.
// purpose of file is to output an image stream to the browser
//
// you call it in an image tag, like so:
//		<img src="image_output.php?img_path=path/to/image.jpg&width=100&height=50>
include "config.php";

if(security_level("Store Admin")){
	$img_path  = $HTTP_GET_VARS['img_path'];
	$width = $HTTP_GET_VARS['width'];
	$height = $HTTP_GET_VARS['height'];
	image_manipulate($img_path,0,$width,$height,0,0,0,0,1);
}
?>