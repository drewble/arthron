<?
// purpose of this page is to show a popup window
// this page is used by the popup window function only, and should not be called directly
include "config.php";
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
	<? stylesheet("admin.css")?>
</head>

<body>
<div align="center">
<a href="javascript:void(0)" onClick="parent.close()">
	<img border="0" src="<?=$image_path ?>" alt="click image to close window">
</a>
<br>
<a class=\"admin_option_link\" href="javascript:void(0)" onClick="parent.close()">close</a>
</div>
</body>
</html>
