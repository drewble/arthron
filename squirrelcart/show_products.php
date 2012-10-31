<?
//---------------- set WHERE string for passing to show_products ---------------------//
// --------------- determines what products to show -------------------------------------//

if ($action == "show_detail") show_product_detail($rn);
if ($action=="show") {
	if ($action == "show" && $qry ) {
		$where = $where;
		} else {
			if ($action == "show" ) $where = "Category = \"$crn\""; // if action is "show", then we want all products in one category
	}
	$where = $where." AND Not_For_Sale <> \"1\"";
	show_products($show_products_mode,"",$where);
}
?>