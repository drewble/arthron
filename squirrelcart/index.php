<?
/*
 file modified on 1/14/2004 for version 1.4.0 to resolve problem viewing records when clicking back from certain pages

 this is the admin page for the cart
 from this page, you can edit the product records, categories, and everything else
*/

$on_admin_page = 1; // this tells certain functions whether we are in the admin section or not

include "config.php";

$Wait_Image = get_image("Cart_Images","wait_dots");
include $SC['templates']['admin_header'];

// code to show control panel
include "control_panel.php";


print "<div id='content' align='center' style='position: absolute; top: 28; overflow:auto; height: 100%; width:100%; text-align:center;border: 1 inset white; padding:7'>";

print "<script type='text/javascript'>
content.style.height = document.body.clientHeight - 29;
</script>
";

if (!$ups_register) {
	include "$SC[cart_isp_root]/squirrelcart_logo.php";
}
print "<br><br>";

// ------------ security check section
// if user is not admin, show login box, and end this script!!!!!
	if(!security_level("Store Admin")) {
		include "login.php";
		}
	if(!security_level("Store Admin")) {
		include $SC['templates']['admin_footer'];
		die;
	}
// --------------- end of security check section

// ups integration
	if ($ups_register) {
		include "ups_registration.php";
		$dont_show_records = 1;
	}
	if ($ups_track){
		include "ups_track.php";
		$dont_show_records = 1;
	}
	if ($ups_rates){
		include "ups_rates.php";
		$dont_show_records = 1;
	}

	
// port checker for certain payment gateways and other services
// make a link like so: http://yoursite.com/squirrelcart/index.php?check_port=1234
// when clicked, will run the port_checker function to check that port
if ($HTTP_GET_VARS['check_port']) {
	$check_ports[] = $HTTP_GET_VARS['check_port'];
	port_checker($check_ports);
	$dont_show_records = 1;
}
	
// check for requirements, initiated by user
if ($HTTP_GET_VARS['check_requirements']) {
	include $SC['cart_isp_root']."/requirements.php";
	$dont_show_records = 1;
}

// show order as customer sees it
if ($HTTP_GET_VARS['order_detail']) {
	order_detail($HTTP_GET_VARS['order_detail']);
	$dont_show_records = 1;
}

// show order statistics in table at login
	if ((!$table && !$SC['edit_record']['table'] && !$HTTP_POST_VARS && !$HTTP_GET_VARS) || $order_stats) {
		show_order_stats();
		if ($order_stats) {
			unset($table);
			unset($SC['edit_record']['table']);
		}
	}

// if table was just selected, store it in the session so admin utility remembers what you last looked at
	if(isset($table)) {
		$SC['edit_record']['table'] = $table;
	} else {
		$table = $SC['edit_record']['table'];
	}
	
	if($selected_record_number) $SC[edit_record][selected_record_number] = $selected_record_number;
	$selected_record_number = $SC[edit_record][selected_record_number];

// purpose of below code is to quickly change the value of a field
// $set must equal 1 for this section to attempt to modify the field
// requires the following values:
// $table
// $rn (record number)
// $fn (field name)
// $nfv (new field value)
if($set && $table && $rn && $fn && isset($nfv)) {
	// check to see if value that is trying to be set is already the existing value in the record
	$existing_value = get_field_val($table,$fn,"record_number = '$rn'");
	if ($existing_value != $nfv) {
		set_field_val($table,$fn,$nfv,"record_number = '$rn'");
		// below section ensures that only 1 record in the Payment_Gateways table can be set to "Enabled"
			if ($table=="Payment_Gateways"){
				if ($fn == "Enabled" && $nfv==1) {				// if the record being modified is set to enabled, then disable all other gateways
					$gateways = get_records("Payment_Gateways","record_number","record_number != $rn");
					for($x=0;$gateways[$x];$x++){ 	// loop through all OTHER gateways
						$gateway = $gateways[$x];
						set_field_val("Payment_Gateways","Enabled",0,"record_number = '".$gateway['record_number']."'");
					}
				}
			}
	}
}

// if copying a record, treat it as a new addition
	if ($copy_record) $add_new_item = 1;

// code to delete multiple records
	include "delete_selected_records.php";

// code to email users
	include "email_users.php";
	
// code to change current theme
	if($change_current_theme) unset($table);
	include "change_current_theme.php";

// code to select record
	if (!isset($dont_show_records)) include "admin_show_records.php";

// code to edit record
	include "edit_records.php";

include $SC['templates']['admin_footer'];
print "</div>";

print "
</body>
</html>";

// workaround for SESSION variable problem
$HTTP_SESSION_VARS['sc'] = $SC;
?>
