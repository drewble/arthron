<?
/*
 payment gateway module for Authorize.net
 created on 12/11/02 for v1.1.0
 update to be applied to v1.0.9 made on 2/4/2003
 updated on 2/25/03 to fix incorrect transaction URL, and other problems
 file modified on 7/15/2003 for v1.2 to fix session loss when not using cookies
 file modified on 7/31/2003 to support SIM connection method
*/

$pay_info = $order['pay_info']; // just shortens the variable a bit for ease of coding


// below section is for AIM method
if ($Payment_Gateway['Connection_Method'] == "Server to Server") {
	print "<div style='font-size: 12pt' >Please Wait One Moment While We process your card.<br><br>\n";
// the keys below are the field names TrustCommerce requires
	// below are minimum required fields for any AIM transaction
		$info['x_Version'] = "3.1";
		$info['x_Delim_Data'] = "True";
		$info['x_relay_response'] = "FALSE";
		$info['x_Login'] = $Payment_Gateway['Account_Name']; // merchant's login ID
		if($Payment_Gateway['Authenticate_With'] == 1){ // merchant chose to use password
			$info['x_Password'] = $Payment_Gateway['Account_Password'];
		}
		if($Payment_Gateway['Authenticate_With'] == 2){ // merchant chose to use transaction key
			$info['x_Tran_Key'] = $Payment_Gateway['Account_Transaction_Key'];
		}
		$info['x_Amount']=$order['grand_total'];

	// below are minimum required fields for credit card transaction
		if($SC['pay_info']['is_cc']) {
			$info['x_Card_Num'] = $pay_info['card_number'];		// card number, no dashes, no spaces
			$info['x_Exp_Date'] = $pay_info['exp_month'].$pay_info['exp_year'];
			if(!$Payment_Gateway['Transaction_Type']) {
				$info['x_Type']  = "AUTH_CAPTURE";
			} else {
					$info['x_Type'] = $Payment_Gateway['Transaction_Type'];
			}
			$info['x_Method'] = "CC";
		}
	// below is set only if CVV2 code was submitted at checkout
		if ($pay_info['cvv2']) $info['x_Card_Code'] = $pay_info['cvv2'];
	// in AIM doc, it says card code is optional, but it will not take transaction without one!
	//	$info['x_Card_Code'] = "111";
		
	// below section contains fields required for echeck transactions
		if($SC['pay_info']['is_echeck']) {
			$info['x_Bank_ABA_Code'] = $pay_info['bank_routing_number'];
			$info['x_Bank_Acct_Num'] = $pay_info['bank_account_number'];
			$info['x_Bank_Acct_Type'] = $pay_info['bank_account_type'];
			$info['x_Bank_Name'] = $pay_info['bank_name'];
			$info['x_Bank_Account_Name'] = $pay_info['bank_account_name'];
			$info['x_Type']  = "AUTH_CAPTURE";
			$info['x_Method'] = "ECHECK";
		}

		
	// address and order info
		$info['x_First_Name'] = $order['Bill_Addr']['First_Name'];
		$info['x_Last_Name'] = $order['Bill_Addr']['Last_Name'];
		$info['x_Company'] = $order['Bill_Addr']['Company'];
		$info['x_Address'] = $order['Bill_Addr']['Street']."; ".$order['Bill_Addr']['Street_2'];
		$info['x_City'] = $order['Bill_Addr']['City'];
		$info['x_State'] = $order['Bill_Addr']['State_Abbrev'];
		$info['x_Zip'] = $order['Bill_Addr']['Postal_Code'];
		$info['x_Country'] = $order['Bill_Addr']['Country_Display'];
		$info['x_Phone'] = $order['Bill_Addr']['Phone'];
		$info['x_Customer_IP'] = $REMOTE_ADDR;
		$info['x_Email'] = $order['Bill_Addr']['Email_Address'];
		$info['x_Invoice_Num'] = $order['number'];
		$info['x_Description'] = $order['Description'];
		$info['x_Ship_To_First_Name'] = $order['Ship_Addr']['First_Name'];
		$info['x_Ship_To_Last_Name'] = $order['Ship_Addr']['Last_Name'];
		$info['x_Ship_To_Company'] = $order['Ship_Addr']['Company'];
		$info['x_Ship_To_Address'] = $order['Ship_Addr']['Street']."; ".$order['Ship_Addr']['Street_2'];
		$info['x_Ship_To_City'] = $order['Ship_Addr']['City'];
		$info['x_Ship_To_State'] = $order['Ship_Addr']['State_Abbrev'];
		$info['x_Ship_To_Zip'] = $order['Ship_Addr']['Postal_Code'];
		$info['x_Ship_To_Country'] = $order['Ship_Addr']['Country_Display'];
	

// connect to Authorize.net server, and get results back in an array
	$result=ssl_connect("https://secure.authorize.net/gateway/transact.dll",$info,0,0,30,1);

$result = $result[0];

if($result) {
	$values = explode(",",$result);
	$new_result['Response_String'] = $result;
	$new_result['Response_Code'] = $values[0];
	$new_result['Response_Subcode'] = $values[1];
	$new_result['Response_Reason_Code'] = $values[2];
	$new_result['Response_Reason_Text'] = $values[3];
	$new_result['Approval_Code'] = $values[4];
	$new_result['AVS_Result_Code'] = $values[5];
	$new_result['Transaction_ID'] = $values[6];
	$new_result['MD5_Hash'] = $values[37];
	$new_result['Card_Code_Response'] = $values[38];
	$result = $new_result;
	$SC['payment_gateway_result'] = $result;
}



//check status returned from authorize.net, and act accordingly


	if($result['Response_Code'] == "1"){
		print "
		<head>
		<meta http-equiv=\"Refresh\" content=\"0; URL=$Accepted_Return_URL\">
		</head>
		<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
		";
		} else {
			if($result['Response_Code'] == "2") {
				print "
				<head>
				<meta http-equiv=\"Refresh\" content=\"0; URL=$Declined_Return_URL\">
				</head>
				<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
				";
			} else {
				if($result['Response_Code'] == "3" || !$result['Response_Code']) {
					$SC['payment_gateway_result']['error'] = $SC['payment_gateway_result']['Response_Reason_Text'];
					print "
					<head>
					<meta http-equiv=\"Refresh\" content=\"0; URL=$Error_Return_URL\">
					</head>
					<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
					";
				}
		}
	}
}
// below section is for SIM connection method
// function code below is from Authorize.net
//
// --------- Start of Authorize.net provided functions-----------------------------
//
// DISCLAIMER:
//     This code is distributed in the hope that it will be useful, but without any warranty; 
//     without even the implied warranty of merchantability or fitness for a particular purpose.
// Main Interfaces:
//
// function InsertFP ($loginid, $txnkey, $amount, $sequence) - Insert HTML form elements required for SIM
// function CalculateFP ($loginid, $txnkey, $amount, $sequence, $tstamp) - Returns Fingerprint.
// compute HMAC-MD5
// Uses PHP mhash extension. Pl sure to enable the extension
//
//authorize.net's hmac function required the mhash library, and the one below it doesn't :)
//function hmac ($key, $data) {
//		return (bin2hex (mhash(MHASH_MD5, $data, $key)));
//}
function hmac ($key, $data)
{
   // RFC 2104 HMAC implementation for php.
   // Creates an md5 HMAC.
   // Eliminates the need to install mhash to compute a HMAC
   // Hacked by Lance Rushing

   $b = 64; // byte length for md5
   if (strlen($key) > $b) {
       $key = pack("H*",md5($key));
   }
   $key  = str_pad($key, $b, chr(0x00));
   $ipad = str_pad('', $b, chr(0x36));
   $opad = str_pad('', $b, chr(0x5c));
   $k_ipad = $key ^ $ipad ;
   $k_opad = $key ^ $opad;
   return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
}
// Calculate and return fingerprint
// Use when you need control on the HTML output
function CalculateFP ($loginid, $txnkey, $amount, $sequence, $tstamp, $currency = "") {
	return (hmac ($txnkey, $loginid . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . $currency));
}
// Inserts the hidden variables in the HTML FORM required for SIM
// Invokes hmac function to calculate fingerprint.
function InsertFP ($loginid, $txnkey, $amount, $sequence, $currency = ""){
	$tstamp = time ();
	$fingerprint = hmac ($txnkey, $loginid . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . $currency);
	echo ('<input type="hidden" name="x_fp_sequence" value="' . $sequence . '">' );
	echo ('<input type="hidden" name="x_fp_timestamp" value="' . $tstamp . '">' );
	echo ('<input type="hidden" name="x_fp_hash" value="' . $fingerprint . '">' );
	return (0);
}
// --------- End of Authorize.net provided functions-----------------------------

