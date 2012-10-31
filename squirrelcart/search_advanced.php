<?
if ($search_mode == "advanced") {
	if (!$in_admin_section) {
		$table="Products";
		$qry_fields[] = "Name";
		$qry_fields[] = "Description";
		$qry_fields[] = "Keywords";
		$qry_fields[] = "Category";
		}
	$where = record_search($search_mode,$table,$qry_fields,$search_template);
}
?>