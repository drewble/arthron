<!-- this form is used to gather information needed for a registration request -->
<form method="post" action="<?php print $SC['www_admin_page'] ?>">
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="200">
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools Licensing & Registration Wizard - Registration Successful
		</td>
	</tr>
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="top" style="font-size: 10pt; padding-right: 40">
			<br>
			<b>Registration Successful!</b>
			<br>
			Thank you for registering to use the UPS OnLine® Tools.
			<br>
			<br>
			<br>
			To learn more about the UPS OnLine® Tools, please visit <a target="new" href="http://www.ec.ups.com">www.ec.ups.com</a>.
			<br>
			<br>
			<br>
			Still handwriting your shipping labels? <b>UPS Internet Shipping</b> allows you to electronically prepare 
			domestic and international shipments from the convenience of any computer with Internet access. To learn more or to begin using UPS Internet Shipping,
			click <a target="new" href="http://ups.com/bussol/solutions/internetship.html">here</a>.
			<br>
			<br>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<br>
			<div align="center">
				<input type="hidden" name="ups_register" value="enable">				
				<input type="submit" name="next" value="Next">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="ups_register" value="Cancel">
			</div>
			<br>
			<div style="width: 318">
				UPS®, UPS & Shield Design® and UNITED PARCEL SERVICE® are registered trademarks of United Parcel Service of America, Inc.<br>
				<a target="new" href="http://www.ec.ups.com">UPS OnLine® Tools</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a target="new"  href="http://ups.com/bussol/solutions/internetship.html">UPS Internet Shipping</a><br>
			</div>
			<br>
		</td>
	</tr>
</table>
</form>
