<?
// file modified on 5/10/2003 for v1.1.1 to fix non secure form post problem. see comments above the call to urlencode_all
?>
<?=$Final_Payment_Image?>
<br>
<?
if ($Payment_Gateway['Connection_Method'] == "Client side non-secure form POST") {
	// below fixes a problem reported in a helpdesk post. 2Checkout for some reason converts the POSTed data
	// to a GET in the URL, and seems to miss certain characters, like the # sign. This causes all information after
	// the non encoded illegal character to be lost. This will urlencode the data before it's posted
	$order = urlencode_all($order);
?>
<form action="https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c" method="post">
<span class="cart_instruction" >To complete your order, please click the button below. This process may take up to 1 minute. Please do not click more than once.</span><br><br>
<input type=HIDDEN name="sid" value="<?=$Payment_Gateway[Account_Name] ?>">
<input type=HIDDEN name="total" value="<?=$order[grand_total] ?>">
<input type=HIDDEN name="cart_order_id" value="<?=$order[number] ?>">
<input type=submit value="Finalize order for $<?=$order[grand_total] ?>"><br>
<input type=HIDDEN name="card_holder_name" value="<?=$order[Bill_Addr][First_Name] ?> <?=$order[Bill_Addr][Last_Name] ?>">
<input type=HIDDEN name="street_address" value="<?=$order[Bill_Addr][Street].",".$order[Bill_Addr][Street_2] ?>">
<input type=HIDDEN name="city" value="<?=$order[Bill_Addr][City] ?>">
<input type=HIDDEN name="state" value="<?=$order[Bill_Addr][State_Abbrev] ?>">
<input type=HIDDEN name="zip" value="<?=$order[Bill_Addr][Postal_Code] ?>">
<input type=HIDDEN name="country" value="<?=$order[Bill_Addr][Country_Display] ?>">
<input type=HIDDEN name="email" value="<?=$order[Bill_Addr][Email_Address] ?>">
<input type=HIDDEN name="phone" value="<?=$order[Bill_Addr][Phone] ?>">
<input type=HIDDEN name="ship_name" value="<?=$order[Ship_Addr][First_Name] ?> <?=$order[Ship_Addr][Last_Name] ?>">
<input type=HIDDEN name="ship_street_address" value="<?=$order[Ship_Addr][Street].",".$order[Ship_Addr][Street_2] ?>">
<input type=HIDDEN name="city" value="<?=$order[Ship_Addr][City] ?>">
<input type=HIDDEN name="state" value="<?=$order[Ship_Addr][State_Abbrev] ?>">
<input type=HIDDEN name="zip" value="<?=$order[Ship_Addr][Postal_Code] ?>">
<input type=HIDDEN name="country" value="<?=$order[Ship_Addr][Country_Display] ?>">
</form>

<?
}
if ($Payment_Gateway['Connection_Method'] == "Client side secure form POST") {
?>
<form method=POST action="https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c">
<span class="cart_instruction" >To complete your order, please click the button below.</span><br><br>
<input type=submit value="Finalize order for $<?=$order[grand_total] ?>"><br>
<input type=HIDDEN name="x_Version" value="3.0">
<input type=HIDDEN name="x_Test_Request" value="">
<input type=HIDDEN name="x_Login" value="<?=$Payment_Gateway[Account_Name] ?>">
<input type=HIDDEN name="x_Show_Form" "value="">
<input type=HIDDEN name="x_Card_Num" value="<?=$order[pay_info][card_number] ?>">
<input type=HIDDEN name="x_Exp_Date" value="<?=$order[pay_info][exp_month]."/".$order[pay_info][exp_year] ?>">
<input type=HIDDEN name="x_Card_Num" value="<?=$order[pay_info][cvv] ?>">
<input type=HIDDEN name="x_First_Name" value="<?=$order[Bill_Addr][First_Name] ?>">
<input type=HIDDEN name="x_Last_Name" value="<?=$order[Bill_Addr][Last_Name] ?>">
<input type=HIDDEN name="x_Company" value="<?=$order[Bill_Addr][Company] ?>">
<input type=HIDDEN name="x_Address" value="<?=$order[Bill_Addr][Street].",".$order[Bill_Addr][Street_2] ?>">
<input type=HIDDEN name="x_City" value="<?=$order[Bill_Addr][City] ?>">
<input type=HIDDEN name="x_State" value="<?=$order[Bill_Addr][State_Abbrev] ?>">
<input type=HIDDEN name="x_Zip" value="<?=$order[Bill_Addr][Postal_Code] ?>">
<input type=HIDDEN name="x_Country" value="<?=$order[Bill_Addr][Country_Display] ?>">
<input type=HIDDEN name="x_Phone" value="<?=$order[Bill_Addr][Phone] ?>">
<input type=HIDDEN name="x_Email" value="<?=$order[Bill_Addr][Email_Address] ?>">
<input type=HIDDEN name="x_Ship_To_First_Name" value="<?=$order[Ship_Addr][First_Name] ?>">
<input type=HIDDEN name="x_Ship_To_Last_Name" value="<?=$order[Ship_Addr][Last_Name] ?>">
<input type=HIDDEN name="x_Ship_To_Company" value="<?=$order[Ship_Addr][Company] ?>">
<input type=HIDDEN name="x_Ship_To_Address" value="<?=$order[Ship_Addr][Street].",".$order[Ship_Addr][Street_2] ?>">
<input type=HIDDEN name="x_Ship_To_City" value="<?=$order[Ship_Addr][City] ?>">
<input type=HIDDEN name="x_Ship_To_State" value="<?=$order[Ship_Addr][State_Abbrev] ?>">
<input type=HIDDEN name="x_Ship_To_Zip" value="<?=$order[Ship_Addr][Postal_Code] ?>">
<input type=HIDDEN name="x_Ship_To_Country" value="<?=$order[Ship_Addr][Country_Display] ?>">
<input type=HIDDEN name="x_Amount" value="<?=$order[grand_total] ?>">
<input type=HIDDEN name="x_Cust_ID" value="">
<input type=HIDDEN name="x_Description" value="<?=$order[Description] ?>">
<input type=HIDDEN name="x_Invoice_Num" value="<?=$order[number] ?>">
<input type=HIDDEN name="x_Logo_URL" value="<?=$SC[site_secure_root] ?>/images/logo_banner.jpg">
<input type=HIDDEN name="x_Color_Background" value="#FFFFFF">
<input type=HIDDEN name="x_Header_Html_Receipt" 
value="<div WIDTH=100% align=center>Thanks for your order!">
<input type=HIDDEN name="x_Footer_Html_Receipt" value="</div>">
</form>
<? } ?>