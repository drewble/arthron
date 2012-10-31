<?
	print $SC['cart_message'];
	unset ($SC['cart_message']);
	if ($SC['cart_content'] ) {
		print $SC['cart_content'];
		unset($SC['cart_content']);
	}	
?>