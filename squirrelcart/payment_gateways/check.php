<?
$store_info = get_records("Store_Information",0,"record_number = \"1\"",0,0);
$store_info = $store_info[0];
$item_name = $store_info[Company_Name]." order";
$store_info[State] = get_field_val("States","Name","record_number = '$store_info[State_or_Province]'");
$store_info[Country] = get_field_val("Countries","Name","record_number = '$store_info[Country]'");
$url = $store_info[URL];
?>


<span class="header"><?=$Final_Payment_Image?></span><br><br>
Your order has been placed, and is in our database. <br>
To make payment, send a check or money order for <?=$SC[currency].$SC[order][grand_total]?> to:<br><br>
<?=$store_info[Company_Name]?><br>
<?=$store_info[Street]?><br>
<?
if ($store_info['Street_2']) print $store_info['Street_2']."<br>";
?>
<?=$store_info[City]?>, <?=$store_info[State]?><br><?=$store_info[Postal_Code]?>
<br><br>
		