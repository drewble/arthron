<?
// file modified on 8/13/2003 for v1.2.0 to fix premature storage of order info in the database
// file modified on 10/22/2003 for v1.3.0 to fix blank screen after placing CC order without a payment gateway
//
// purpose of this file is to handle things that need to happen after all other cart operations
track_session(); // log all activity in TEMP_Sessions for purpose of controlling inventory
if ($SC['complete_order']) {
	// if no payment gateways were enabled, and payment method was credit card, then show the thank you page
	if (!$SC['payment_gateway'] && $SC['pay_info']['is_cc']) include $SC['templates']['thanks_for_order'];
	complete_order();
}
?>