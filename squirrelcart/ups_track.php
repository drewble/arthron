<?php
// purpose of file is to handle tracking ups packages via form submission

// file modified on 11/22/03 for v1.3.0 - changed method to get so we can hit the back button without refreshing

if (ups_registered() && ($HTTP_POST_VARS['ups_track'] || $HTTP_GET_VARS['ups_track'])){
	$tracking_url = "https://www.ups.com/ups.app/xml/Track";
//	$tracking_url = "https://wwwcie.ups.com/ups.app/xml/Track";
	$UPS_Logo = get_image("Cart_Images","ups_logo");
	$Disclaimer = "NOTICE: The UPS package tracking systems accessed via this service (the \"Tracking Systems\") and 
	tracking information obtained through this service (the \"Information\") are the private property of UPS. UPS 
	authorizes you to use the Tracking Systems solely to track shipments tendered by or for you to UPS for 
	delivery and for no other purpose. Without limitation, you are not authorized to make the Information 
	available on any web site or otherwise reproduce, distribute, copy, store, use or sell the Information for 
	commercial gain without the express written consent of UPS. This is a personal service, thus your right to use 
	the Tracking Systems or Information is non-assignable. Any access or use that is inconsistent with these terms 
	is unauthorized and strictly prohibited.";
	$Tracking_Terms_Link = popup_window($SC['cart_www_root']."/includes/ups_tracking_terms.php", "Terms and Conditions", 440, 380, "no", "no");
	if ($HTTP_GET_VARS['ups_info']['Disclaimer']) {
		$Tracking_Terms_Checked = "checked";
	}
	// this form works in back end AND front end, so need to set form action accordingly for use in template
	if ($on_admin_page) {
		$Form_Action = $SC['www_admin_page'];
	} else {
		$Form_Action = $SC['www_cart_page'];
	}
	// obtain XML necessary to make an access request at top of each request sent to UPS tools
	$access_request = ups_access_req_xml();
	// $access_request = str_replace("<","[", $access_request);
	// $access_request = str_replace(">","]", $access_request);
	
	//print $access_request;
	
	// display tracking form to enter tracking number
	if ($HTTP_GET_VARS['ups_track'] == "form" && !is_array($ups_track)) {
		include $SC['cart_isp_root']."/includes/ups_track_form.php";
	}
	
	// handle posted tracking form
	if ($HTTP_GET_VARS['ups_track'] == "track_form_post") {
		// display tracking form again
		//include $SC['cart_isp_root']."/includes/ups_track_form.php";

		$post_result = post_ups_track_form($ups_info);
		// handle errors by showing form again, and error at top
		if ($post_result == "missing") {
			include "includes/ups_track_form.php";
		} else {
			// data validated, send it to UPS
			$track_req_result = post_ups_track_request($post_result);
			if ($track_req_result == "error") {
				$UPS_Error_Message = "<br><div><b>We have encountered an error!</b> - Unable to connect to UPS servers.</div>";
				include "includes/ups_track_form.php";
			} else {
				// get values returned, and their index positions in the array
				$index = $track_req_result['index'];
				$vals = $track_req_result['vals'];
				// look for errors returned from UPS
				if ($index['ERROR']){
					$error_desc_i = $index['ERRORDESCRIPTION'][0];
					$error_desc = $vals[$error_desc_i]['value'];
					$error_code_i =  $index['ERRORCODE'][0];
					$error_code = $vals[$error_code_i]['value'];
					$error_severity_i = $index['ERRORSEVERITY'][0];
					$error_severity = $vals[$error_severity_i]['value'];
					$UPS_Error_Message = "<br><div><b>We have encountered an error!</b><br><br><b>Error Code:</b> $error_code<br><b>Error Severity:</b> $error_severity<br><b>Error Description:</b> $error_desc</div>";
					include $SC['cart_isp_root']."/includes/ups_track_form.php";
				} else {
				// no error....show results
				$tree=get_xml_tree($vals);
				// store info into variables for easier use - uper case because they will be in templates
				$track_info = $tree['TRACKRESPONSE'][0];
				// shipper info
				$Shipper_Address = $track_info['SHIPMENT'][0]['SHIPPER'][0]['ADDRESS'][0];
				$Shipper_Address['Street'] = $Shipper_Address['ADDRESSLINE1'][0]['VALUE'];
				$Shipper_Address['Street'] = ucwords(strtolower($Shipper_Address['Street'])); 
				$Shipper_Address['Street_2'] = $Shipper_Address['ADDRESSLINE2'][0]['VALUE'];
				$Shipper_Address['Street_2'] = ucwords(strtolower($Shipper_Address['Street_2'])); 
				$Shipper_Address['City'] = $Shipper_Address['CITY'][0]['VALUE'];
				$Shipper_Address['City'] = ucwords(strtolower($Shipper_Address['City'])); 
				$Shipper_Address['State_Abbrev'] = $Shipper_Address['STATEPROVINCECODE'][0]['VALUE'];
				$Shipper_Address['Postal_Code'] = $Shipper_Address['POSTALCODE'][0]['VALUE'];
				$Shipper_Address['Country_Abbrev'] = $Shipper_Address['COUNTRYCODE'][0]['VALUE'];
				$Shipper_Number = $track_info['SHIPMENT'][0]['SHIPPER'][0]['SHIPPERNUMBER'][0]['VALUE'];
				// ship to info
				$Ship_To_Address = $track_info['SHIPMENT'][0]['SHIPTO'][0]['ADDRESS'][0];
				$Ship_To_Address['Street'] = $Ship_To_Address['ADDRESSLINE1'][0]['VALUE'];
				$Ship_To_Address['Street'] = ucwords(strtolower($Ship_To_Address['Street'])); 
				$Ship_To_Address['Street_2'] = $Ship_To_Address['ADDRESSLINE2'][0]['VALUE'];
				$Ship_To_Address['Street_2'] = ucwords(strtolower($Ship_To_Address['Street_2'])); 
				$Ship_To_Address['City'] = $Ship_To_Address['CITY'][0]['VALUE'];
				$Ship_To_Address['City'] = ucwords(strtolower($Ship_To_Address['City'])); 
				$Ship_To_Address['State_Abbrev'] = $Ship_To_Address['STATEPROVINCECODE'][0]['VALUE'];
				$Ship_To_Address['Postal_Code'] = $Ship_To_Address['POSTALCODE'][0]['VALUE'];
				$Ship_To_Address['Country_Abbrev'] = $Ship_To_Address['COUNTRYCODE'][0]['VALUE'];
				$Service = $track_info['SHIPMENT'][0]['SERVICE'][0]['DESCRIPTION'][0]['VALUE'];
				$shipped_on_date = $track_info['SHIPMENT'][0]['PICKUPDATE'][0]['VALUE'];
				$Shipped_On_Date['Year'] = substr($shipped_on_date, 0, 4);
				$Shipped_On_Date['Month'] = substr($shipped_on_date, 4, 2);
				$Shipped_On_Date['Day'] = substr($shipped_on_date, 6, 2);
				$scheduled_delivery_date = $track_info['SHIPMENT'][0]['SCHEDULEDDELIVERYDATE'][0]['VALUE'];
				$Scheduled_Delivery_Date['Year'] = substr($scheduled_delivery_date, 0, 4);
				$Scheduled_Delivery_Date['Month'] = substr($scheduled_delivery_date, 4, 2);
				$Scheduled_Delivery_Date['Day'] = substr($scheduled_delivery_date, 6, 2);
				$Package_Weight = $track_info['SHIPMENT'][0]['PACKAGE'][0]['PACKAGEWEIGHT'][0]['WEIGHT'][0]['VALUE'];
				$Weight_Symbol = $track_info['SHIPMENT'][0]['PACKAGE'][0]['PACKAGEWEIGHT'][0]['UNITOFMEASUREMENT'][0]['CODE'][0]['VALUE'];
				$Number_of_Packages = count($track_info['SHIPMENT'][0]['PACKAGE']);
				$activities = $track_info['SHIPMENT'][0]['PACKAGE'][0]['ACTIVITY'];
				$Tracking_Number = $track_info['SHIPMENT'][0]['SHIPMENTIDENTIFICATIONNUMBER'][0]['VALUE'];
	
				$Last_Activity['Date'] = $activities[0]['DATE'][0]['VALUE'];
				$Last_Activity['Time'] = $activities[0]['TIME'][0]['VALUE'];
				$Last_Activity['Status'] = $activities[0]['STATUS'][0]['STATUSTYPE'][0]['DESCRIPTION'][0]['VALUE'];
				$Last_Activity['City'] = $activities[0]['ACTIVITYLOCATION'][0]['ADDRESS'][0]['CITY'][0]['VALUE'];
				$Last_Activity['State'] = $activities[0]['ACTIVITYLOCATION'][0]['ADDRESS'][0]['STATEPROVINCECODE'][0]['VALUE'];
				$Last_Activity['Country'] = $activities[0]['ACTIVITYLOCATION'][0]['ADDRESS'][0]['COUNTRYCODE'][0]['VALUE'];
	
				// include header template
				include $SC['templates']['ups_tracking_results_header'];
				
				// sample output for testing
	
				
				for($i=0;$activities[$i];$i++){
					$activity = $activities[$i];
					$Activity['Date'] = $activity['DATE'][0]['VALUE'];
					$Activity['Time'] = $activity['TIME'][0]['VALUE'];
					// add a date to beginning so we can properly pass the time to the function strtotime()
					$Activity['Time'] = substr($Activity['Time'], 0, -2);
					$hours = substr($Activity['Time'],0,2);
					$minutes = substr($Activity['Time'],2,2);
					$Activity['Time'] = "$hours:$minutes";
					$Activity['Time'] = "2001-12-08 ".$Activity['Time'];
					$Activity['Time'] = date("g:i a",strtotime($Activity['Time']));
					$Activity['Year'] = substr($Activity['Date'], 0, 4);
					$Activity['Month'] = substr($Activity['Date'], 4, 2);
					$Activity['Day'] = substr($Activity['Date'], 6, 2);
					$Activity['City'] = $activity['ACTIVITYLOCATION'][0]['ADDRESS'][0]['CITY'][0]['VALUE'];
					$Activity['City'] = ucwords(strtolower($Activity['City'])); 
					$Activity['State'] = $activity['ACTIVITYLOCATION'][0]['ADDRESS'][0]['STATEPROVINCECODE'][0]['VALUE'];
	//				print $activity['ACTIVITYLOCATION'][0]['ADDRESS'][0]['POSTALCODE'][0]['VALUE']." ";
					$Activity['Country'] = $activity['ACTIVITYLOCATION'][0]['ADDRESS'][0]['COUNTRYCODE'][0]['VALUE'];
					$Activity['Status'] = $activity['STATUS'][0]['STATUSTYPE'][0]['DESCRIPTION'][0]['VALUE'];
					if (!$Activity['City']) $Activity['City'] = "-----";
					if (!$Activity['State']) $Activity['State'] = "-----";
					if (count($activities) > 2 && $TD_Class == "stat_td") {
						$TD_Class = "stat_td_alternate";
					} else {
						$TD_Class = "stat_td";
					}
					// include activity row template
					include $SC['templates']['ups_tracking_results_activity'];
				}
				// include footer template
				include $SC['templates']['ups_tracking_results_footer'];
				}
			}	
		}
	}
} else {
	if (security_level("Store Admin") && $on_admin_page) {
		$HTTP_GET_VARS['ups_register'] = 1;
		include "ups_registration.php";
	}
}
?>