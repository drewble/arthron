<?=$Logged_in_Message?>
<br><br><?=$Logout_Link ?><br>
<br><?=$Account_Details_Link ?><br>

<!-- do not remove or modify the below line!!!! -->
<? if ($Show_Order_Status) { ?>
<br><a href="<?=$Order_Status_HREF?>">Order Status</a><br>
<!-- do not remove or modify the below line!!!! -->
<? } ?>

<!-- do not remove or modify the below line!!!! -->
<? if ($UPS_Tracking_HREF) { ?>
<br><a href="<?=$UPS_Tracking_HREF?>">UPS Tracking</a><br>
<!-- do not remove or modify the below line!!!! -->
<? } ?>
<br>

<?=$Change_Theme?>

