<?
// file modified on 8/4/2003 for v1.2 - moved check for $show_cart variable from show_cart.func to this file
//
// below is for when you are viewing the cart, and modify it (qty, options, etc)
if ($HTTP_GET_VARS['show_cart'] || $HTTP_POST_VARS['show_cart'] || $show_cart){
if (!$shipping_info || $force_ship_rule) show_cart();
}
?>
