<?
$paypal_email = get_field_val("Payment_Methods","PayPal_Email","Name = 'PayPal'");
$store_info = get_records("Store_Information",0,"record_number = \"1\"",0,0);
$item_name = $store_info[0][Company_Name]." order # ".$order['number'];
$url = $store_info[0][URL];
?>


<span class="header"><?=$Final_Payment_Image?></span><br><br>
Your order has been placed, and is in our database. <br>
To continue, click the button below to submit payment via PayPal. <br>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?=$paypal_email ?>">
<input type="hidden" name="item_name" value="<?=$item_name?>">
<input type="hidden" name="amount" value="<?=$SC[order][grand_total] ?>">
<input type="hidden" name="shipping" value="">
<input type="hidden" name="return" value="<?=$url ?>">
<input type="hidden" name="cancel_return" value="<?=$url ?>">
<input type="hidden" name="no_note" value="1">
<input type="image" src="<?=$PayPal_Button?>" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
		