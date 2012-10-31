<? 
	/*
	cart_content.php
	purpose of this file is to control the main content section of Squirrelcart. Each file included here 
	determines whithin it whether or not to call it's corresponding function
	
	file modified on 8/11/2003 for v1.2.0 for sales agreements
	*/
	include "$cart_isp_root/forgot_password.php" ;
	include "$cart_isp_root/add_user.php" ;
	include "$cart_isp_root/logout.php" ;
	include "$cart_isp_root/search_advanced.php" ;
	include "$cart_isp_root/search_results.php" ;
	include "$cart_isp_root/show_categories_detail.php";
	include "$cart_isp_root/show_category_detail.php" ;
	include "$cart_isp_root/cart_message.php" ;
	include "$cart_isp_root/cc_return.php" ;
	include "$cart_isp_root/address_info.php" ;
	include "$cart_isp_root/shipping_method.php" ;
	include "$cart_isp_root/show_cart.php" ;
	include "$cart_isp_root/payment_info.php" ;
	include "$cart_isp_root/place_order.php" ;
	include "$cart_isp_root/show_products.php" ;
	include "$cart_isp_root/ups_track.php" ;		
	include "$cart_isp_root/order_status.php" ;		
	include "$cart_isp_root/order_detail.php" ;		
	include "$cart_isp_root/post_cart.php" 
?>

