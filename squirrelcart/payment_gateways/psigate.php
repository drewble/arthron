<?
// updated on 11/25/2003 for v1.4.0 - added Result field and help for it
// updated on 1/20/2004 to change 4 digit exp. year to 2 digits
//
// fix the exp year, so it is in this format: yy
$exp_year = $order['pay_info']['exp_year'];
$exp_year = $exp_year[2].$exp_year[3];
?>
<?=$Final_Payment_Image?>
<br>
<form method=POST action="https://order.psigate.com/psigate.asp">
	<span class="cart_instruction" >To complete your order, please click the button below. This process may take up to 1 minute. Please do not click more than once.</span><br><br>
	<input type=submit value="Charge my Credit Card $<?=$order['grand_total'] ?>"><br>
	<input type="hidden" name="MerchantID" value="<?=$Payment_Gateway['Account_Name'] ?>">
	<input type="hidden" name="FullTotal" value="<?=$order['grand_total'] ?>">
	<input type="hidden" name="ThanksURL" value="<?=$Accepted_Return_URL?>">
	<input type="hidden" name="NoThanksURL" value="<?=$Declined_Return_URL?>">
	<input type="hidden" name="Oid" value="<?=$order['number'] ?>">
	<input type="hidden" name="Bname" value="<?=$order['Bill_Addr']['First_Name'] ?> <?=$order['Bill_Addr']['Last_Name'] ?>">
	<input type="hidden" name="Baddr1" value="<?=$order['Bill_Addr']['Street'].",".$order['Bill_Addr']['Street_2'] ?>">
	<input type="hidden" name="Bcity" value="<?=$order['Bill_Addr']['City'] ?>">
	<input type="hidden" name="Bstate" value="<?=$order['Bill_Addr']['State_Abbrev'] ?>">
	<input type="hidden" name="Bzip" value="<?=$order['Bill_Addr']['Postal_Code'] ?>">
	<input type="hidden" name="Bcountry" value="<?=$order['Bill_Addr']['Country_Display'] ?>">
	<input type="hidden" name="Phone" value="<?=$order['Bill_Addr']['Phone'] ?>">
	<input type="hidden" name="Email" value="<?=$order['Bill_Addr']['Email_Address'] ?>">
	<input type="hidden" name="Sname" value="<?=$order['Ship_Addr']['First_Name'] ?> <?=$order['Ship_Addr']['Last_Name'] ?>">
	<input type="hidden" name="Saddr1" value="<?=$order['Ship_Addr']['Street'].",".$order['Ship_Addr']['Street_2'] ?>">
	<input type="hidden" name="Scity" value="<?=$order['Ship_Addr']['City'] ?>">
	<input type="hidden" name="Sstate" value="<?=$order['Ship_Addr']['State_Abbrev'] ?>">
	<input type="hidden" name="Szip" value="<?=$order['Ship_Addr']['Postal_Code'] ?>">
	<input type="hidden" name="Scountry" value="<?=$order['Ship_Addr']['Country_Display'] ?>">
	<input type="hidden" name="ChargeType" value="1">
	<input type="hidden" name="IP" value="<?=$REMOTE_ADDR?>">
	<input type="hidden" name="CardNumber" value="<?=$order['pay_info']['card_number'] ?>">
	<input type="hidden" name="ExpMonth" value="<?=$order['pay_info']['exp_month']?>">
	<input type="hidden" name="ExpYear" value="<?=$exp_year?>">
	<!-- 
		Note on the below "result" field:
		For live transactions, leave value set to 0. For testing, set as follows:
		1 - Good Transaction
		2 - Duplicate Transaction
		3 - Declined Transaction
	-->
	<input type="hidden" name="Result" value="0">
</form>
