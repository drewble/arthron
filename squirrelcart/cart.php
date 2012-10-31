<?
// modified on 9/25 for v1.0.9 to support inventory control
// file modified on 7/15/2003 for v1.1.1 to fix session loss when not using cookies
// file modified on 10/25/2003 for v1.3.0 - to cleanup temp images from image edit popup, and to fix $HTTP_HOST refresh bug

// set error reporting to 2039, to avoid Undefined variable and other minor errors
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING | E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE );

if ($SESSID) session_id($SESSID);
 session_save_path("/home/users/web/b1461/ipw.sportsin/phpsessions");
session_start();

$SC = $HTTP_SESSION_VARS['sc']; // set our session variable, and grab it form the HTTP_SESSION_VARS variable

// workaround fix for when register_globals is set to off.
if (!ini_get('register_globals')) {
	while (list($key, $val) = @each($HTTP_GET_VARS)) $GLOBALS[$key] = $val;
	while (list($key, $val) = @each($HTTP_POST_VARS)) $GLOBALS[$key] = $val;
	while (list($key, $val) = @each($HTTP_POST_FILES)) $GLOBALS[$key] = $val;
	while (list($key, $val) = @each($HTTP_SESSION_VARS)) $GLOBALS[$key] = $val;
}

// to be removed eventually in favor of above method
$cart_isp_root = "$site_isp_root/squirrelcart";
$cart_www_root="$site_www_root/squirrelcart";

include "$site_isp_root/squirrelcart/functions/all_functions.func";


// attempt to load MySQL at runtime if not present (Unix only)
if (!extension_loaded("mysql")) {
	if (strtoupper(substr(PHP_OS,0,3)) != 'WIN') {
		@dl("mysql.so");
	}
}

authenticate();

// attempt to load extensions that are not loaded
include "$cart_isp_root/extensions.php";

$expired=exp_sessions(); // remove old sessions from TEMP_Sessions

// if current session was just expired, reestablish it, and notify user
	if($expired) {
			if($SC['user'] || $SC['order']['number_of_items']) $exp_notify = 1;
			unset($SC);
			session_unregister("SESSION");
		// notify user that their session has expired
			if ($exp_notify) $SC['cart_message'] = "<div class='action_msg'><br>You have been idle for ".$expired['idle_time']." minutes, and your session has timed out.<br></div>";
	}
	
// below is a check to see if this person established the SESSION variable from a different store on the same server
// this will only happen if someone was shopping at 1 store, and then went to another store on the same server
// this will check for that, and if it happens, will wipe out the SESSION var
if (!$SC['store_check']) $SC['store_check'] = $site_www_root;
if ($SC['store_check'] != $site_www_root) {
	session_unregister("SESSION");
	unset($SC);
	session_register("SESSION");
	$SC['store_check'] = $site_www_root;
}

//$SC['sql_host'] = $sql_host;
// get rid of the line below eventually for security purposes!
$SC['db'] = $db;
//$SC['sql_username'] = $sql_username;
//$SC['sql_password'] = $sql_password;

$SC['cart_isp_root'] = "$site_isp_root/squirrelcart";
$SC['cart_www_root']="$site_www_root/squirrelcart";
$SC['cart_secure_root'] = "$site_secure_root/squirrelcart";
$SC['site_isp_root'] = $site_isp_root;
$SC['site_www_root'] = $site_www_root;
$SC['site_secure_root'] = $site_secure_root;
$SC['client_version'] = "1.4.0";
$SC['payment_module_path'] = "$cart_isp_root/payment_gateways";

// set the page that contains the shopping cart
//	$cart_page = get_field_val("Admin_Options","Value","Name = \"Cart Page\"");
	$SC['www_cart_page'] = $SC[site_www_root].$cart_page;
	$SC['secure_cart_page'] = $SC[site_secure_root].$cart_page;

// set the page that contains the shopping cart
	$admin_page = get_field_val("Admin_Options","Value","Name = \"Admin Page\"");
	$SC['www_admin_page'] = $SC[site_www_root].$admin_page;
	$SC['secure_admin_page'] = $SC[site_secure_root].$admin_page;
	
