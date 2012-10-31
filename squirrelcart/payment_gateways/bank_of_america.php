<?
/*
 this file is used to send payment information
 to Bank of America's payment gateway
 information used to create this file obtained at the following URL:
 http://www.bankofamerica.com/merchantservices/index.cfm?template=merch_ic_estores_developer.cfm&orig=settle
 file added 9/29/02 for v1.0.9

a few notes on Bank of America:
Bank of America will present the customer with a page to confirm all information. they then click "process" and then, 1 of 2 things can happen:

1. they are automatically redirected back to your site
2. they stay on BOA site and are given message as to status of order 

The first option is the best, and the default for Squirrelcart. It requires that you go into your configuration options for your account with Bank of America, 
and specify the appropriate return URLs. They are:
	approval:  http://YOURSITE.COM/yourcartpage.php?cc_return=1
	failure:  http://YOURSITE.COM/yourcartpage.php?cc_return=2
The cart will place the order into the DB, send out confirmation emails, and empty the cart ONLY upon return to the approval URL.

If you decide to use the second option instead, then you need to make sure that the "Return to Storefront" option is not enabled in Squirrelcart 
for the payment gateway.
*/
?>

<?=$Final_Payment_Image?>
<br>
<form method="post" name="PaymentInfo" action="https://cart.bamart.com/payment.mart">
<span class="cart_instruction" >To complete your order, please click the button below to be taken to our final confirmation page.</span><br><br>

<input type="hidden" name="ioc_merchant_id" value="<?=$Payment_Gateway['Account_Name'] ?>">

<input type="hidden" name="ioc_merchant_order_id" value="<?=$order['number'] ?>">
<input type="hidden" name="ioc_order_total_amount" value="<?=$order['grand_total'] ?>">

<input type="hidden" name="ecom_billto_postal_name_first" value="<?=$order['Bill_Addr']['First_Name'] ?>">
<input type="hidden" name="ecom_billto_postal_name_last" value="<?=$order['Bill_Addr']['Last_Name'] ?>">
<input type="hidden" name="ecom_billto_postal_street_line1" value="<?=$order['Bill_Addr']['Street']?>">
<input type="hidden" name="ecom_billto_postal_street_line2" value="<?=$order['Bill_Addr']['Street_2']?>">
<input type="hidden" name="ioc_billto_business_name" value="<?=$order['Bill_Addr']['Company'] ?>">
<input type="hidden" name="ecom_billto_postal_city" value="<?=$order['Bill_Addr']['City'] ?>">
<input type="hidden" name="ecom_billto_postal_stateprov" value="<?=$order['Bill_Addr']['State_Abbrev'] ?>">
<input type="hidden" name="ecom_billto_postal_postalcode" value="<?=$order['Bill_Addr']['Postal_Code'] ?>">
<input type="hidden" name="ecom_billto_postal_countrycode" value="<?=$order['Bill_Addr']['Country_Alpha_2'] ?>">
<input type="hidden" name="ecom_billto_telecom_phone_number" value="<?=$order['Bill_Addr']['Phone'] ?>">

<!-- note - email address seems to be required by Bank of America -->
<input type="hidden" name="ecom_billto_online_email" value="<?=$order['Bill_Addr']['Email_Address'] ?>">

<input type="hidden" name="ecom_payment_card_name" value="<?=$order['Bill_Addr']['First_Name']." ".$order['Bill_Addr']['Last_Name']?>">
<input type="hidden" name="ecom_payment_card_number" value="<?=$order['pay_info']['card_number'] ?>">
<input type="hidden" name="ecom_payment_card_expdate_month" value="<?=$order['pay_info']['exp_month']?>">
<input type="hidden" name="ecom_payment_card_expdate_year" value="<?=$order['pay_info']['exp_year']?>">


<input type=submit value="Finalize Order for $<?=$order['grand_total'] ?>"><br>

</form>