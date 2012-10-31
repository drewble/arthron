<?
/*
 payment gateway module for WorldPay
 created on 10/02/02 for v1.0.9
 file modified on 7/15/2003 for v1.1.1 to fix session loss when not using cookies


note: the field named MC_callback in the form below will tell WorldPay what page to perform a callback to.
This is not a browser redirect. WorldPay will send all order status info to this URL, and if 
the URL returns text in the form of an HTML page, it will display it,
replacing certain variables with values based on transaction status. Integration information 
was obtained here: 
	http://support.worldpay.com/kb/integration_guides/junior/quickstep/help/quickstep_guide.html

In order for this to work, the merchant MUST enable the following in their WorldPay admin panel:
URL to control panel is http://select.worldpay.com/wcc/admin

settings needed for this to work:
	Callback URL:						<WPDISPLAY ITEM=MC_callback>
	Callback enabled:				  must be checked.
	Use callback response: 		   must be checked

note: cc_return=4 will tell the cart to include the payment gateway file (the one you are reading now!!) again, for special 
post transaction processing
*/


// if cc_return is 4, than gateway is returning here to run some more code. read comments about cc_return in cart.php
if($cc_return != 4){

// display form to user in order to submit order info to WorldPay
?>

<?=$Final_Payment_Image?>
<br>
<form action="https://select.worldpay.com/wcc/purchase" method=POST> 
<span class="cart_instruction" >To complete your order, please click the button below.</span><br><br>
<input type=hidden name="instId" value="<?=$Payment_Gateway[Account_Name] ?>"> 
<input type=hidden name="cartId" value="<?=$order[number] ?>"> 
<input type=hidden name="amount" value="<?=$order[grand_total] ?>"> 
<input type=hidden name="currency" value="USD"> 
<input type=hidden name="desc" value="<?=$order[Description] ?>"> 


<!--
<input type=hidden name="testMode" value="100">
field used for testing. 100 will be successful, 101 will be a failure
 -->
<input type=hidden name="name" value="<?=$order[Bill_Addr][First_Name]." ".$order[Bill_Addr][Last_Name] ?>"> 
<?
$street_addr = $order['Bill_Addr']['Street'];
if ($order['Bill_Addr']['Street_2']) $street_addr = $street_addr."\n".$order['Bill_Addr']['Street_2'];
$street_addr = $street_addr."\n".$order['Bill_Addr']['City'].", ".$order['Bill_Addr']['State_Abbrev']." ".$order['Bill_Addr']['Postal_Code'];
?>
<input type=hidden name="address" value="<?=$street_addr?>"> 
<input type=hidden name="postcode" value="<?=$order[Bill_Addr][Postal_Code] ?>"> 
<input type=hidden name="country" value="US"> 
<input type=hidden name="tel" value="<?=$order[Bill_Addr][Phone] ?>"> 
<input type=hidden name="email" value="<?=$order[Bill_Addr][Email_Address] ?>"> 
<INPUT TYPE=HIDDEN NAME=MC_callback VALUE="<?=$SC['www_cart_page']?>?cc_return=4<? print $SC['SID']?>">
<input type=submit value="Continue to our Payment Processor, WorldPay"><br><br>
We use WorldPay to accept secure payments via credit card. <br>
</form>

<?
// if here, than the form above was already posted to WorldPay. Customer filled out info, and was redirected back to the cart page using the URL specified in the form
// field MC_callback. The variable cc_return was set to 'gw', which is what is causing the code to include this payment gateway file again, in cart.php
// The code below is necessary in order to finish the transaction, ie:
// empty the cart, write it to the DB, send the emails out, etc....
// WorldPay sends variables back to the cart, including $transStatus, which is either Y or C (yes, or canceled)
 } else {
 	if($transStatus == "Y") $cc_return=1; // successful transaction, according to WorldPay
	if($transStatus == "C") $cc_return=3; // canceled transaction, according to WorldPay
	// note - failed transactions stay at WorldPay's site to reenter CC info
	
	print "
	<html><head>
		<meta http-equiv=\"Refresh\" content=\"10; URL=".$SC['www_cart_page']."?cc_return=$cc_return$SC[SID]\">
	</head>
	<body>
	
	<WPDISPLAY FILE=header.html>
	Here are the results of your transaction:<br>
	<wpdisplay item=banner default=\"\"><br>
	Please wait while we return you to our site...important note: you must return to our site for your order to be entered into our DB. If your browser does not automatically return you to our site, please
	click <a href=\"".$SC['www_cart_page']."?cc_return=$cc_return$SC[SID]\">here</a>.
	<WPDISPLAY FILE=footer.html>
	</body>
	</html>";
	die;
}
?> 