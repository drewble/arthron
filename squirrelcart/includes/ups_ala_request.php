<form method="post" action="<?php print $SC['www_admin_page'] ?>">
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="200">
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools Licensing & Registration Wizard
		</td>
	</tr>
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="top" style="font-size: 10pt">
			<br>
				<b>UPS OnLine® Tools Licensing & Registration Wizard</b>
				<br>
				<br>
				This wizard will assist you in completing the necessary licensing and registration requirements to activate and 
				use the UPS OnLine® Tools from this application.<br>
				<br>
				If you do not wish to use any of the functions that utilize the UPS OnLine® Tools, click the Cancel button and those functions will not be enabled.
				If, at a later time, you wish to use the UPS OnLine Tools®, return to this section and complete the UPS OnLine® Tools licensing and registration process.<br>
				<br>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
				<input type="hidden" name="ups_register" value="ups_ala">
				<input type="submit" name="next" value="Next">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="ups_register" value="Cancel">
				<br>
				<br>
				<div style="width: 318">
					UPS®, UPS & Shield Design® and UNITED PARCEL SERVICE® are registered trademarks of United Parcel Service of America, Inc.<br>
					<a target="new"  href="http://www.ec.ups.com">UPS OnLine® Tools</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a target="new"  href="http://ups.com/bussol/solutions/internetship.html">UPS Internet Shipping</a><br>
				</div>
				<br>
		</td>
	</tr>
</table>
</form>
