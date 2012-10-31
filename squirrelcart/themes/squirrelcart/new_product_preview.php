<!-- 
	template file new_product_preview. 
	This file controls the look of each product in the new product preview section of your homepage (home.php)
-->
<td width="<?=$TD_Width?>">
	<form action="<?=$Form_Action?>" method="post">
				<a href="<?=$Detail_Link?>"><img border="0" src="<?=$Thumbnail_Image?>"></a>
				<br>
				<div style="font-size: 8pt">
					<?=$Name?>
					<?=$Admin_Link?>
				</div>
				<a style="font-size: 7pt" href="<?=$Detail_Link?>">more detail...</a>
				<!--
				<div class="product_price" style="width: 100%">
					<?=$Base_Price?>
				</div>
				-->
</form>
</td>
