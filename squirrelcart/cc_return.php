<?
// this file is for a payment gateway to return to.
// cc_return = 1 means success
// cc_return == 2 means failure
if ($cc_return) {
	$result = $SC['payment_gateway_result'];
	if ($cc_return == 1) {
		// card accepted
		complete_order();
		include $SC['templates']['cc_accepted'];
		} else {
			if($cc_return == 2) include $SC['templates']['cc_declined'];
			if($cc_return == 3) include $SC['templates']['payment_canceled'];
			if($cc_return == 5) {
				if (!$result['error']) $result['error'] = "Unavailable";
				include $SC['templates']['payment_gateway_error'];
			}
	}
	unset ($SC['payment_gateway_result']);
}
?>