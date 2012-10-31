<?
// file modified on 10/23/2003 for v1.3.0 to fix empty text option popup when viewing orders in DB
//
// purpose of this page is to show a popup window of the text specified for a particular option
// this page is used by the popup window function only, and should not be called directly
// a value of an item and option in the SESSION needs to be passed as $item and $option for this to work
//
// example $SC[order][$item][option][$option]
//
include "config.php";

	$item = $HTTP_GET_VARS['item'];
	$item_rn = $HTTP_GET_VARS['item_rn'];
	$option = $HTTP_GET_VARS['option'];
	$mode = $HTTP_GET_VARS['mode']; // mode for orders in process is blank. for orders already placed, needs to be set to existing
	if (!$mode) {
		$option = $SC['order'][$item]['option'][$option];
	} else {
		// mode is existing, which means we need to pull this info out of the DB
		// first step - get option from DB
		$options = get_field_val("Ordered_Items","Options","record_number = $item_rn");
		$options = unserialize($options);
		$option = $options[$option];
	}
	$option_array = explode("^^",$option);
	$Option_Name = $option_array[0];
	$option_value = $option_array[1];
	$Option_Value = nl2br(stripslashes($option_value));
	include $SC['templates']['option_text_popup'];
?>
