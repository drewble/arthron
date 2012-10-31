<form method="post" action="<?php print $SC['www_admin_page'] ?>">
<?=$Missed_Response?>
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="200">
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools Licensing & Registration Wizard - Step 1
		</td>
	</tr>
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
				<textarea cols="80" rows="20"><?=$ALA_Text?></textarea>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
				<input type="radio" name="ups_ala_agree" value="yes">Yes, I Do Agree
				<input type="radio" name="ups_ala_agree" value="no" style="margin-left: 100px">No, I Do Not Agree
				<br>
				<br>
				<br>
				<br>
				<input type="button" onclick="window.open('ups_registration.php?ups_ala_print=1')" name="ups_ala_print" value="Print">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="next" value="Next">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="hidden" name="ups_register" value="ala_response">				
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
