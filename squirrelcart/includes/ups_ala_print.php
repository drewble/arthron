<?php
	$UPS_Logo = get_image("Cart_Images","ups_logo");
?>
<!-- this form is used to gather information needed for an access license request -->
<html>
<head>
<?php stylesheet("admin.css") ?>
<script language="Javascript1.2">
	<!--
	function printpage() {
	window.print();  
	}
	//-->
</script>
</head>
<body onload="printpage()">
<table border="0" cellspacing="0" cellpadding="5" height="200">
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="top" style="font-size: 10pt">
			<br>
				<b>UPS ONLINE® TOOLS ACCESS USER TERMS</b>
				<br>
				<br>
				<?=$ALA_Text?>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
				<br>
				<div style="width: 318">
					UPS®, UPS & Shield Design® and UNITED PARCEL SERVICE® are registered trademarks of United Parcel Service of America, Inc.
				</div>
				<br>
		</td>
	</tr>
</table>
</body>
</html>
