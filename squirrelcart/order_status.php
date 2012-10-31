<?
// File added on 5/26/2003 to handle all logic for order status feature

if ($HTTP_GET_VARS['order_status']) {
	$order_status = "show_orders";
	// can't use this function if not logged in....so prompt for login if necessary
	if (!$SC['user']) {
		include $SC['cart_isp_root']."/login.php";
		return ;
	}
	if ($order_status == "show_orders") show_orders();
}
?>