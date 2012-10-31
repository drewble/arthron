<?
	 include "config.php";
	// get ordered items that correspond to record number $rn
	$items = get_records("Ordered_Items","*","Item_rn = $rn");
	foreach ($items as $item) {
		$qty = $qty + $item['Quantity'];
		$total = $total + $item['Item_Total'];
	}
	$item_name = get_field_val("Products","Name","record_number = $rn");
	print "<b>Stats for item \"$item_name\"</b><br><br>";
	print "Total quantity sold: $qty<br>";
	print "Total dollar amount: $total";
?>