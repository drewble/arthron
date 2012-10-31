<?
// file is a modified v1.0.9 file to support Squirrelcart EULAs
if(($shipping_method || $shipping_method_x) && $SC['order']['number_of_items']) {
	if(!isset($remove) && !$update_cart_x) 	get_shipping_method();
 }
?>