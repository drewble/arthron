<?
if ($email_selected_users) {
	if ($selected_record || $post_email_users) {
		unset($show_record_links);
		email_users($selected_record);
	} else {
		print "<div class=\"action_msg\">You must select at least one record to use this feature!</div><br><br>";
		Admin_Show_Records();
	}
}
?>