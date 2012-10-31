<?
// this file determines when to call the add_user() function, and also when to execute external scripts that need to refer to 
// account creations and modifications (for syncing up user account info with other apps, etc....)

	if ($add_user || $modify_account) add_user();

// include scripts specified in Account_Creation_Script field in store settings
	if ($SC['added_account'] || $SC) {
		$scripts = get_field_array("Store_Information","Account_Creation_Script","record_number = '1'","\n");
		for($x=0;isset($scripts[$x]);$x++){
			$script = $scripts[$x];
			// remove \r line returns if line contains one
			$script=str_replace("\r","",$script);
			if ($script) @include $script;
		}
		unset($SC['added_account']);
	}

// include scripts specified in Account_Modification_Script field in store settings
	if ($SC['modified_account']) {
		$scripts = get_field_array("Store_Information","Account_Modification_Script","record_number = '1'","\n");
		for($x=0;isset($scripts[$x]);$x++){
			$script = $scripts[$x];
			// remove \r line returns if line contains one
			$script=str_replace("\r","",$script);
			if ($script) @include $script;
		}
	unset($SC['modified_account']);
	}
?>