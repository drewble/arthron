<?
// TrustCommerce gateway file
// added on 10/24 for v1.1.0


// special formatting of fields for TrustCommerce
	$amount = $order['grand_total']*100;
	$expyear=$order['pay_info']['exp_year'];	
	$expyear = substr($expyear, 2);    
	$exp=$order['pay_info']['exp_month'].$expyear;
	//per trustcommerce, if country is US, it should be left blank
	if($order['Bill_Addr']['Country_Display'] == "United States") {
		$country="";
		} else {
		$country=$order['Bill_Addr']['Country_Display'];
	}

// below section is for AIM method
if ($Payment_Gateway['Connection_Method'] == "Server to Server") {
	print "<div style='font-size: 12pt' >Please Wait On Moment While We process your card.<br><br>\n";
	
		
	// the keys below are the field names TrustCommerce requires
		$info['custid']=$Payment_Gateway['Account_Name'];
		$info['password']=$Payment_Gateway['Account_Password'];
		$info['action']="sale";
		$info['media']="cc";
		$info['cc']=$order['pay_info']['card_number'];		// card number, no dashes, no spaces
		$info['exp']=$exp;
		$info['amount']=$amount;			// charge amount in dollars (no international support yet)
		$info['name']=$order['Bill_Addr']['First_Name']." ".$order['Bill_Addr']['Last_Name']; 	// name of card holder
		$info['address1']=$order['Bill_Addr']['Street'];
		$info['address2']=$order['Bill_Addr']['Street_2'];
		$info['city']=$order['Bill_Addr']['City'];
		$info['state']=$order['Bill_Addr']['State_Abbrev'];
		$info['zip']=$order['Bill_Addr']['Postal_Code'];
		$info['country']=$country;
		$info['phone']=$order['Bill_Addr']['Phone'];
		$info['email']=$order['Bill_Addr']['Email_Address'];
		$info['ticket']=$order['number'];
		$info['shipto_name']=$order['Ship_Addr']['First_Name']." ".$order['Ship_Addr']['Last_Name'];
		$info['shipto_address1']=$order['Ship_Addr']['Street'];
		$info['shipto_address2']=$order['Ship_Addr']['Street_2'];
		$info['shipto_city']=$order['Ship_Addr']['City'];
		$info['shipto_state']=$order['Ship_Addr']['State_Abbrev'];
		$info['shipto_zip']=$order['Ship_Addr']['Postal_Code'];
		$info['shipto_country']=$order['Ship_Addr']['Country_Display'];
		
		
	// below field is for testing. remove remarks to test
		//$info['demo']="y";	
	
	// connect to trustcommerce server, and get results back in an array
		$result=ssl_connect("https://vault.trustcommerce.com/trans/",$info,1,0);
	
	//check status returned from trustcommerce, and act accordingly
		if($result['status'] == "approved"){
			print "
			<head>
			<meta http-equiv=\"Refresh\" content=\"0; URL=$Accepted_Return_URL\">
			</head>
			<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
			";
			} else {
				print "
				<head>
				<meta http-equiv=\"Refresh\" content=\"0; URL=$Declined_Return_URL\">
				</head>
				<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
				";
		}
}

if ($Payment_Gateway['Connection_Method'] == "Client side secure form POST") {
	// the keys below are the field names TrustCommerce requires
		print "
		$Final_Payment_Image
		<br>
		<form method=\"post\" action=\"https://vault.trustcommerce.com/trans\">
		<div class=\"cart_instruction\" >
			To complete your order, please click the button below.
		</div><br><br>
		<input type=\"hidden\" name=\"custid\" value=\"".$Payment_Gateway['Account_Name']."\">
		<input type=\"hidden\" name=\"password\" value=\"".$Payment_Gateway['Account_Password']."\">
		<input type=\"hidden\" name=\"action\" value=\"sale\">
		<input type=\"hidden\" name=\"media\" value=\"cc\">
		<input type=\"hidden\" name=\"cc\" value=\"".$order['pay_info']['card_number']."\">
		<input type=\"hidden\" name=\"exp\" value=\"$exp\">
		<input type=\"hidden\" name=\"amount\" value=\"$amount\">
		<input type=\"hidden\" name=\"name\" value=\"".$order['Bill_Addr']['First_Name']." ".$order['Bill_Addr']['Last_Name']."\">
		<input type=\"hidden\" name=\"address1\" value=\"".$order['Bill_Addr']['Street']."\">
		<input type=\"hidden\" name=\"address2\" value=\"".$order['Bill_Addr']['Street_2']."\">
		<input type=\"hidden\" name=\"city\" value=\"".$order['Bill_Addr']['City'].">
		<input type=\"hidden\" name=\"state\" value=\"".$order['Bill_Addr']['State_Abbrev']."\">
		<input type=\"hidden\" name=\"zip\" value=\"".$order['Bill_Addr']['Postal_Code']."\">
		<input type=\"hidden\" name=\"country\" value=\"$country\">
		<input type=\"hidden\" name=\"phone\" value=\"".$order['Bill_Addr']['Phone']."\">
		<input type=\"hidden\" name=\"email\" value=\"".$order['Bill_Addr']['Email_Address']."\">
		<input type=\"hidden\" name=\"ticket\" value=\"".$order['number']."\">
		<input type=\"hidden\" name=\"shipto_name\" value=\"".$order['Ship_Addr']['First_Name']." ".$order['Ship_Addr']['Last_Name']."\">
		<input type=\"hidden\" name=\"shipto_address1\" value=\"".$order['Ship_Addr']['Street']."\">
		<input type=\"hidden\" name=\"shipto_address2\" value=\"".$order['Ship_Addr']['Street_2']."\">
		<input type=\"hidden\" name=\"shipto_city\" value=\"".$order['Ship_Addr']['City']."\">
		<input type=\"hidden\" name=\"shipto_state\" value=\"".$order['Ship_Addr']['State_Abbrev']."\">
		<input type=\"hidden\" name=\"shipto_zip\" value=\"".$order['Ship_Addr']['Postal_Code']."\">
		<input type=\"hidden\" name=\"shipto_country\" value=\"".$order['Ship_Addr']['Country_Display']."\">
		<input type=\"submit\" value=\"Charge my Credit Card $".$order[grand_total]."\"><br>
		</form>
		";
}
?>




