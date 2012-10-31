<?
// purpose of this page is to show an example of what code or code container will look like
include "config.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Content Preview</title>
	<? show_stylesheet("Admin")?>
</head>

<body>
<div align="center">
<?
if ($code_type == "content") eval(content($content_name));
if ($code_type == "content_container") eval(content_container($content_name));
?>

</div>
</body>
</html>

