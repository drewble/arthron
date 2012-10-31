<!--
Template file: best_seller_single
This file controls the appearance of the best selling item, in the Best Seller (Single Item) section of home.php
-->
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2">
			<div class="header2">
				<a href="<?=$Detail_Link?>">Best Seller</a>
			</div><br>
		</td>
	</tr>
	<tr>
		<td valign="top">
				<a href="<?=$Detail_Link?>"><img border="0" src="<?=$Image?>"></a>
		</td>
		<td align="left" valign="top" style="height: 100%; width: 100%; vertical-align: top; text-align:left; margin-left: 2">
			<div style="font-size: 10pt; font-weight: bold"><?=$Name?></div><br>
			<?=$Description?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: right">
			<a href="<?=$Detail_Link?>">more detail...</a>
		</td>
	</tr>
</table>