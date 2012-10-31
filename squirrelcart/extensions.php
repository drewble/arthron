<?
/*
	Purpose of file is to attempt to load extensions at runtime if they are not loaded
	Each extension, except for MySQL, is controlled via the "PHP Extensions" section in store settings
	
	File added on 12/4/2003 for v1.4.0
	File modified on 1/21/2004 for v1.5.0 - to resolve problem when safe_mode is on, or enable_dl is off.
*/


// can't load extensions dynamically under certain cirumstances, check below and return if so
if(ini_get("safe_mode") || !ini_get("enable_dl")) return;

// attempt to load CURL at runtime if not present

if (!extension_loaded("curl") && get_field_val("Store_Information","Load_CURL")) {
	if (strtoupper(substr(PHP_OS,0,3)) == 'WIN') {
		@dl("php_curl.dll");
	} else {
		@dl("curl.so");
	}
}


// attempt to load GD at runtime if not present
if (!extension_loaded("gd") && get_field_val("Store_Information","Load_GD")) {
	if (strtoupper(substr(PHP_OS,0,3)) == 'WIN') {
		@dl("php_gd2.dll");
	} else {
		@dl("gd.so");
	}
}

// attempt to load Mcrypt at runtime if not present
if (!extension_loaded("mcrypt") && get_field_val("Store_Information","Load_Mcrypt")) {
	if (strtoupper(substr(PHP_OS,0,3)) == 'WIN') {
		@dl("php_mcrypt.dll");
	} else {
		@dl("mcrypt.so");
	}
}

// attempt to load xml support at runtime if not present
if (!extension_loaded("xml") && get_field_val("Store_Information","Load_XML")) {
	if (strtoupper(substr(PHP_OS,0,3)) == 'WIN') {
		@dl("xml_mcrypt.dll");
	} else {
		@dl("xml.so");
	}
}
?>