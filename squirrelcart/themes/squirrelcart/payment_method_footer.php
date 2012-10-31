<!-- template file: payment_method_footer -->
<br><br>
<!-- the section below does not display unless you are using a payment gateway connection method that is "Server to Server" -->
<!-- do not remove or modify the next line below! -->
<? if ($GW_Connection_Method == "Server to Server") { ?>
	<br>
	<b>Important note:</b> Do not click this button more than once.<br>
	It may take up to 30 seconds for our payment processor to respond.
<!-- do not remove or modify the line below! -->
<? } ?>
<br><br>
<?=$Submit_Button?>
</form>
<br>
<br>
