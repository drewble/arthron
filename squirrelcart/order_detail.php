<?
// file added on 5/26/2003 to handle displaying an order to customer via "order status" link
// trigger for this is $order_detail=order_number in the URL
if ($HTTP_GET_VARS['order_detail']) {
	// check to see if order really exists, and belongs to customer
	$order_rn = $HTTP_GET_VARS['order_detail'];
	$user_rn = $SC['user']['record_number'];
	$order_exists = get_field_val("Orders","Order_Number","record_number = '$order_rn' AND Ordered_By = '$user_rn'");
	if (security_level("Store_Admin")) $order_exists = 1; // if store admin, than allow them to see all orders, even if they don't belong to them
	if ($order_exists) {
		order_detail($order_rn);
	}
}
?>