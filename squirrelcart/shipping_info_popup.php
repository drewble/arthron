<?
// file added on 9/24/2003 for v1.2.0
//
// purpose of file is to handle displaying a popup window containing shipping details of an order already placed and in the db
include "config.php";
if ($HTTP_GET_VARS['order_rn']) {
	$Shipping_Details = get_field_val("Orders","Shipping_Details","record_number = $HTTP_GET_VARS[order_rn]");
	$Shipping_Details = nl2br($Shipping_Details);
	include $SC['templates']['shipping_info_popup'];
}
?>
