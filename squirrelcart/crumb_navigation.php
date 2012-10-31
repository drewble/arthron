<?
// file modified on 7/15/2003 for v1.1.1 to fix session loss when not using cookies
//
$sep = $SC[bread_crumb_seperator];
$sid = str_replace("&","?",$SC['SID']);
$home_link = "<a class='bread_crumb_link' href='$SC[www_cart_page]$sid'>Home</a>";
if($show_products_mode == "cat_click") {
	$Crumb_Nav = get_crumb_nav($crn,"category");
}
if($action == "show_detail") $Crumb_Nav = get_crumb_nav($rn,"product");


/* for future use
if($HTTP_GET_VARS['show_cart']) $Crumb_Nav = "<span class=\"bread_crumb_link\">Checkout</span>";
$checkout_link = "<a class=\"bread_crumb_link\" href=\"$SC[www_cart_page]?show_cart=1$SC[SID]\">Checkout</a>";
$address_link = "<a class=\"bread_crumb_link\" href=\"$SC[www_cart_page]?shipping_info=1$SC[SID]\">Address Info</a>";
if ($HTTP_GET_VARS['shipping_info'] && !$HTTP_POST_VARS['Bill_Addr']['First_Name']) $Crumb_Nav = $Crumb_Nav = "$checkout_link $sep <span class=\"bread_crumb_link\">Address Information</span>";
if($HTTP_GET_VARS['payment_info']) $Crumb_Nav = "$checkout_link $sep $address_link $sep <span class=\"bread_crumb_link\">Payment Information</span>";
*/

if($Crumb_Nav) print "<div class='bread_crumb_nav'>$home_link $sep $Crumb_Nav</div>";
?>
