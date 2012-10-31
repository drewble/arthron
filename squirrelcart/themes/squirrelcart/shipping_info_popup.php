<!--
// Template file: shipping_info_popup
// This file controls the appearance of the popup window that appears when you click on the "Shipping Total" link when viewing an order, for further explanation
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<? stylesheet("admin.css") ?>
	<title>Shipping Details</title>
</head>
<body bgcolor="#FFFF00" style="padding: 10">
	<div style="font-size: 12pt;font-weight:bold;">Shipping Details</div>
	<div style="background-color: #FFFFFF; width: 100%; padding: 5; border: dotted black 1">
		<?=$Shipping_Details?>
	</div>
<br><a href="javascript:void(0)" onClick="parent.close()">close this window</a>
</div>
</body>
</html>
