<!--
ship_method_forced_service.php template file
- this template is only displayed when there are items in the cart that are set to ship using a specific shipping service
- this template displays once for each service that is being forced on the order
- this template is displayed after ship_method_header.php
Available variables:
	Any field names from the "Shipping_Methods" table
	$Postage - postage for all items forced to ship with this particular shipping service (method)
-->

<br>The following item(s) will be shipped using <?=$Courier?> <?=$Method?> at a cost of <?=$Currency_Symbol?><?=$Postage?>:<br>
<!-- next template is ship_method_forced_items --> 