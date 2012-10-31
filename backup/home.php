<table width="100%">
	<tr>
		<td class="content">
			<?
				// Best Seller (Single Item) section
				// code below will display your top selling item
				show_best_sellers(1, $SC['templates']['best_seller_single']);
			?>
		</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td class="content">
			<?
				// New Product Preview section
				// code below will display a preview of new products in your catalog
				new_product_preview();
			?>
		</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td class="content">
			<?
				// Category Detail section
				// code below will show all categories in cart for browsing
				show_categories_detail();
			?>
		</td>
	</tr>
</table>

