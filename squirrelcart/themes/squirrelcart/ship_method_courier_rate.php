<!--
	template file: ship_method_courier_rate
	This template controls the appearance of a single rate selection on the shipping method selection page
-->
<input type="radio" name="ship_method" value="<?=$Option_Value?>">
<a href="#" style="text-decoration: none" onclick="cart.ship_method[<?=$Option_Number?>].checked = true">
	<?=$Option_Display?>
</a>
<br><br>

