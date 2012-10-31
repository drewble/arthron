<!-- DHTML Menu Builder Loader Code START -->
<div id=DMBRI style="position:absolute;">
	<img src="menu/images/dmb_i.gif" name=DMBImgFiles width="1" height="1" border="0" alt="">
	<img src="menu/dmb_m.gif" name=DMBJSCode width="1" height="1" border="0" alt="">
</div>
	
	
<?
	// call popup function to generate javascript for popup calculator
		print "<form method=\"post\" action=\"".$SC['www_admin_page']."\">";
		print"
		<SCRIPT LANGUAGE=\"JavaScript\">
		<!--
		function Popup(page,width,height,scrollbars,resizable)
			{
			thewindow = window.open(page, '', config='height=' + height + ',width=' + width + ',scrollbars=' + scrollbars + ',resizable=' + resizable + ',$config');
			}
		// -->
		</SCRIPT>
		";
		$popup_js_exists = 1;
	
	// set version variable
	$version_ctrl = get_field_val("Store_Information","Use_Version_Control");
	if ($version_ctrl) {
		$sc_version = version(); 
		if($sc_version){
			$sc_version = "Version: ".$SC['client_version']." <img src=\\'images/cart/$sc_version[0]\\'; height=\\'10\\' width=\\'10\\' border=\\'0\\' alt=\\'$sc_version[1]\\'>";
		}
	} else {
			$sc_version = "Version: ".$SC['client_version'];
	}
	
	// set input for records per page
		if($show_limit) { // if posting new records per page number store it in the session
			$SC['edit_record']['show_limit'] = $show_limit;
			} else { // else if not already in session, get it from DB
				if(!$SC['edit_record']['show_limit']) 	$SC['edit_record']['show_limit'] = get_field_val("Store_Information","Records_per_Page");		
			}
		$records_per_page = "<div style=\\'position: relative; top: -4;\\'><font style=\\'position: relative; top: -3\\'>Records per page: </font><input class=\\'menuInput\\' size=\\'1\\' type=\\'text\\' name=\\'show_limit\\' value=\\'".$SC['edit_record']['show_limit']."\\'></div>";
	
	// set text for "current theme images"
		$theme_name = get_field_val("Themes","Name","record_number = $SC[theme_rn]");
		$theme_name = htmlspecialchars($theme_name, ENT_QUOTES);
		$current_theme_images = " $theme_name Images";
	?>
	
	<script language="JavaScript" type="text/javascript">
		var cart_www_page = '<?=$SC['www_cart_page']?>';
		var sc_version = '<?=$sc_version?>';
		var records_per_page = '<?=$records_per_page?>';
		var current_theme_images = '<?=$current_theme_images?>';
	</script>
	<script language="JavaScript" type="text/javascript">
	var rimPath=null;var rjsPath=null;var rPath2Root=null;function InitRelCode(){var iImg;var jImg;var tObj;if(!document.layers){iImg=document.images['DMBImgFiles'];jImg=document.images['DMBJSCode'];tObj=jImg;}else{tObj=document.layers['DMBRI'];if(tObj){iImg=tObj.document.images['DMBImgFiles'];jImg=tObj.document.images['DMBJSCode'];}}if(!tObj){window.setTimeout("InitRelCode()",700);return false;}rimPath=_gp(iImg.src);rjsPath=_gp(jImg.src);rPath2Root=rjsPath+"../";return true;}function _purl(u){return xrep(xrep(u,"%%REP%%",rPath2Root),"\\","/");}function _fip(img){if(img.src.indexOf("%%REL%%")!=-1) img.src=rimPath+img.src.split("%%REL%%")[1];return img.src;}function _gp(p){return p.substr(0,p.lastIndexOf("/")+1);}function FixImages(){var h=null;var f=new Function("h","if(h)for(var i=0;i<h.length;i++)h[i]=xrep(h[i],'%%REL%%',rimPath);");f(hS);f(hshS);}function xrep(s,f,n){if(s) s=s.split(f).join(n);return s;}InitRelCode();
	</script>
	<script language="JavaScript" type="text/javascript">
	function LoadMenus() {if(!rjsPath){window.setTimeout("LoadMenus()", 10);return false;}var navVer = navigator.appVersion;
	if(navVer.substr(0,3) >= 4)
	if((navigator.appName=="Netscape") && (parseInt(navigator.appVersion)==4)) {
	document.write('<' + 'script language="JavaScript" type="text/javascript" src="' + rjsPath + 'nsmenu.js"><\/script\>');
	} else {
	document.write('<' + 'script language="JavaScript" type="text/javascript" src="' + rjsPath + 'iemenu.js"><\/script\>');
	}return true;}LoadMenus();</script>
<!-- DHTML Menu Builder Loader Code END -->
<br><br>
</form>

<?
	include "admin_show_tables.php";
?>

