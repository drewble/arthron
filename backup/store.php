<? include "squirrelcart/config.php";?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Squirrelcart PHP Shopping Cart Software</title>
	<? stylesheet("store.css"); ?>
</head>

<body>
<div align="center">
  <table width="770" border="0" align="left">
    <tr> 
      <td colspan="3" align="left" valign="top" style="padding-top: 3"><img src="Images/Order-Page.gif" alt="arthron header" width="800" height="90" align="left"></td>
    </tr>
    <tr> 
      <td valign="top" width="18" style="padding-top: 3">
        <?
				// Right Navigation section
				eval(content_container("Right Navigation"));
			?>
      </td>
      <td  width="779" rowspan="2" valign="top"> 
        <?
				if ($SC['show_home_page']) {
					include "home.php";
				} else {
			?>
        <table width="100%" border="0">
          <tr> 
            <td style="padding-bottom: 3; padding-top: 0"> 
              <? include "$cart_isp_root/crumb_navigation.php" ?>
            </td>
          </tr>
          <tr> 
            <td class="content"> 
              <?
							// Cart Content section
							include "$cart_isp_root/cart_content.php" ;
						?>
            </td>
          </tr>
        </table>
        <? } ?>
        <br> </td>
      <td width="1" rowspan="2" valign="top" style="padding-top: 3">&nbsp; </td>
    </tr>
    <tr>
      <td valign="top" style="padding-top: 3">
        <?
				// Left Navigation section
				eval(content_container("Left Navigation"));
			?>
      </td>
    </tr>
    <tr> 
      <td valign="top" style="padding-top: 3">&nbsp;</td>
      <td valign="top"> 
        <? 
	// This is a link back to Squirrelcart.com. You can change the appearance of the link in your store settings
	squirrelcart_link();
?>
        <div align="center"></div></td>
      <td valign="top" style="padding-top: 3">&nbsp; </td>
    </tr>
  </table>
</div>
<p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<? 
	// session variable storage....do not remove or move this section! it must be after your closing HTML tag
	$HTTP_SESSION_VARS['sc'] = $SC; 
?>
