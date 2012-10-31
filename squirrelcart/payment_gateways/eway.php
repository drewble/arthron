<?
/*
 payment gateway module for eWay - www.eWay.com
 created on 11/16/03 for v1.3.0

 error codes, per http://eway.com.au:
	00..99 Defined by the bank These codes are returned by the bank. 
	A4 LINK ERR A link error has occurred between the bank and the modem. 
	A5 PINPAD OFFLINE The secure PIN Pad unit is not responding. 
	A6 SERVER BUSY No free PIN Pad slots were available to service the transaction request. 
	A7 INVALID MODE A generic interface request specified an illegal value in "Polled" field. 
	A8 INVALID AMOUNT An invalid amount was specified. 
	A9 INVALID CARD NUMBER An invalid card number was specified. 
	AA INVALID ACCOUNT An account invalid value for account was specified. 
	AB INVALID EXPIRY An invalid month or year was specified for expiry date. 
	AC CARD EXPIRED A past date was specified for expiry 
	AD ACCOUNT ERROR The specified account is not available on the server. 
	AE TIMEOUT A queued Authorisation timed-out. 
	AF RECORD NOT FOUND A journal lookup did not find the requested transaction. 
	B1 INVALID REQ TYPE An invalid request was received 
	  ERROR 03 There was a STAN mismatch 
	  ERROR 05 There was an incoming MAC error 
	  CARD UNSUPPORTED The card was not in the banks CPAT  
	  MESSAGE TYPE ERROR The message received was not expected 
	  MAXREQ EXCEEDED The maximum number of transactions from this OCX has been exceeded 
	X1 LINK FAIL NO DIAL TONE There is no phone line 
	  NO ANSWER The NAC did not answer the call 
	  NO CARRIER There was a lost connection or an incorrect call establishment 
	  CNP ERR xxyy A Tran$end CNP error was detected. xxyy represents the cause of the fault. 
	  DIAL ERR A failed dial has occurred. This may be an incorrect setting. 
	  PORT ERR The EFT-server cant talk to the modem 
	  NO PHONE NUMBER No configured phone number 
	U9 NO RESPONSE A valid response was not received in time from the Bank Host. 
	W6 NOT SUPPORTED The function requested is not supported by the OCV servers bank. 
*/

$pay_info = $order['pay_info']; // just shortens the variable a bit for ease of coding

//$xml_url = "https://www.eway.com.au/gateway/xmltest/testpage.asp"; // for testing of XML method ONLY!!
$xml_url = "https://www.eway.com.au/gateway/xmlpayment.asp"; // live gateway

$shared_url = "https://www.eway.com.au/gateway/payment.asp";

