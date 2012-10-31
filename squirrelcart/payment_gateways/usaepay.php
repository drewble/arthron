<?
// USAePay gateway file
// added on 10/25 for v1.1.0
// modified on 12/9/03 for updated USAePay API

print "<div style='font-size: 12pt' >Please Wait On Moment While We process your card.<br><br>\n";

// the keys below are the field names TrustCommerce requires
//  below field is for testing. set to 1 to test
	$info['UMtestmode']=0;
	$info['UMkey']=$Payment_Gateway['Account_Name'];
	$info['UMcard']=$order['pay_info']['card_number'];	// card number, no dashes, no spaces
	$info['UMexpir']=$order['pay_info']['exp_month'].$order['pay_info']['exp_year'];			// expiration date 4 digits no /
	$info['UMcvv2']=$order['pay_info']['cvv2'];
	$info['UMamount']=$order['grand_total'];			// charge amount in dollars (no international support yet)
	$info['UMinvoice']=$order['number'];   		// invoice number.  must be unique.
	$info['UMname']=$order['Bill_Addr']['First_Name']." ".$order['Bill_Addr']['Last_Name']; 	// name of card holder

	$info['UMbillfname']=$order['Bill_Addr']['First_Name'];
	$info['UMbilllfame']=$order['Bill_Addr']['Last_Name'];
	$info['UMbillcompany']=$order['Bill_Addr']['Company'];
	$info['UMbillstreet']=$order['Bill_Addr']['Street'];
	$info['UMbillstreet2']=$order['Bill_Addr']['Street_2'];
	$info['UMbillcity']=$order['Bill_Addr']['City'];
	$info['UMbillstate']=$order['Bill_Addr']['State_Abbrev'];
 	$info['UMbillzip']=$order['Bill_Addr']['Postal_Code'];
 	$info['UMbillphone']=$order['Bill_Addr']['Phone'];
 	$info['UMemail']=$order['Bill_Addr']['Email_Address'];

	$info['UMshipfname']=$order['Ship_Addr']['First_Name'];
	$info['UMshiplfame']=$order['Ship_Addr']['Last_Name'];
	$info['UMshipcompany']=$order['Ship_Addr']['Company'];
	$info['UMshipstreet']=$order['Ship_Addr']['Street'];
	$info['UMshipstreet2']=$order['Ship_Addr']['Street_2'];
	$info['UMshipcity']=$order['Ship_Addr']['City'];
	$info['UMshipstate']=$order['Ship_Addr']['State_Abbrev'];
 	$info['UMshipzip']=$order['Ship_Addr']['Postal_Code'];
 	$info['UMshipphone']=$order['Ship_Addr']['Phone'];

	$info['UMdescription']=$order['Description'];	// description of charge
	// below is set only if CVV2 code was submitted at checkout
	if ($order['pay_info']['cvv2']) $info['UMcvv2'] = $order['pay_info']['cvv2'];
	$info['UMip']=$REMOTE_ADDR;
	$info['UMcustemail']=$order['Bill_Addr']['Email_Address'];

// connect to USAePay server, and get results back in an array
	$result=ssl_connect("https://www.usaepay.com/secure/gate.php",$info,1,0);

//check status returned from trustcommerce, and act accordingly

// the below line changed because USAePay seems to be sending only a single letter code using UMresult, even thoug their documentation says it should be 
// in UMresultcode
	if($result['UMresult'] == "A" || $result['UMstatus'] == "Approved"){
		print "
		<head>
		<meta http-equiv=\"Refresh\" content=\"0; URL=$Accepted_Return_URL\">
		</head>
		<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
		";
	}
	
	if($result['UMresult'] == "D" || $result['UMstatus'] == "Declined"){
		print "
		<head>
		<meta http-equiv=\"Refresh\" content=\"0; URL=$Declined_Return_URL\">
		</head>
		<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
		";
	}

	if($result['UMresult'] == "E" || $result['UMstatus'] == "Error" || !$result['UMresult']){
		print "
		<head>
		<meta http-equiv=\"Refresh\" content=\"0; URL=$Error_Return_URL\">
		</head>
		<font size=\"2\" face=\"tahoma\"><b>Processing...</b></font><br>
		";
	}
?>