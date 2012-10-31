<?
// --------------------------------------------------------------------------------------------
//                                          Configuration Variables                                            
//---------------------------------------------------------------------------------------------
//  Installer of cart needs to change these variables to their appropriate values
//  note: do not add trailing slashes
// 		site_www_root is the web address to the root of your site
			$site_www_root = "http://www.sportsinjuries.com";


//		site_isp_root is the path to your root, from the server's directory structure
//			$site_isp_root = $HTTP_SERVER_VARS['DOCUMENT_ROOT'];
			$site_isp_root = "/home/users/web/b1461/ipw.sportsin/public_html";

//		site_secure_root is the path to your web root using HTTPS or (SSL). This is for secure transactions.
//		if your server does not support SSL, then make this variable the same as site_www_root
			$site_secure_root = "https://sportsinjuries.com";

// cart page. this is the default path, from the root of your site that will be used to display your store
// it is usually set to "/index.php". when first installed, it defaults to the page for the demo store.
			$cart_page = "/store.php";

// img_path is the path to the folder you keep your images in. this is the folder that you upload the products, categories, and other folders into
			$img_path = "/Images";

//		sql_host is the name or IP address of the server that is running MySQL. sportsin.ipowermysql.com is the default
			$sql_host = "sportsin.ipowermysql.com";

//		sql_username is the name of the user you created and added to your squirrelcart database
			$sql_username = "sportsin_juries";
			$sql_password = "sione04";

// db should be set to the name of the database squirrelcart is using			
			$db = "sportsin_juries";
// ------------------------------ end of configuration section ----------------------------

// do not modify anything below this line!!!!!!!
			include "$site_isp_root/squirrelcart/cart.php";
?>