// need to remove first character IF it is a foward slash
$first_chr = substr($img_path, 0, 1); 
if ($first_chr == "/") {
	$img_path = substr_replace($img_path, '', 0,1);
}

$SC['image_folder']=$img_path;

// store referer page in session for use in other functions
	if(!$SC['referer']) $SC['referer'] = $HTTP_REFERER;

// this section fixes a problem with session loss on the admin page,
// when the URL initially accessed is not the $site_www_root, and user is 
// redirected to the $site_www_root after modifying a record
if ($on_admin_page) {
	$compare_root = str_replace("http://","",$site_www_root);
	$compare_root = str_replace("https://","",$compare_root);
	$compare_root = explode("/",$compare_root);
	$compare_root = $compare_root[0];
	// if domain does not match that in the site_www_root, redirect
	if (isset($HTTP_HOST) && $HTTP_HOST != $compare_root) {
		print "
		<head>
		<meta http-equiv=\"Refresh\" content=\"0; URL=".$SC['www_admin_page']."\">
		</head>";

		die;
	}
}

// process user login and logout. this is done here so we can return info earlier to the cart,
// mostly for correct theme display, etc...
	if ($logout) logout();
	if($login_action == "attempt") $SC['user'] = login_process();
	
// set the theme that has been chosen by user as the path to its folder
// if user just changed theme, then don't get default theme
	if(!$SC['theme_rn']) {
		if ($SC['user']['Theme']) {
			$SC['theme_rn'] = $SC['user']['Theme'];
			} else {
				$SC['theme_rn'] = get_field_val("Store_Information","Default_Theme");
		}
	}

	$theme_dir = get_field_val("Themes","Path_to_Files","record_number = \"".$SC['theme_rn']."\"");
	$SC['theme_dir'] = $SC['cart_isp_root']."/themes/$theme_dir";
	$SC['theme_www_dir'] = $SC['cart_www_root']."/themes/$theme_dir";
	$SC['theme_secure_dir'] = $SC['cart_secure_root']."/themes/$theme_dir";
	
	$SC['default_theme_dir'] = $SC['cart_isp_root']."/themes/squirrelcart";
	$SC['default_theme_www_dir'] = $SC['cart_www_root']."/themes/squirrelcart";
	$SC['default_theme_secure_dir'] = $SC['cart_secure_root']."/themes/squirrelcart";
	 
	if(!is_dir($SC['theme_dir'])) print ("<b>Squirrelcart Error:</b> failed to find theme directory: ".$SC['theme_dir']." <Br>");
	
	// set whether or not SSL is needed in session for certain functions 	(stylesheet, content, etc...)
	// get port number specified in config file, if there
	$ssl_port = get_url_port($SC['site_secure_root']);
	// if no port specified in config file, than ssl port is the default
	if (!$ssl_port) $ssl_port = 443;
	// get port server was using when this file was accessed
	$server_port = $HTTP_SERVER_VARS['SERVER_PORT'];

	if($server_port == $ssl_port) {
		$SC['secure_page'] = 1;
		} else {
			unset($SC['secure_page']);
	}


//determine if SESSID needs to be passed to all pages
	// determine what is passing the session ID, and set $SC['SID'] only if needed in URL
	$use_cookies = ini_get("session.use_cookies");
	if (	// if PHP is set to use cookies, but session is not in cookie (probably disabled) then store SID
	($use_cookies && !$HTTP_COOKIE_VARS['PHPSESSID']) ||
	// if PHP session.use_cookies is off, then store SID
	 !$use_cookies || 
	// if on a secure page, and URL does not match the normal site URL, store SID
	($SC['secure_page'] && $SC['send_sid'])) {
		 $SC['SID'] = "&".session_name()."=".session_id(); 
	} else {
		unset ($SC['SID']);
	}


// determine if SESSID needs to be passed to secure pages (because domain name in URL is different from regular URL)
// strip out protocol in URL, all foward slashes, and change to lowercase for comparison

	$www_compare = $SC['site_www_root'];
	$www_compare = str_replace("http://","",$www_compare);
