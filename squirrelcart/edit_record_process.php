<?
// file modified on 7/24/03 for v1.2 to support running PHP with either magic_quotes_gpc On or OFF
//---------------------------------set appropriate strings for queries --------------------------//

$fields=get_fields($db, $table);
for ($i = 0; $fields[$i]; $i++) {
	$field_name = $fields[$i];
	$x = $field_name;

// determine if field is an image upload
$field_type = get_field_val("Field_Definition","Display_As","Field_Name = '$x'");

	if ($field_type != "Image Upload"){
		$y=$$x; //$$x equals the value of the field from the form posting it to this page
		if(is_array($y)) {
			// below sections deletes array members that where checked for deletion
			if($options_del){
				for($d=0;$options_del[$d];$d++) {
					$del_records = explode(",",$options_del[$d]);
					for ($r=0;isset($del_records[$r]);$r++){
						$num = $del_records[$r];
						unset($y[$num]);
					}
				}
			}
			$y = array_to_sql("implode",$y); // creates string out of array for purposes of storing in MySQL
			if($field_name == "Options") $y=str_replace("^^^^^^^^","",$y); // used for deleting options from product record
		}
		// adds slashes for query
		if (!get_magic_quotes_gpc()) $y = mysql_escape_string($y);
		
		// encrypt password via MD5
		if($field_name == "Password") {
			$pass_length = strlen($y);
			if ($pass_length < 32) $y=md5($y);
		}
		
		if($set_string_edit) $prev = "$set_string_edit, "; // for editing entries
		// only modify fields if they are not encrypted
		if ($field_name != "UPS_Password" && $field_name != "UPS_UserId" && $field_name != "UPS_Access_Key") $set_string_edit = "$prev$field_name = '$y'"; 
		
		if($set_string_new_names) $prev_new_names = "$set_string_new_names, "; // for adding new entries, sets field names string
		$set_string_new_names = "$prev_new_names$field_name";
		
		if($set_string_new_values) $prev_new_values = "$set_string_new_values, "; // for adding new entries, sets field values string
		$set_string_new_values = "$prev_new_values'$y'";
	}
}

// ------------------------------------ run queries ---------------------------------------//
//set query strings
if($record_new){
	$query = "INSERT INTO $table ($set_string_new_names) 
	VALUES ($set_string_new_values)";
	$record_message = "Record successfully added.";
	unset($add_new_item);
	$edit_records="1";
	$record_just_created = "yes";
} else {
	$query="
	UPDATE $table SET 
	$set_string_edit  WHERE record_number = '$record_number'";
	$record_message = "Record successfully modifed.";
	};
	
//run query
$record_new = 0;
mysql_query($query) or die ("Query Failed");

