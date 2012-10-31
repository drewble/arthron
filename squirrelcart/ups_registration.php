<?php
// file modified on 11/16/2003 for v1.3.0 - to remove unused parameter from xml_post_sc function

if (!$site_www_root) include "config.php";
// below is test url for access license tool
//$license_url = "https://wwwcie.ups.com/ups.app/xml/License";
// below is production url for access license tool
$license_url = "https://www.ups.com/ups.app/xml/License";
// below is test url for registration tool
//$registration_url = "https://wwwcie.ups.com/ups.app/xml/Register";
// below is production url for access license tool
$registration_url = "https://www.ups.com/ups.app/xml/Register";
// ups logo
$UPS_Logo = get_image("Cart_Images","ups_logo");
// display access license agreement request screen
if (!$ups_license_agreed){
	// get license agreement from UPS, and set into a variable for further use
	$ala_req = get_ups_ala_req();
	$result = xml_post_sc($license_url,$ala_req);
	$result = xml_parse_sc($result);

	$index = $result['index'];
	$vals = $result['vals'];
	// below finds index of the value we need in the $vals array
	$license_txt_i = $index['ACCESSLICENSETEXT'][0];
	$ALA_Text = $vals[$license_txt_i]['value'];
	$SESSION['ups_ala_text'] = $ALA_Text;
	// include initial form to tell them they are about to register
	if ($HTTP_GET_VARS['ups_register'] == 1) include "includes/ups_ala_request.php";
	// cancel registration
	if ($HTTP_POST_VARS['ups_register'] == "Cancel") ups_reg_cancel();
	// accept form post from ala response screen
	if ($HTTP_POST_VARS['ups_register'] == "ala_response" && !$HTTP_POST_VARS['ups_ala_print']) {
		if ($HTTP_POST_VARS['ups_ala_agree'] == "yes") show_ups_al_form();
		if ($HTTP_POST_VARS['ups_ala_agree'] == "no") 	include "includes/ups_ala_disagreed.php";
		if (!$HTTP_POST_VARS['ups_ala_agree']) {
			// show agreement again, along with a messaging indicating they missed a field
			$Missed_Response = "<div class=\"action_msg\">You must specify whether or not you agree to the terms!</div><br>";
			include "includes/ups_ala_response.php";
		}
	}
	// show license agreement, and give them a chance to agree or disagree
	if ($HTTP_POST_VARS['ups_register'] == "ups_ala") include "includes/ups_ala_response.php";
	// open new window to print ALA agreement
	if ($HTTP_GET_VARS['ups_ala_print']) include "includes/ups_ala_print.php";
	// accept posted data from al_request form
	if ($HTTP_POST_VARS['ups_register'] == "al_response") $al_post_result = post_ups_al_form();
	// if all data has been successfully entered by customer, send that info to UPS
	if (isset($al_post_result) && $al_post_result != "missing") {
		$al_req_result = post_ups_al_req($al_post_result);
		$index = $al_req_result['index'];
		$vals = $al_req_result['vals'];
		// handle errors from UPS. If error encountered, show al form again, with error at the top of it			
		if ($index['ERROR']){
			$error_desc_i = $index['ERRORDESCRIPTION'][0];
			$error_desc = $vals[$error_desc_i]['value'];
			$error_code_i =  $index['ERRORCODE'][0];
			$error_code = $vals[$error_code_i]['value'];
			$error_severity_i = $index['ERRORSEVERITY'][0];
			$error_severity = $vals[$error_severity_i]['value'];
			$UPS_Error_Message = "<br><div><b>We have encountered an error!</b><br><br><b>Error Code:</b> $error_code<br><b>Error Severity:</b> $error_severity<br><b>Error Description:</b> $error_desc</div>";
			show_ups_al_form();
		} else {
			// we are here because al request was successful, and we now have an access key from UPS for this access user
			// need to encrypt it, and store it in the DB
			$access_key_i = $index['ACCESSLICENSENUMBER'][0];
			$access_key = $vals[$access_key_i]['value'];
			$enc_access_key = enc($access_key);
			// store enc access key in DB
			set_field_val("Shipping_Couriers","UPS_Access_Key",$enc_access_key,"record_number = 2");
			// store ups info already collected in SESSION for later use...will need to POST it again to UPS
			$SESSION['ups_info'] = $ups_info;
			// now, post registration data to obtain a username and password
			$reg_request_result = post_ups_reg_request($ups_info);
			// decryption routine
			//$enc_access_key = get_field_val("Shipping_Couriers","UPS_Access_Key","record_number = 2");
			//$access_key = dec($enc_access_key);
			//print "access key is $access_key<br>";
		}
	}
	if ($reg_request_result == "ok") {
	// if here, registration was a success, and UserId and Password were stored in DB
	// there is a Next and a Cancel button on this screen. If they click Next, the UPS_Agreed field will be updated on the Shippnig_Couriers record,
	// and the tools will be enabled.
	// if they click Cancel, the info will be removed from the DB, and the tools will not be enabled
		include "includes/ups_reg_success.php";
	}
	// handle post from the registration success form
	if ($HTTP_POST_VARS['ups_register'] == "enable") {
		unset($HTTP_POST_VARS); // must unset this or edit record function thinks you are updating a record, instead of displaying one
		$selected_record_number = 2;
		$table = "Shipping_Couriers";
		$edit_records=1;
	}
}
?>