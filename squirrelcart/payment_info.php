<?
// if payment_info is set, and Shipping address and Billing address is set, show form to get payment method.
if (($payment_info || $posting_payment_info) && $SC['order']['Ship_Addr'] && $SC['order']['Bill_Addr']) get_payment_method($missing);
?>