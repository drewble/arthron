<?
// purpose of this page is to show a popup window with an explanation of an order status
// this page is used by the popup window function only, and should not be called directly
// a value of $status needs to be passed, where $status is the rn of the status we want an explanation of
//
//
include "config.php";
$Status = get_field_val("Order_Status","Status","record_number = '$status'");
$Description = get_field_val("Order_Status","Description","record_number = '$status'");
include $SC['templates']['order_status_popup'];
?>