if ($Payment_Gateway['Connection_Method'] != "Server to Server") {
?>
<?=$Final_Payment_Image?>
<br>
<div class="cart_instruction">
	To complete your order, please click the button below.
</div><br><br>

<form method="post" action="https://secure.authorize.net/gateway/transact.dll">
	<? InsertFP ($Payment_Gateway['Account_Name'],$Payment_Gateway['Account_Transaction_Key'],$order['grand_total'],$order['number']) ?>
	<input type="hidden" name="x_login" value="<?=$Payment_Gateway['Account_Name'] ?>">
	<input type="hidden" name="x_amount" value="<?=$order['grand_total']?>">
	<input type="hidden" name="x_version" value="3.1">
	<!-- remove comment for testing
		<input type="hidden" name="x_test_request" value="TRUE">
	-->
	

<? if ($Payment_Gateway['Connection_Method'] == "Client side non-secure form POST") { ?>
	<input type="hidden" name="x_show_form" value="PAYMENT_FORM">
	<input type=submit value="Finalize order for $<?=$order['grand_total'] ?>">
<? } else { ?>
	<input type="hidden" name="x_first_name" value="<?=$order['Bill_Addr']['First_Name'] ?>">
	<input type="hidden" name="x_last_name" value="<?=$order['Bill_Addr']['Last_Name'] ?>">
	<input type="hidden" name="x_company" value="<?=$order['Bill_Addr']['Company'] ?>">
	<input type="hidden" name="x_address" value="<?=$order['Bill_Addr']['Street'].",".$order['Bill_Addr']['Street_2'] ?>">
	<input type="hidden" name="x_city" value="<?=$order['Bill_Addr']['City'] ?>">
	<input type="hidden" name="x_state" value="<?=$order['Bill_Addr']['State_Abbrev'] ?>">
	<input type="hidden" name="x_zip" value="<?=$order['Bill_Addr']['Postal_Code'] ?>">
	<input type="hidden" name="x_country" value="<?=$order['Bill_Addr']['Country_Alpha_2'] ?>">
	<input type="hidden" name="x_phone" value="<?=$order['Bill_Addr']['Phone'] ?>">
	<input type="hidden" name="x_customer_ip" value="<?=$REMOTE_ADDR?>">
	<input type="hidden" name="x_email" value="<?=$order['Bill_Addr']['Email_Address'] ?>">
	<input type="hidden" name="x_invoice_num" value="<?=$order['number'] ?>">
	<input type="hidden" name="x_description" value="<?=$order['Description'] ?>">
	<input type="hidden" name="x_ship_to_first_name" value="<?=$order['Ship_Addr']['First_Name'] ?>">
	<input type="hidden" name="x_ship_to_last_name" value="<?=$order['Ship_Addr']['Last_Name'] ?>">
	<input type="hidden" name="x_ship_to_company" value="<?=$order['Ship_Addr']['Company'] ?>">
	<input type="hidden" name="x_ship_to_address" value="<?=$order['Ship_Addr']['Street'].",".$order['Ship_Addr']['Street_2'] ?>">
	<input type="hidden" name="x_ship_to_city" value="<?=$order['Ship_Addr']['City'] ?>">
	<input type="hidden" name="x_ship_to_state" value="<?=$order['Ship_Addr']['State_Abbrev'] ?>">
	<input type="hidden" name="x_ship_to_zip" value="<?=$order['Ship_Addr']['Postal_Code'] ?>">
	<input type="hidden" name="x_ship_to_country" value="<?=$order['Ship_Addr']['Country_Alpha_2'] ?>">
<? 
	if($SC['pay_info']['is_cc']) { 
		$x_method = "CC";
		if(!$Payment_Gateway['Transaction_Type']) {
			$x_type  = "AUTH_CAPTURE";
		} else {
			$x_type = $Payment_Gateway['Transaction_Type'];
		}
?>
		<input type="hidden" name="x_card_num" value="<?=$pay_info['card_number']?>">
		<input type="hidden" name="x_exp_date" value="<?=$pay_info['exp_month'].$pay_info['exp_year']?>">
<?
	// below is set only if CVV2 code was submitted at checkout
		if ($pay_info['cvv2']) print "<input type=\"hidden\" name=\"x_card_code\" value=\"".$pay_info['cvv2']."\">";
 	} 

	if($SC['pay_info']['is_echeck']) { 
		$x_method = "ECHECK";
		$x_type  = "AUTH_CAPTURE";
		?>
		<input type="hidden" name="x_bank_aba_code" value="<?=$pay_info['bank_routing_number']?>">
		<input type="hidden" name="x_bank_acct_num" value="<?=$pay_info['bank_account_number']?>">
		<input type="hidden" name="x_bank_acct_type" value="<?=$pay_info['bank_account_type']?>">
		<input type="hidden" name="x_bank_name" value="<?=$pay_info['bank_name']?>">
		<input type="hidden" name="x_bank_acct_name" value=<?=$pay_info['bank_account_name']?>">
<?
	}
 ?>
	<input type="hidden" name="x_method" value="<?=$x_method?>">
	<input type="hidden" name="x_type" value="<?=$x_type?>">
	<input type="submit" value="Charge my Credit Card $<?=$order['grand_total']?>"><br>
</form>
<? 
} 	
}
?>
