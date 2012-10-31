<!--
this template controls the look of the "Electronic Check" portion of the payment method page
BE VERY CAREFUL modifying this template. All fields on this page are mandatory, and should not be removed!!!
-->

<br>
<table align="center" border="0" width="450" >
	<tr>
		<td colspan="2" class="cart_instruction">
			If paying by electronic check, please fill out the fields below:<br><br>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Name on account:
		</td>
		<td class="field_input">
			<input class="field_input" style="width: 200"  type="text" name="pay_info[bank_account_name]" value="<?=$Pay_Info['bank_account_name']?>">
			<?=$Missing['bank_account_name']?>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Name of bank:
		</td>
		<td class="field_input">
			<input class="field_input" style="width: 200"  type="text" name="pay_info[bank_name]" value="<?=$Pay_Info['bank_name']?>">
			<?=$Missing['bank_name']?>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Type of Account:
		</td>
		<td class="field_input">
			<select name="pay_info[bank_account_type]">
				<?=$Bank_Account_Type_Options?>
			</select>
			<?=$Missing['bank_account_type']?>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Check Number:
		</td>
		<td class="field_input">
			<input class="field_input" style="width: 60"  type="text" name="pay_info[check_number]" value="<?=$Pay_Info['check_number']?>">
			<?=$Missing['check_number']?>
		</td>
	</tr>
</table>			
<br>


<table align="center" border="0" width="450">
	<tr>
		<td height="20" valign="middle" style="text-align:right">
				<?=$Routing_Symbol_Image?>
				<input style="vertical-align: top; font-family: courier; width: 100px; letter-spacing: 2px" type="text" name="pay_info[bank_routing_number]" maxlength="9" value="<?=$Pay_Info['bank_routing_number']?>">
				<?=$Routing_Symbol_Image?>
				<?=$Missing['bank_routing_number']?>
		</td>
		<td rowspan="2"><?=$Echeck_Help_Image?></td>
		<td height="20" valign="middle"  style="text-align:left">
				<input style="vertical-align: top; letter-spacing: 2px" type="text" name="pay_info[bank_account_number]" maxlength="25" value="<?=$Pay_Info['bank_account_number']?>">
				<?=$Account_Symbol_Image?>
				<?=$Missing['bank_account_number']?>
		</td>
	</tr>
	<tr>
		<td>
			Routing Number
		</td>
		<td>
			Account Number
		</td>
	</tr>
</table>
