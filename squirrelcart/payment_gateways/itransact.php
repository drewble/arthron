<?
/*
 payment gateway module for iTransact
 created on 11/26/02 for v1.1.0
 file modified on 7/15/2003 for v1.1.1 to fix session loss when not using cookies

note: cc_return=4 will tell the cart to include the payment gateway file (the one you are reading now!!) again, for special 
post transaction processing
*/

// if cc_return is 4, than gateway is returning here to run some more code. read comments about cc_return in cart.php
if($cc_return != 4){
	if($Payment_Gateway['Connection_Method'] == "Client side secure form POST")  $url = "https://secure.itransact.com/cgi-bin/rc/ord.cgi";
	if($Payment_Gateway['Connection_Method'] == "Client side non-secure form POST")  $url = "https://secure.itransact.com/cgi-bin/mas/split.cgi";
	
	$Company_Name = get_field_val("Store_Information","Company_Name");
	if($order['pay_info']['exp_month'] == "01") $exp_month = "January";
	if($order['pay_info']['exp_month'] == "02") $exp_month = "February";
	if($order['pay_info']['exp_month'] == "03") $exp_month = "March";
	if($order['pay_info']['exp_month'] == "04") $exp_month = "April";
	if($order['pay_info']['exp_month'] == "05") $exp_month = "May";
	if($order['pay_info']['exp_month'] == "06") $exp_month = "June";
	if($order['pay_info']['exp_month'] == "07") $exp_month = "July";
	if($order['pay_info']['exp_month'] == "08") $exp_month = "August";
	if($order['pay_info']['exp_month'] == "09") $exp_month = "September";
	if($order['pay_info']['exp_month'] == "10") $exp_month = "October";
	if($order['pay_info']['exp_month'] == "11") $exp_month = "November";
	if($order['pay_info']['exp_month'] == "12") $exp_month = "December";
// display form to user in order to submit order info to WorldPay

	print "
	$Final_Payment_Image<br>
	<form action=\"$url\" method=\"post\"> 
	<span class=\"cart_instruction\" >To complete your order, please click the button below.</span><br><br>
	<input type=\"hidden\" name=\"vendor_id\" value=\"".$Payment_Gateway['Account_Name'] ."\"> 
	<input type=\"hidden\" name=\"home_page\" value=\"".$SC['site_www_root'] ."\"> 
	<input type=\"hidden\" name=\"ret_addr\" value=\"".$SC['www_cart_page']."\">
	<input type=\"hidden\" name=\"post_back_on_error\" value=\"1\">
	<input type=\"hidden\" name=\"1_desc\" value=\"".$order['Description'] ."\">
	<input type=\"hidden\" name=\"1_cost\" value=\"".$order['grand_total'] ."\">
	<input type=\"hidden\" name=\"1_qty\" value=\"1\">
	<input type=\"hidden\" name=\"ret_mode\" value=\"post\">
	<input type=\"hidden\" name=\"first_name\" value=\"".$order['Bill_Addr']['First_Name']."\">
	<input type=\"hidden\" name=\"last_name\" value=\"".$order['Bill_Addr']['Last_Name']."\">
	<input type=\"hidden\" name=\"address\" value=\"".$order['Bill_Addr']['Street']." ".$order['Bill_Addr']['Street_2']."\">
	<input type=\"hidden\" name=\"city\" value=\"".$order['Bill_Addr']['City']."\">
	<input type=\"hidden\" name=\"state\" value=\"".$order['Bill_Addr']['State_Abbrev']."\">
	<input type=\"hidden\" name=\"zip\" value=\"".$order['Bill_Addr']['Postal_Code']."\">
	<input type=\"hidden\" name=\"country\" value=\"".$order['Bill_Addr']['Country_Display']."\">
	<input type=\"hidden\" name=\"phone\" value=\"".$order['Bill_Addr']['Phone'] ."\"> 
	<input type=\"hidden\" name=\"email\" value=\"".$order['Bill_Addr']['Email_Address'] ."\">
	<input type=\"hidden\" name=\"sfname\" value=\"".$order['Ship_Addr']['First_Name']."\">
	<input type=\"hidden\" name=\"slname\" value=\"".$order['Ship_Addr']['Last_Name']."\">
	<input type=\"hidden\" name=\"saddr\" value=\"".$order['Ship_Addr']['Street']." ".$order['Ship_Addr']['Street_2']."\">
	<input type=\"hidden\" name=\"scity\" value=\"".$order['Ship_Addr']['City']."\">
	<input type=\"hidden\" name=\"sstate\" value=\"".$order['Ship_Addr']['State_Abbrev']."\">
	<input type=\"hidden\" name=\"szip\" value=\"".$order['Ship_Addr']['Postal_Code']."\">
	<input type=\"hidden\" name=\"sctry\" value=\"".$order['Ship_Addr']['Country_Display']."\">
	<input type=\"hidden\" name=\"passback\" value=\"cc_return\">
	<input type=\"hidden\" name=\"cc_return\" value=\"4\">";

	if ($Payment_Gateway['Connection_Method'] == "Client side secure form POST") {
		print "
		<input type=\"hidden\" name=\"ccnum\" value=\"".$order['pay_info']['card_number'] ."\">
		<input type=\"hidden\" name=\"ccmo\" value=\"".$exp_month."\">
		<input type=\"hidden\" name=\"ccyr\" value=\"".$order['pay_info']['exp_year'] ."\">
		<input type=submit value=\"Charge my credit card ".$SC['currency']."".$order['grand_total']."\"><br><br>";
	}
	if ($Payment_Gateway['Connection_Method'] == "Client side non-secure form POST") {
		// showcvv The value of this field must be '1' if you would like to allow the customer to enter the CVV number printed on their credit card.
		// mername The name of your business. This will appear on the order form on the secure server
		// acceptcards Value must be '1' if you are accepting credit cards
		// acceptchecks Value must be '1' if you are accepting checks.
		// accepteft Value must be '1' if you will be accepting EFT transactions.
		// altaddr Value must be '1' if you would like to allow customers to enter an alternate shipping address.
		// nonum Removes the check number field from the BuyNow or SplitForm. (This field is removed automatically if you are accepting EFT payments.)
		print "
		<input type=\"hidden\" name=\"showcvv\" value=\"1\">
		<input type=\"hidden\" name=\"mername\" value=\"$Company_Name\">
		<input type=\"hidden\" name=\"acceptcards\" value=\"1\">
		<input type=\"hidden\" name=\"acceptchecks\" value=\"0\">
		<input type=\"hidden\" name=\"accepteft\" value=\"0\">
		<input type=\"hidden\" name=\"altaddr\" value=\"0\">
		<input type=\"hidden\" name=\"nonum\" value=\"1\">
		<input type=submit value=\"Continue to our payment processor\"><br><br>";
	 }
	

print "</form>";

	// if here, than the form above was already posted to iTransact. 
	// The code below is necessary in order to finish the transaction, ie:
	// empty the cart, write it to the DB, send the emails out, etc....
	// iTransact sends variables "err OR die" back to the cart if transaction failed
	 } else {
	 	if(!$err & !$die) {
			$cc_return=1; // successful transaction, according to WorldPay
		} else {
			$cc_return=2; // failed transaction, according to WorldPay
		}
		print "
		<html><head>
			<meta http-equiv=\"Refresh\" content=\"0; URL=".$SC['secure_cart_page']."?cc_return=$cc_return$SC[SID]\">
		</head>
		<body>
		<br><br><br><br><div align='center' style='font-size: 12pt; font-family: Tahoma, Arial, Helvetica; font-weight: bold'>Processing...please wait...</div>
		</body>
		</html>";
		die;
}
?> 