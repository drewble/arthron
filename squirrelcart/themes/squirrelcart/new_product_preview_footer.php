<!-- 
	template file new_product_preview_footer. 
	This file controls the look of the bottom of the new product preview section of your homepage (home.php)
-->
	</tr>
</table>

<!-- DO NOT REMOVE OR ALTER THE NEXT LINE!! IT IS FOR PROGRAMMATIC USE! -->
<? if ($More_Than_One_New_Item) { ?>
<table width="100%">
	<tr>
		<td style="text-align: right">
			<a href="<?=$SC['www_cart_page']?>?crn=1&action=show&show_products_mode=new_all<?=$SC['SID']?>">Click Here to View All New Items</a>
		</td>
	</tr>
</table>
<!-- DO NOT REMOVE OR ALTER THE NEXT LINE!! IT IS FOR PROGRAMMATIC USE! -->
<? } ?>
