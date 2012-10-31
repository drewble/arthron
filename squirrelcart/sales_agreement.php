<? include "config.php";?>
<html>
<head>
<script language="Javascript1.2">
	<!--
	function printpage() {
	window.print();  
	}
	//-->
</script>
</head>
<body onload="printpage()">
<?
	if ($HTTP_GET_VARS['agreement_rn']) {
		unset ($file);
		$agreement_rn = $HTTP_GET_VARS['agreement_rn'];
		$agreement = get_field_val("Sales_Agreement","Agreement","record_number = $agreement_rn");
		print $agreement;
	}
?>
</body>
</html>
