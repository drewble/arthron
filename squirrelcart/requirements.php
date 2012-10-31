<?
// purpose of file is to check requirements, and output useful info to store owner
// file modified on 11/22/03 for v1.3.0 to remove register globals check

// check PHP version
$php_version = phpversion();

// check MySQL version
$result = mysql_query ("SELECT VERSION();");
$row = mysql_fetch_array ($result);
$mysql_version = $row[0];
// check for presence of CURL, which is used by the following:
//
// USPS real time rates
// UPS real time rates
// All Payment_Gateways set to "Server to Server" connection method
//
//
if (function_exists("curl_init")){
	$curl_version = curl_version();
	$curl_ok = 1;
} else {
	$curl_version = "Not installed";
}	
if (strstr(strtolower($curl_version), "openssl")) $open_ssl_ok = 1;
if (function_exists("xml_parse")){
	$expat_ok = 1;
}


$requirements .= "PHP version >= 4.0<br><br>";
$requirements .= "MySQL must be installed<br><br>";

// check to see if CURL is required
if ($SC['payment_gateway']['Connection_Method'] == "Server to Server") {
	$curl_required = 1;
	$gateway_rn = $SC['payment_gateway']['record_number'];
	$gateway_name = $SC['payment_gateway']['Name'];
	$gateway_href = $SC['www_admin_page']."?edit_records=1&table=Payment_Gateways&selected_record_number=$gateway_rn";
	$gateway_anchor = "<a href=\"$gateway_href\">$gateway_name</a>";
	$requirements .= "Your payment gateway, $gateway_anchor, is set to use the connection method \"Server to Server\", 
	which requires CURL and OpenSSL.<br><br>";
	$open_ssl_required = 1;
}

// if USPS real time rates are enabled
$usps_info = get_records("Shipping_Couriers","Enabled,Real_Time_Rates","record_number = '1'");
$usps_info = $usps_info[0];
if ($usps_info['Enabled'] && $usps_info['Real_Time_Rates']) {
	$curl_required = 1;
	$expat_required = 1;
	$usps_href = $SC['www_admin_page']."?edit_records=1&table=Shipping_Couriers&selected_record_number=1";
	$requirements .= "You have <a href=\"$usps_href\">USPS Real Time Rates</a> enabled, which requires CURL and the EXPAT library.<br><br>";
}

// if UPS real time rates are enabled
$ups_info = get_records("Shipping_Couriers","Enabled,Real_Time_Rates","record_number = '2'");
$ups_info = $usps_info[0];
if ($ups_info['Enabled'] && $usps_info['Real_Time_Rates']) {
	$curl_required = 1;
	$expat_required = 1;
	$open_ssl_required;
	$ups_href = $SC['www_admin_page']."?edit_records=1&table=Shipping_Couriers&selected_record_number=2";
	$requirements .= "You have <a href=\"$ups_href\">UPS Real Time Rates</a> enabled, which requires CURL, OpenSSL, and the EXPAT library.<br><br>";
}


if ($php_version >= 4) {
	$status .= "<span style=\"color: green\">PHP version is OK</span><br>";
} else {
	$status .= "<span style=\"color: red\">PHP version is not OK</span><br>";
}
if ($mysql_version) {
	$status .= "<span style=\"color: green\">MySQL version is OK</span><br>";
} else {
	$status .= "<span style=\"color: red\">MySQL version is not OK</span><br>";
}
if ($curl_required) {
	if ($curl_ok) {
	$status .= "<span style=\"color: green\">CURL is enabled</span><br>";
	} else {
	$status .= "<span style=\"color: red\">CURL is not enabled</span><br>";
	}
}
if ($open_ssl_required) {
	if ($open_ssl_ok) {
	$status .= "<span style=\"color: green\">OpenSSL is enabled</span><br>";
	} else {
	$status .= "<span style=\"color: red\">OpenSSL is not enabled</span><br>";
	}
}
if ($expat_required) {
	if ($expat_ok) {
	$status .= "<span style=\"color: green\">EXPAT library is installed</span><br>";
	} else {
	$status .= "<span style=\"color: red\">EXPAT library is not installed</span><br>";
	}
}

print "<table width=\"300\" align=\"center\">";
print "<tr><td align=\"center\">";
print "<b>Squirrelcart Requirements</b><br><br>";
print "<tr><td align=\"left\">";
print "$requirements<br><br>";
print "</td></tr>";
print "<tr><td align=\"center\">";
print "<b>Requirements Check</b><br><br>";
print "The following shows the status of the Squirrelcart required settings on your server. <span style=\"color: green; font-weight: bold\">Green</span> indicates the requirement has been met, <span style=\"color: red; font-weight: bold\">red</span> indicates it has not.<br><br>";
print "</td></tr>";
print "<tr><td align=\"left\">";
print "$status<br><br>";
print "<br>";
print "</td></tr>";
print "<tr><td align=\"center\">";
print "<b>Server Information</b><br><br>";
print "</td></tr>";
print "<tr><td align=\"left\">";
print "<b>PHP Version:</b> $php_version <a href=\"$SC[cart_www_root]/phpinfo.php\">(click here for full PHP details)</a><br>";
print "<b>MySQL Version:</b> $mysql_version<br>";
print "<b>CURL Version:</b> $curl_version<br><br><br>";
print "</td></tr>";
print "</table>";
?>