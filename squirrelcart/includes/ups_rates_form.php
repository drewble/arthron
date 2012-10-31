<!-- purpose of this file is to display a form to collect UPS rate and services request -->
<form method="post" action="<?=$Form_Action ?>">
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="150" >
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools - Rates and Services Lookup
		</td>
	</tr>
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="top">
			<?=$UPS_Error_Message?>
			<?=$Cart_Error_Message?>
			<input type="hidden" name="ups_rates" value="rates_form_post">
			<br>
			<br>
			<span class="field_name">Package weight in lbs:</span><input type="text" name="ups_info[weight]" size="2" value="<?=$ups_info['weight']?>"><br>
			<span class="field_name">Originating Postal Code:</span><input type="text" name="ups_info[orig_zip]" size="8" value="<?=$ups_info['orig_zip']?>"><br>
			<span class="field_name">Originating Country:</span><?=$Origination_Country?><br>
			<span class="field_name">Destination Postal Code:</span><input type="text" name="ups_info[dest_zip]" size="8" value="<?=$ups_info['dest_zip']?>"><br>
			<span class="field_name">Destination Country:</span><?=$Destination_Country?><br>
			<span class="field name">Destination Address Type:</span><?=$Destination_Address_Type?><br>
			<br>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
				<input type="submit" value="check rates and services">
				<br>
		</td>
	</tr>
</table>
</form>