// below section ensures that only 1 record in the Payment_Gateways table can be set to "Enabled"
	if ($table=="Payment_Gateways"){
		// if the record being modified is set to enabled, then disable all other gateways
		if ($Enabled) {
			$gateways = get_records("Payment_Gateways","record_number","record_number != $record_number");
			// loop through all OTHER gateways
			for($x=0;$gateways[$x];$x++){
				$gateway = $gateways[$x];
				set_field_val("Payment_Gateways","Enabled",0,"record_number = '".$gateway['record_number']."'");
			}
		}
	}




	// below section sets record number for below relationship section (because it is a new item, it was just created)
 	if ($record_just_created) $selected_record_number=mysql_insert_id();

	//---------- section to handle relationships ------------------------------------------------//
	for ($ri = 0, $fi = 0;$relationship_field[$ri];$ri++,$fi++){
		// $ri corresponds to each relationship record
		// $fi corresponds to each value for the current field. because the index is based on the field name, this needs to be set back to 0 after each new field name is encoountered
		if (isset($rel_field_name) && $rel_field_name != $relationship_field[$ri]) $fi = 0;
		$tb = $relationship_table[$ri];
		$rel_field_name = $relationship_field[$ri];
		$rel_field = $$rel_field_name;
		if(!$REL_table_1_rn[$ri]) {
			$REL_table_1_rn[$ri] = $rel_field[$fi];
			$REL_column = "Table_1"; // column that this record is related to. opposite of this table
			$this_table = "Table_2";
		}
		if(!$REL_table_2_rn[$ri]) {
			$REL_table_2_rn[$ri] = $rel_field[$fi];
			$REL_column = "Table_2";
			$this_table = "Table_1";
		}
		// 1st scenario - existing record is moving its position down
		// what is needed:
		// record number of record in relationship table	-	$relationship_tb_rn[$ri]
		// original position of this record -	$REL_original_position	
		// new position of this record -		$REL_position[$ri]  (set below)
		// table to alter - 							$tb
		// which column in the relationship table represents the relationship 
		// example - if table_1 represents the "code" table
		// and table_2 represents the "container" table
		// and the record that was being edited is in the "code" table
		// then the column representing the relationship would be "table_2"
		// if the record being edited was in the "container" table, then the column rep. relationship would be table_1.
		// the field $REL_column will represent this field name, and will either be "Table_1" or "Table_2".
		// value of this column - $REL_column_val
		// original position of record in relationship table
		$REL_original_position = get_field_val($tb,"Position","record_number = \"$relationship_tb_rn[$ri]\"");
		// column representing relationship in relationship table
		// value of above column to use in qry
		$REL_column_val = get_field_val($tb,$REL_column,"record_number=\"$relationship_tb_rn[$ri]\"");
		// 1st scenario - existing relationship record is moving its position down
		if (isset($REL_original_position)){
			unset($fields);
			if ($REL_position[$ri] > $REL_original_position) {
				// when position moves down, we only need to alter the records above the NEW position (decreasing them by 1)
				// excluding the original position, 
				$where = "$REL_column = '$REL_column_val' AND Position <= '$REL_position[$ri]' AND Position > '$REL_original_position' AND record_number != '$relationship_tb_rn[$ri]'";
				$fix_records = get_records($tb,"record_number,Position",$where,"Position","ASC");
				for ($fixi=0;$fix_records[$fixi];$fixi++){	// loop through records to fix position
					$fix_record = $fix_records[$fixi];
					$where = "record_number = '$fix_record[record_number]'";
					$fields[] = "Position";
					$values[Position] = $fix_record[Position] - 1;
					modify_record($tb,$where,$fields,$values);
				}
				// now, set the new position for this existing record
				$where = "record_number = '$relationship_tb_rn[$ri]'";
				$fields[] = "Position";
				$values[Position] = $REL_position[$ri];
				modify_record($tb,$where,$fields,$values);
			}
		}
		// 2nd scenario - existing relationship record is moving its position up
		if (isset($REL_position[$ri]) && $REL_position[$ri] < $REL_original_position) {
			unset($fields);
			// when position moves up, we only need to alter the records below the NEW position (increasing them by 1)
			// excluding the original position
			$where = "$REL_column = '$REL_column_val' AND Position >= '$REL_position[$ri]' AND Position < '$REL_original_position' AND record_number != '$relationship_tb_rn[$ri]'";
			$fix_records = get_records($tb,"record_number,Position",$where,"Position","ASC");
			for ($fixi=0;$fix_records[$fixi];$fixi++){	// loop through records to fix position
				$fix_record = $fix_records[$fixi];
				$where = "record_number = '$fix_record[record_number]'";
				$fields[] = "Position";
				$values[Position] = $fix_record[Position] + 1;
				modify_record($tb,$where,$fields,$values);
			}
			// now, set the new position for this existing record
			$where = "record_number = '$relationship_tb_rn[$ri]'";
			$fields[] = "Position";
			$values[Position] = $REL_position[$ri];
			modify_record($tb,$where,$fields,$values);
		}
		// 3rd scenario - existing relationship record is being deleted
		if(isset($REL_delete[$ri]) && $REL_delete[$ri] != "new" ){
			$rel_field = $relationship_field[$ri];  //set $rel_field equal to the name of the field that is being used
			$rel_field = $$rel_field;
			if ($rel_field[$fi]) { // this section is for deleting the existing record and fixing the position of the others
				// when deleting a record, we need to alter the records below the original position (decreasing them by 1)
				$position = get_field_val($tb,"Position","record_number = \"$REL_delete[$ri]\"");
				if($this_table == "Table_2") {
					$tb2_value = $selected_record_number;
				} else {
					$tb2_value = $rel_field[$fi];
				}
				$where = "Table_2 = '$tb2_value' AND Position > '$position'";
				$fix_records = get_records($tb,"record_number,Position",$where,"Position","ASC");
				for ($fixi=0;$fix_records[$fixi];$fixi++){	// loop through records to fix position
					unset($fields); unset($values);
					$fix_record = $fix_records[$fixi];
					$where = "record_number = '$fix_record[record_number]'";
					$fields[] = "Position";
					$values[Position] = $fix_record[Position] - 1;
					modify_record($tb,$where,$fields,$values);
					$just_fixed_records=1;
				}
				// now, delete the record from the relationship table
				delete_record($relationship_table[$ri],$REL_delete[$ri]);	
			}
		}
		//left off here. works.
		// 4th scenario - new relationship record is being added
		if($relationship_tb_rn[$ri] == "new" && $REL_position){
			$rel_field = $relationship_field[$ri];  //set $rel_field equal to the name of the field that is being used
			$rel_field = $$rel_field;
			if ($rel_field[$ri]) { // this section is for adding the new record and fixing the position of the others
				// when adding a new record, we need to alter the records below the NEW position (increasing them by 1)
				$where = "$REL_column = '$rel_field[$ri]' AND Position >= '$REL_position[$ri]'";
				$fix_records = get_records($tb,"record_number,Position",$where,"Position","ASC");
				for ($fixi=0;$fix_records[$fixi];$fixi++){	// loop through records to fix position
					$fix_record = $fix_records[$fixi];
					$where = "record_number = '$fix_record[record_number]'";
					unset($fields); unset($values);
					$fields[] = "Position";
					$values[Position] = $fix_record[Position] + 1;
					modify_record($tb,$where,$fields,$values);
				}
				// now, add the new record to the table
				unset($fields); unset($values);
				$fields[] = "Table_1";
				$fields[] = "Table_2";
				$fields[] = "Position";
				if($record_just_created) {
					$values[] = $selected_record_number;
				} else {
					$values[] = $REL_table_1_rn[$ri];
				}
				$values[] = $REL_table_2_rn[$ri];
				$values[] = $REL_position[$ri];
				add_record($tb,$fields,$values);	
			}
		}	
		// section for altering relationship via table that is "Table_2"
		if (!$REL_position){
			// set values for functions to modify or add records in relationship table
			unset($fields); unset($values);
			$fields[] = "Table_1";
			$fields[] = "Table_2";
			if(!$just_fixed_records) $fields[] = "Position";
			// new section just added to fix problem
			if($record_just_created) {
				if ($this_table == "Table_1") {
					$values[] = $selected_record_number;
				} else {
					$values[] = $REL_table_1_rn[$ri];
				}
			if ($this_table == "Table_2") {
				$values[] = $selected_record_number;
			} else {
				$values[] = $REL_table_2_rn[$ri];
			}
		} else {
			// end of fix
			$values[] = $REL_table_1_rn[$ri];
			$values[] = $REL_table_2_rn[$ri];
		}
		$values[] = $ri;

		// if relationship is already existing, modify existing record number
		if ($relationship_tb_rn[$ri] != "new"){
			$where = "record_number = \"$relationship_tb_rn[$ri]\"";
			unset($values);
			$values['Table_1'] = $REL_table_1_rn[$ri];
			$values['Table_2'] = $REL_table_2_rn[$ri];
			if(!$just_fixed_records) $values['Position'] = $ri;
				modify_record($tb,$where,$fields,$values);		
			} else {
				// if relationship is new, create new record in relationship table "REL...."
				// special field in REL_Order__Status table
				if ($tb == "REL_Order__Status") {
					$fields[] = "Record_Date";
					$values[] = date("Y-m-d H:i:s");
				}
				add_record($relationship_table[$ri],$fields,$values);	
			}
		}
	}
	unset($ri);
//---------- END OF section to handle relationships ------------------------------------------------//

 ?>