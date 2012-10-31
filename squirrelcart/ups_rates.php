<?
// purpose of file is to handle all logic for back end Rates and Services lookups,
// triggered by "Tools > UPS Rates and Services" menu item
//
// file added in v1.1.1 on 7/13/03

if (ups_registered()){
	$Form_Action = $SC['www_admin_page'];
	$UPS_Logo = get_image("Cart_Images","ups_logo");
	$countries_from_settings = get_field_array("Address_Form_Settings","Countries","record_number = '1'",$seperator="^^");
	$Destination_Country = "<select name=\"ups_info[dest_country]\">\n";
	$Destination_Country = $Destination_Country."<option value=\"\"></option>\n";
	if (!$HTTP_POST_VARS['ups_info']['orig_zip']) $ups_info['orig_zip'] = get_field_val("Store_Information","Postal_Code");
	for($c=0;$countries_from_settings[$c];$c++){
		$country_from_setting = $countries_from_settings[$c];
		$country_from_setting = mysql_escape_string($country_from_setting);
		$country_rn = get_field_val("Countries","record_number","Name = '$country_from_setting'");
		if($HTTP_POST_VARS['ups_info']['dest_country'] == $country_rn) {
			$selected = "selected";
			} else {
				$store_country = get_field_val("Store_Information","Country");
				if($store_country == $country_rn) {
					$selected = "selected";
				} else {
					unset($selected);
				}
		}
		$Destination_Country=$Destination_Country."<option $selected value=\"$country_rn\">$country_from_setting</option>\n";
	}
	$Destination_Country = $Destination_Country."</select>\n";

	if($HTTP_POST_VARS['ups_info']['address_type']) {
		$address_type = $HTTP_POST_VARS['ups_info']['address_type'];
	} else {
		$address_type = get_field_val("Address_Form_Settings","Default_for_Address_Is");
	}

	// 1 is residential
	// 2 is commercial
	if (!$address_type) $address_type = 1;
	if ($address_type == 1 ) $address_residential = " checked ";
	if ($address_type == 2) $address_commercial = " checked ";

	$Destination_Address_Type = "<input name=\"ups_info[address_type]\" type=\"radio\" value=\"1\" $address_residential> Residential
<input name=\"ups_info[address_type]\" type=\"radio\" value=\"2\" $address_commercial> Commercial";
	$Origination_Country = "<select name=\"ups_info[orig_country]\">\n";
	$Origination_Country = $Origination_Country."<option value=\"\"></option>\n";
	for($c=0;$countries_from_settings[$c];$c++){
		$country_from_setting = $countries_from_settings[$c];
		$country_from_setting = mysql_escape_string($country_from_setting);
		$country_rn = get_field_val("Countries","record_number","Name = '$country_from_setting'");
		if($HTTP_POST_VARS['ups_info']['orig_country'] == $country_rn) {
			$selected = "selected";
			} else {
				$store_country = get_field_val("Store_Information","Country");
				if($store_country == $country_rn) {
					$selected = "selected";
				} else {
					unset($selected);
				}
		}
		$Origination_Country=$Origination_Country."<option $selected value=\"$country_rn\">$country_from_setting</option>\n";
	}
	$Origination_Country = $Origination_Country."</select>\n";
	if ($HTTP_GET_VARS['ups_rates'] == "form" && !is_array($ups_rates)) {
		include $SC['cart_isp_root']."/includes/ups_rates_form.php";
	}
	if ($HTTP_POST_VARS['ups_rates'] == "rates_form_post") {
		$ups_info = $HTTP_POST_VARS['ups_info'];
		$post_result = post_ups_rates_form($ups_info);
		// handle errors by showing form again, and error at top
		if ($post_result == "missing") {
			include "includes/ups_rates_form.php";
		} else {
			// data validated, get rates from UPS
			$ship_to_country_code = get_field_val("Countries","Alpha_2","record_number = '".$ups_info['dest_country']."'");
			$ship_from_country_code = get_field_val("Countries","Alpha_2","record_number = '".$ups_info['orig_country']."'");
			$Description = "Rates and Services for ".$ups_info['weight']." lb package shipping from $ship_from_country_code ".$ups_info['orig_zip']."  to $ship_to_country_code ".$ups_info['dest_zip'] ;
			$service_names = explode("^^",get_field_val("Shipping_Couriers","Services","record_number = '2'"));
			for ($x=0;$service_names[$x];$x++){
				$service_name = $service_names[$x];
				$service_rn = get_field_val("Shipping_Methods","record_number","Method = \"$service_name\"");
				$rate = get_ups_rate($service_rn,$ups_info['orig_zip'],$ups_info['dest_zip'],$ship_to_country_code,$ups_info['weight'],"REGULAR",0,"none",0,$ship_from_country_code,$address_type);
				if ($rate['service']) {
					if ($rate['days_to_delivery']) $days = $rate['days_to_delivery']." day delivery";
					if ($rate['delivery_time']) $delivery_time = " by ".$rate['delivery_time'];
					if ($days) $time_in_transit  = "$days$delivery_time<br>";
					$Rates .= $rate['service']." - ".$SC['currency'].$rate['postage']."<br>$time_in_transit<br>";
					//Ar	ray ( [postage] => 24.50 [service] => UPS Ground [days_to_delivery] => [delivery_time] => )
					unset($days);
					unset($time_in_transit);
				}
				if (!$Rates) {
					if ($rate['error']) {
						$Rates = "<b>Error Code:</b> ".$rate['error']['number']."<br><b>Error Description:</b> ".$rate['error']['description']."<br>";
					} else {
						$Rates = "<div class=\"action_msg\">Unable to obtain rate information.</div>";
					}
				}
			}
			include "includes/ups_rates_display.php";
			print "<br><br>";
			include "includes/ups_rates_form.php";
		}
	}
} else {
	if (security_level("Store Admin") && $on_admin_page) {
		$HTTP_GET_VARS['ups_register'] = 1;
		include "ups_registration.php";
	}
}
?> 