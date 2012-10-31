<!--
this template controls the look of the credit card info fields  portion of the payment method page
BE VERY CAREFUL modifying this template. All fields on this page are mandatory, and should not be removed!!!
-->
<br><br>
<?=$CC_Number_Invalid_Error?>
<table align="center" border="0" width="450" >
	<tr>
		<td colspan="2" class="cart_instruction">
			If paying by credit card, please fill out the fields below:<br><br>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Name on card:
		</td>
		<td class="field_input">
			<input class="field_input" style="width: 200"  type="text" name="pay_info[name_on_card]" value="<?=$Pay_Info['name_on_card']?>">
			<?=$Missing['name_on_card']?>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Card Number:
		</td>
		<td class="field_input">
			<input class="field_input" style="width: 200"  type="text" name="pay_info[card_number]" value="<?=$Pay_Info['card_number']?>">
			<?=$Missing['card_number']?>
		</td>
	</tr>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Expiration Date:
		</td>
		<td class="field_input">
			<select name='pay_info[exp_month]'>
				<option value=""></option>
				<option <?=$Selected['exp_month']['01']?> value="01">January</option>
				<option <?=$Selected['exp_month']['02']?> value="02">February</option>
				<option <?=$Selected['exp_month']['03']?> value="03">March</option>
				<option <?=$Selected['exp_month']['04']?> value="04">April</option>
				<option <?=$Selected['exp_month']['05']?> value="05">May</option>
				<option <?=$Selected['exp_month']['06']?> value="06">June</option>
				<option <?=$Selected['exp_month']['07']?> value="07">July</option>
				<option <?=$Selected['exp_month']['08']?> value="08">August</option>
				<option <?=$Selected['exp_month']['09']?> value="09">September</option>
				<option <?=$Selected['exp_month']['10']?> value="10">October</option>
				<option <?=$Selected['exp_month']['11']?> value="11">November</option>
				<option <?=$Selected['exp_month']['12']?> value="12">December</option>
			</select>
			<?=$Missing['exp_month']?>
			<!-- the below 'Exp_Year_Field' field is too complex to be customizable, as it is a select input that is calculated based on the current year -->
			<?=$Exp_Year_Field?>
			<?=$Missing['exp_year']?>
		</td>
	</tr>
	<!-- the table row below does not display unless you have "Collect CVV2/CVC" enabled in your store settings -->
	<!-- do not remove or modify the line below! -->
	<? if ($Collect_CVV2) { ?>
	<tr>
		<td class="field_name" style="padding-top: 4px">
			Security Code:
		</td>
		<td class="field_input">
			<input class="field_input" style="width: 50"  type="text" name="pay_info[cvv2]" value="<?=$Pay_Info['cvv2']?>">
			<?=$CVV2_Help_Popup?>
			<?=$Missing['cvv2']?>
		</td>
	</tr>
	<!-- do not remove or modify the line below! -->
	<? } ?>	
	<!-- the table row below does not display unless you are using a payment gateway connection method that is not "Server to Server" -->
	<!-- do not remove or modify the line below! -->
	<? if ($GW_Connection_Method != "Server to Server") { ?>
	<tr>
		<td colspan="2">
			<br>Note: Your credit card will not be charged until you confirm the order total on the next page.<br>
		</td>
	</tr>
	<!-- do not remove or modify the line below! -->
	<? } ?>
</table>
<br><br><br>