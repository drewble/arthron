<?
if (!$in_admin_section) {
	$query_table="Products";
	$query_mode = "simple";
	$qry_fields[] = "Name";
	$qry_fields[] = "Description";
	$qry_fields[] = "Keywords";
	$qry_fields[] = "Category";
	}
$where = record_search($query_mode,$query_table,$qry_fields,$search_template);
?>