<?
/*
 payment gateway module for PaySystems.com
 created on 12/31/03 for v1.4.0
 currently only supports the "Client side non-secure form POST" connection method
 PaySystems has 3 types of accounts:
 	sale - non tangible goods (uses paysystems cart)
	catalog - tangible goods (uses paysystems cart)
	pro - for use with third party carts (we use this method)
*/

$pay_info = $order['pay_info']; // just shortens the variable a bit for ease of coding
$post_url = "https://auth.paysystems.com/cgi-v310/payment/onlinesale-tpppro.asp"; // URL to post form data to
?>
<?=$Final_Payment_Image?>
<br>
<div class="cart_instruction">
	To complete your order, please click the button below.
</div><br><br>

<form method="post" action="<?=$post_url?>">
	<input type="hidden" name="companyid" value="<?=$Payment_Gateway['Account_Name'] ?>">
	<input type="hidden" name="product1" value="<?=$order['number']." - ".$order['Description'] ?>">
	<input type="hidden" name="total" value="<?=$order['grand_total']?>">
	<input type="hidden" name="formget" value="N"> <!-- tells gateway whether to respond using GET or POST -->
	<input type="hidden" name="redirect" value="<?=$Accepted_Return_URL?>">
	<input type="hidden" name="redirectfail" value="<?=$Declined_Return_URL?>">
	<!-- recurring charge fields
		Squirrelcart doesn't currently support recurring transactions
		these are for possible future use
		<input type="hidden" name="reoccur" value="Y">
		<input type="hidden" name="cycle" value="30">
		<input type="hidden" name="totalperiod" value="12">
		<input type="hidden" name="repeatamount" value="20">
	-->	
	<input type="hidden" name="delivery" value="Y"><!-- tells PaySystems whether we are sending shipping address info or not -->
	<input type="hidden" name="b_firstname" value="<?=$order['Bill_Addr']['First_Name']?>">
	<input type="hidden" name="b_lastname" value="<?=$order['Bill_Addr']['Last_Name']?>">
	<input type="hidden" name="b_address" value="<?=$order['Bill_Addr']['Street'].",".$order['Bill_Addr']['Street_2']?>">
	<input type="hidden" name="b_city" value="<?=$order['Bill_Addr']['City']?>">
	<input type="hidden" name="b_state" value="<?=$order['Bill_Addr']['State_Abbrev']?>">
	<input type="hidden" name="b_zip" value="<?=$order['Bill_Addr']['Postal_Code']?>">
	<input type="hidden" name="b_country" value="<?=$order['Bill_Addr']['Country_Alpha_2']?>">
	<input type="hidden" name="b_tel" value="<?=$order['Bill_Addr']['Phone']?>">
	<input type="hidden" name="email" value="<?=$order['Bill_Addr']['Email_Address']?>">
	<input type="hidden" name="s_firstname" value="<?=$order['Ship_Addr']['First_Name']?>">
	<input type="hidden" name="s_lastname" value="<?=$order['Ship_Addr']['Last_Name']?>">
	<input type="hidden" name="s_address" value="<?=$order['Ship_Addr']['Street'].",".$order['Ship_Addr']['Street_2']?>">
	<input type="hidden" name="s_city" value="<?=$order['Ship_Addr']['City']?>">
	<input type="hidden" name="s_state" value="<?=$order['Ship_Addr']['State_Abbrev']?>">
	<input type="hidden" name="s_zip" value="<?=$order['Ship_Addr']['Postal_Code']?>">
	<input type="hidden" name="s_country" value="<?=$order['Ship_Addr']['Country_Alpha_2']?>">
	<input type=submit value="Finalize order for $<?=$order['grand_total']?>">
</form>