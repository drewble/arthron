<?
if ($table && !$edit_records) $show_record_links=1;
if($add_new_item) unset($show_record_links);
if($delete_selected_records || $email_selected_users) unset($show_record_links);
if ($show_record_links==1) Admin_Show_Records();
?>