//	$www_compare = str_replace("www.","",$www_compare);
	$www_compare = str_replace("/","",$www_compare);
	$www_compare = strtolower($www_compare);
	$ssl_compare = $SC['site_secure_root'];
	$ssl_compare = str_replace("https://","",$ssl_compare);
	$ssl_compare = str_replace("http://","",$ssl_compare);
//	$ssl_compare = str_replace("www.","",$ssl_compare);
	$ssl_compare = str_replace("/","",$ssl_compare);
	$ssl_compare = strtolower($ssl_compare);
	if($www_compare != $ssl_compare || $SC['SID']) $SC['send_sid'] = "&".session_name()."=".session_id(); 



// set currency symbol
	$Currency_Sym = get_field_val("Store_Information","Currency_Symbol");
	$SC['currency'] = $Currency_Sym;

//set weight symbol or text
	$Weight_Sym = get_field_val("Store_Information","Weight_Symbol");
	$SC['weight_symbol'] = $Weight_Sym;

// store email address of store contact in session
	$SC['merchant_email'] = get_field_val("Store_Information","Email_Orders_To");
	if (!$SC['merchant_email']) 	$SC['merchant_email'] = get_field_val("Store_Information","Customer_Service_Email");
	
// set seperator for bread crumb navigation
	$SC['bread_crumb_seperator'] = get_field_val("Store_Information","Bread_Crumb_Seperator");

//set required field indicator
	$required_ind = get_field_val("Store_Information","Required_Field_Indicator","record_number = '1'");
	if (!$required_ind) $required_ind = get_image("Images","required_field_indicator");
	$SC['required_ind'] = $required_ind;

// set missing field indicator
	$missing_ind = get_field_val("Store_Information","Missing_Field_Indicator","record_number = '1'");
	if (!$missing_ind) $missing_ind = get_image("Images","missing_field_indicator");
	$SC['missing_ind'] = $missing_ind;

// figure out whether or not to use inventory control
	$SC['inventory_control'] = get_field_val("Store_Information","Use_Inventory_Control");
	$SC['out_of_stock_behavior'] = get_field_val("Store_Information","Out_of_Stock_Behavior");

// set maximum quantity to eliminate ridiculous orders
	$SC['max_qty'] = get_field_val("Store_Information","Maximum_Quantity");
	if ($SC['max_qty'] <= 0) $SC['max_qty'] = 1000;

// set whether or not to expand categories in product catalog navigation section
	$SC['dont_expand_categories'] = get_field_val("Store_Information","Do_Not_Expand_Categories");

// line below makes it unnecessary to include the add_to_cart, show_cart, and microtime variable in manual add to cart links
if ($HTTP_GET_VARS['pn'] || $HTTP_GET_VARS['prod_name'] || $HTTP_GET_VARS['prod_rn']) {
	if (!$HTTP_GET_VARS['microtime']) $HTTP_GET_VARS['microtime'] = microtime();
	if ($HTTP_GET_VARS['qty']) $quantity = $HTTP_GET_VARS['qty'];
	if ($HTTP_GET_VARS['pn']) $prod_name = $HTTP_GET_VARS['pn'];
	$add_to_cart = 1;
	if (get_field_val("Store_Information","Add_to_Cart_Behavior") == "go to checkout") $show_cart = 1;
}

// decide whether to show home page content or not in cart page
	// when page is accessed without sending variables to it
		$no_posts = (!count($HTTP_POST_VARS) && !count($HTTP_GET_VARS)); 
	// when login attempt is made on a page that is already showing the home page content. without this, when login attempt is made, the content disappers!
		$login_on_home = ($login_action && ($REQUEST_URI == "$cart_page" || $REQUEST_URI == "/"));
	// only SESSID set
		$only_sessid = (count($HTTP_GET_VARS) == 1 && $HTTP_GET_VARS['PHPSESSID']);
	if ($no_posts || $login_on_home || $only_sessid) {
		$SC['show_home_page'] = 1;
	} else {
		unset ($SC['show_home_page']);
		$TD_Class = "content"; // this line will in effect toggle the class of the main TD for the cart content
	}

