<!--
// option_text_popup.php template
// for use when clicking a text option's name when viewing the cart
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<? stylesheet("admin.css") ?>
	<title>Details for "<?=$Option_Name?> option</title>
</head>
<body bgcolor="#FFFF00" style="padding: 10">
<span style="font-size: 12pt;font-weight:bold;"><?=$Option_Name?></span><br>
<span style="background-color: #FFFFFF; width: 100%; padding: 5; border: dotted black 1">
<?=$Option_Value?>
</span>
<div align="center">
<br><a href="javascript:void(0)" onClick="parent.close()">close this window</a>
</div>
</body>
</html>
