<!--
// Template file: order_status_popup
// This file controls the appearance of the popup window that appears when you click on an order status, for further explanation
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<? stylesheet("admin.css") ?>
	<title>Order Status Explanation for "<?=$Status?>"</title>
</head>
<body bgcolor="#FFFF00" style="padding: 10">
	<div style="font-size: 12pt;font-weight:bold;"><?=$Status?></div>
	<div style="background-color: #FFFFFF; width: 100%; padding: 5; border: dotted black 1">
		<?=$Description?>
	</div>
<div align="center">
<br><a href="javascript:void(0)" onClick="parent.close()">close this window</a>
</div>
</body>
</html>