// below section assists cart in returning to the appropriate page after item is edited
if($PHP_SELF && !$on_popup){
	if($QUERY_STRING) $query_string = "?$QUERY_STRING";
	if($HTTP_REFERER) {
		$SC['last_page'] = $HTTP_REFERER;
	} else {
		$SC['last_page'] = $SC['current_page'];
	}
	$domain_name_arr = explode("/",$SC['site_www_root']);
	if (!$add_new_item && !$edit_records) {
		$SC['current_page'] = $domain_name_arr[0]."//".$domain_name_arr[2].$PHP_SELF.$query_string;
	}
}

// clean up temporary images used in GD manipulation
temp_image_cleanup();

log_info();

$categories=get_records("Categories",0,0,"Name","ASC");

include "$cart_isp_root/add_to_cart.php";
if ($delete_cart) delete_cart();
if ($update_cart_y || $update_cart || $remove) {
	update_cart();
	$show_cart=1;
	}

	
// handle payment info posted via get_payment_method()
// if there is only 1 payment method enabled, and it is not a credit card, then just place order
	if($SC['order']) {
		$payment_methods=get_records("Payment_Methods",0,"Enabled = '1'","Type","ASC");
		if (count($payment_methods) == 1 && $payment_info==1) {
			$posting_payment_info = 1;
			$pay_info['method'] = $payment_methods[0]['Name'];
		}
		if($posting_payment_info) $missing=post_payment_method();
	}
//	}


// ----------------------- section to handle returning POSTS from payment gateways --------------------------------//

// get enabled payment gateway
	$Payment_Gateway = get_records("Payment_Gateways",0,"Enabled = \"1\"",0,0);
	$Payment_Gateway = $Payment_Gateway[0];
	$gw_file = $Payment_Gateway['Module_Name'];

// store enabled gateway in SESSION variable
	$SC['payment_gateway'] = $Payment_Gateway;	
	
/*
 if paying by credit card AND gateway returns to storefront, it will return the variable cc_return, and its value will determine what the cart
 needs to do next:
 cc_return = 1		indicates a successful transaction. cart is emptied, order is placed in DB, emails are sent, etc....
 cc_return = 2		indicates a failed transaction. cart is not emptied. customer can resubmit payment info again
 cc_return = 3		indicates a canceled transaction. cart is not emptied. this is useful for certain payment gateways that offer a "cancel" option to the customer
 cc_return = 4		indicates cart needs to execute some code based on values being returned by payment gateway in order to determine next step.
							 this is used in the event that you cannot tell the payment gateway to return to different URLs depending on the status of the transaction
 							in most cases, a special section of code will be run in the payment gateway file, which will look at the info that is being sent from the payment gateway,
							and then do a redirect back to the cart page, with cc_return then set to either 1, 2, or 3
cc_return = 5		indicates an error from the payment gateway system
*/

	if($cc_return == 4) include $SC['cart_isp_root']."/payment_gateways/$gw_file";
		
	if ($SC['order']){
		if ($cc_return == 1) {
			$SC['complete_order'] = 1;
		} else {
			if ($payment_validated) {
				// determine if payment method is a gateway or not
					$pay_type = get_field_val("Payment_Methods","Type","Name = '".$pay_info['method']."'");
					// if payment is not via credit cards or echecks
					if($pay_type != 1 && $pay_type != 4) {
						$SC['complete_order'] = 1;
						} else {
					// payment is via credit cards or echecks. need to make sure gateway doesn't return
							if(!$Payment_Gateway['Return_to_Storefront']) {
								$SC['complete_order'] = 1;
							}
					}
			}
		}
	}	
// this gets the path to the template files into the session for use in many functions
	$SC['templates'] = get_templates();
	$SESSION = $SC; // for backwards compatibility with 1.2 - esp. for home.php call to show_best_sellers

// process cart, ie, add up totals, and set into the SESSION variable
process_cart();
?>
