<html>
<head>
<? // check to make sure client is IE 5 or newer ?>
<script src="check_for_IE.js" type="text/javascript"></script>

<? 
stylesheet("admin.css");
include "$SC[cart_isp_root]/menu.css";
// javascript for checking and unchecking check boxes
print "
<script language='JavaScript'>
<!--
function checkAll(form_id,field_id,value){
	elements = form_id.elements;
	for (i=0; elements[i];i++){
		element = elements[i]
		if (element.id == field_id) {
			if (value == 1)	element.checked = true;
			if (value == 0)	element.checked = false;
		}
	}
}
-->
</script>";
?>
</head>
<body scroll="no" style="margin-top:0; overflow:hidden">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div align="center">
<div id="wait" style="width: 184;height: 26;  margin-top: 200; font-size: 14pt; font-weight: bold; display:; background-color: white; position: relative;z-index: 2; background-image: url('images/cart/blank_button.gif');" align="center">Please Wait <?=$Wait_Image?></div>
</div>



