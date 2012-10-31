<?
if ($shipping_info && $SC['order']['number_of_items']) {
	$force_user_creation = get_field_val("Store_Information","Force_User_Creation","record_number=1");
	if ($force_user_creation && !$SC['user']) {
		$return = "show_cart";
		add_user();
		} else {
		address_info();
	}
}
?>