// beow section is for the cart returning when using Shared mode (non secure client post)
if ($cc_return == 4) {
	$status = $HTTP_POST_VARS['ewayTrxnStatus'];
	if ($status == "False") {
		$SC['payment_gateway_result']['error'] = "Error code: ".$HTTP_POST_VARS['eWAYresponseCode']."<br>".$HTTP_POST_VARS['eWAYresponseText'];
		$cc_return = 5;
	} 
	if ($status == "True") {
		$cc_return = 1;
	}
} else {

	// below section is for XML method
	if ($Payment_Gateway['Connection_Method'] == "Server to Server") {
		print "<div style='font-size: 12pt' >Please Wait One Moment While We process your card.<br><br>\n";
	
		$amount = str_replace(".","",$order['grand_total']); // amount must be in cents

		// format XML request
		$xml_req .= "<ewaygateway>";
		$xml_req .= "<ewayCustomerID>".$Payment_Gateway['Account_Name']."</ewayCustomerID>";
		$xml_req .= "<ewayTotalAmount>".$amount."</ewayTotalAmount>";
		$xml_req .= "<ewayCustomerFirstName>".$order['Bill_Addr']['First_Name']."</ewayCustomerFirstName>";
		$xml_req .= "<ewayCustomerLastName>".$order['Bill_Addr']['Last_Name']."</ewayCustomerLastName>";
		$xml_req .= "<ewayCustomerEmail>".$order['Bill_Addr']['Email_Address']."</ewayCustomerEmail>";
		$xml_req .= "<ewayCustomerAddress>".$order['Bill_Addr']['Street']."; ".$order['Bill_Addr']['Street_2']."</ewayCustomerAddress>";
		$xml_req .= "<ewayCustomerPostcode>".$order['Bill_Addr']['Postal_Code']."</ewayCustomerPostcode>";
		$xml_req .= "<ewayCustomerInvoiceDescription>".$order['Description']."</ewayCustomerInvoiceDescription>";
		$xml_req .= "<ewayCustomerInvoiceRef>".$order['number']."</ewayCustomerInvoiceRef>";
		$xml_req .= "<ewayCardHoldersName>".$pay_info['name_on_card']."</ewayCardHoldersName>";
		$xml_req .= "<ewayCardNumber>".$pay_info['card_number']."</ewayCardNumber>";
		// below is for testing....must use this number or you will get errors
		// $xml_req .= "<ewayCardNumber>4646464646464646</ewayCardNumber>";
		$xml_req .= "<ewayCardExpiryMonth>".$pay_info['exp_month']."</ewayCardExpiryMonth>";
		$xml_req .= "<ewayCardExpiryYear>".$pay_info['exp_year'][2].$pay_info['exp_year'][3]."</ewayCardExpiryYear>";
		$xml_req .= "<ewayTrxnNumber></ewayTrxnNumber>";
		$xml_req .= "<ewayOption1>0</ewayOption1>";
		$xml_req .= "<ewayOption2>0</ewayOption2>";
		$xml_req .= "<ewayOption3>0</ewayOption3>";
		$xml_req .= "</ewaygateway>";
	
		// connect to eWay server, post XML, and get results back in an array
		$result=xml_post_sc($xml_url,$xml_req);
	
		// in order to parse XML , we need an opening XML tag. eWay doesn't return one, so add it first:
		$result = str_replace("<ewayResponse>","<?xml version=\"1.0\"?><ewayResponse>",$result);
		$result = xml_parse_sc($result);
	
		$index = $result['index'];
		$vals = $result['vals'];
		$tree=get_xml_tree($vals);
		$status = $tree['EWAYRESPONSE'][0]['EWAYTRXNSTATUS'][0]['VALUE'];
		if ($status == "False") {
			// get error message
			$error = $tree['EWAYRESPONSE'][0]['EWAYTRXNERROR'][0]['VALUE'];
		}
	
		//check status returned from authorize.net, and act accordingly
		if($status == "True"){
			print "
			<head>
			<meta http-equiv=\"Refresh\" content=\"0; URL=$Accepted_Return_URL\">
			</head>
			<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
			";
		} else {
			$SC['payment_gateway_result']['error'] = $error;
			print "
			<head>
			<meta http-equiv=\"Refresh\" content=\"0; URL=$Error_Return_URL\">
			</head>
			<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
			";
		}
	}
	
	// below section is for Shared method
	if ($Payment_Gateway['Connection_Method'] != "Server to Server") {
		$amount = str_replace(".","",$order['grand_total']); // amount must be in cents
	?>
	<?=$Final_Payment_Image?>
	<br>
	<div class="cart_instruction">
		To complete your order, please click the button below.
	</div><br><br>
	
	<form method="post" action="<?=$shared_url?>">
		<input type="hidden" name="ewayCustomerID" value="<?=$Payment_Gateway['Account_Name']?>">
		<input type="hidden" name="ewayTotalAmount" value="<?=$amount?>">
		<input type="hidden" name="ewayCustomerFirstName" value="<?=$order['Bill_Addr']['First_Name'] ?>">
		<input type="hidden" name="ewayCustomerLastName" value="<?=$order['Bill_Addr']['Last_Name'] ?>">
		<input type="hidden" name="ewayCustomerEmail" value="<?=$order['Bill_Addr']['Email_Address'] ?>">
		<input type="hidden" name="ewayCustomerAddress" value="<?=$order['Bill_Addr']['Street'].",".$order['Bill_Addr']['Street_2'] ?>">
		<input type="hidden" name="ewayCustomerPostcode" value="<?=$order['Bill_Addr']['Postal_Code'] ?>">
		<input type="hidden" name="ewayCustomerInvoiceDescription" value="<?=$order['Description'] ?>">
		<input type="hidden" name="ewayCustomerInvoiceRef" value="<?=$order['number'] ?>">
		<input type="hidden" name="eWAYURL" value="<?=$SC['secure_cart_page']."?cc_return=4" ?>">
		<input type="hidden" name="eWAYAutoRedirect" value="1">

<!-- 		<input type="hidden" name="ewayOption3" value="TRUE"> -->	
		<input type="submit" value="Continue to Payment Form"><br>
	</form>

<?
 	}
 }
 ?>