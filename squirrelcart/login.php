<?
// file modified on 7/15/2003 for v1.1.1 to fix session loss when not using cookies
// file modified on 9/24/2003 for v1.2 to fix modify account link not passing session ID when needed
//
$logged_in = $SC['user'];
if (!$logged_in) {
	login();
	}
$logged_in = $SC['user'];
if ($logged_in){
		// if links that go secure have different domain name, we need to send SID in URL. $SC['send_sid'] is set in cart.php
		if ($SC['send_sid']) $SID = "&SESSID=".session_id();
		$Logged_in_Message =  "You are logged in as ".$SC['user']['Username'];
		// if you need to send the SID when switching to an SSL URL, then set a variable accordingly
		$Account_Details_Link = "<a href=\"$SC[secure_cart_page]?modify_account=1$SID\">Account Details</a>\r";
		$Logout_Link = "<a href=\"$SC[www_cart_page]?logout=1$SC[SID]\">Logout</a>\r";
		if (ups_registered()) $UPS_Tracking_HREF = "$SC[www_cart_page]?ups_track=form$SC[SID]";
		$Show_Order_Status = get_field_val("Store_Information","Show_Order_Status");
		$Order_Status_HREF = "$SC[www_cart_page]?order_status=1$SC[SID]";
		$Change_Theme = change_theme();
		include $SC['templates']['logged_in'];
		}
// determine if admin
if(strstr($SC['user']['Privelage_Level'],"admin")){
	$SC['is_admin'] = 1;
	} else {
	unset($SC['is_admin']);
	}
 ?>
