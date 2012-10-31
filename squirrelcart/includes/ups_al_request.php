<!-- this form is used to gather information needed for an access license request -->
<?php
	if ($ups_info['SalesRepContact'] == "yes") $SalesRepChecked['yes'] = "Checked";
	if ($ups_info['SalesRepContact'] == "no") $SalesRepChecked['no'] = "Checked";
?>
<form method="post" action="<?php print $SC['www_admin_page'] ?>">
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="200">
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools Licensing & Registration Wizard - Step 2
		</td>
	</tr>
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="top" style="font-size: 10pt">
			<br>
			<b>Please enter your contact information</b>
			<br>
			<table border="0">
				<tr>
					<td colspan="2" align="center">
						<?=$UPS_Error_Message?>
						<?=$missing_message?>
						<br>
						<?=$required_ind?> indicates a required field<br>
						<br>
					</td>
					</tr>
				<tr>
					<td align="right">
						Contact Name:
					</td>
					<td>
						<input type="text" name="ups_info[Name]" style="width:250" value="<?=$ups_info['Name']?>"> <?=$required['Name'].$missing['Name']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Title:
					</td>
					<td>
						<input type="text" name="ups_info[Title]" style="width: 250" value="<?=$ups_info['Title']?>"> <?=$required['Title'].$missing['Title']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Company Name:
					</td>
					<td>
						<input type="text" name="ups_info[CompanyName]" style="width:250" value="<?=$ups_info['CompanyName']?>"> <?=$required['CompanyName'].$missing['CompanyName']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Street Address:
					</td>
					<td>
						<input type="text" name="ups_info[AddressLine1]" style="width:250"  value="<?=$ups_info['AddressLine1']?>"> <?=$required['AddressLine1'].$missing['AddressLine1']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Street Address 2:
					</td>
					<td>
						<input type="text" name="ups_info[AddressLine2]" style="width:250" value="<?=$ups_info['AddressLine2']?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						City:
					</td>
					<td>
						<input type="text" name="ups_info[City]" style="width:150" value="<?=$ups_info['City']?>"> <?=$required['City'].$missing['City']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						State:
					</td>
					<td>
						<select name="ups_info[StateProvinceCode]" style="width:200">
							<option></option>
							<?=$StateProvinceCodeOptions?>
						</select>
						<?=$required['StateProvinceCode'].$missing['StateProvinceCode']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Country:
					</td>
					<td>
						<select name="ups_info[CountryCode]" style="width:200">
							<option></option>
							<?=$CountryCodeOptions?>
						</select> <?=$required['CountryCode'].$missing['CountryCode']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Postal Code:
					</td>
					<td>
						<input type="text" name="ups_info[PostalCode]" style="width: 60" value="<?=$ups_info['PostalCode']?>"> <?=$required['PostalCode'].$missing['PostalCode']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Phone Number:
					</td>
					<td>
						<input type="text" name="ups_info[PhoneNumber]" style="width:150" value="<?=$ups_info['PhoneNumber']?>"> <?=$required['PhoneNumber'].$missing['PhoneNumber']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Email Address:
					</td>
					<td>
						<input type="text" name="ups_info[EMailAddress]" style="width:150" value="<?=$ups_info['EMailAddress']?>"> <?=$required['EmailAddress'].$missing['EMailAddress']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						Company URL:
					</td>
					<td>
						<input type="text" name="ups_info[CompanyURL]" style="width:250" value="<?=$ups_info['CompanyURL']?>"> <?=$required['CompanyURL'].$missing['CompanyURL']?>
					</td>
				</tr>
				<tr>
					<td align="right">
						UPS Account Number:
					</td>
					<td>
						<input type="text" name="ups_info[ShipperNumber]" style="width:250" value="<?=$ups_info['ShipperNumber']?>">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br>
						<em>To open a UPS Account, <a target="new" href="https://www.ups.com">click here</a> or call 1-800-PICK-UPS.</em>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<div align="center">
				<em>I would like a UPS Sales Representative to contact me about opening a UPS shipping account
				<br>
				 or to answer questions about UPS services.</em>
				<input type="radio" name="ups_info[SalesRepContact]" value="yes" <?=$SalesRepChecked['yes']?>> Yes
				<input type="radio" name="ups_info[SalesRepContact]" value="no" <?=$SalesRepChecked['no']?>> No &nbsp;&nbsp;&nbsp;<?=$required['SalesRepContact'].$missing['SalesRepContact']?>
				<br>
				<br>
				<br>
				<input type="submit" name="next" value="Next">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="hidden" name="ups_register" value="al_response">				
				<input type="submit" name="ups_register" value="Cancel">
			</div>
				<br>
				<div style="width: 318">
					UPS®, UPS & Shield Design® and UNITED PARCEL SERVICE® are registered trademarks of United Parcel Service of America, Inc.<br>
					<a  target="new" href="http://www.ec.ups.com">UPS OnLine® Tools</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a  target="new" href="http://ups.com/bussol/solutions/internetship.html">UPS Internet Shipping</a><br>
				</div>
				<br>
		</td>
	</tr>
</table>
</form>
