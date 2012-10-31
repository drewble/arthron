<!--
	Template file: order_detail_footer
	This file controls the appearance of the bottom of the Order Detail page, which appears when a customer clicks on
	an order number after clicking on "order status" in the account options navigation section
-->
	<tr>
		<td class="stat_td" colspan="2" align="right" style="text-align:right">
			Product total:<br>

			<!-- Do not remove or modify this section. It is for programmatic use. -->
		        <? if ($Tax_Total > 0) { ?>
			<!-- Do not remove or modify this section. It is for programmatic use. -->

			Tax Total:<br>

			<!-- Do not remove or modify this section. It is for programmatic use. -->
		        <? } ?>
			<!-- Do not remove or modify this section. It is for programmatic use. -->

			<?=$Shipping_Details_Link?>:<br><br>
			Grand total:
		</td>
		<td class="stat_td" align="right" style="text-align:right">
			<?=$Currency_Sym.$Product_Total?><br>

			<!-- Do not remove or modify this section. It is for programmatic use. -->
		        <? if ($Tax_Total > 0) { ?>
			<!-- Do not remove or modify this section. It is for programmatic use. -->

			<?=$Currency_Sym?><?=$Tax_Total?><br>

			<!-- Do not remove or modify this section. It is for programmatic use. -->
		        <? } ?>
			<!-- Do not remove or modify this section. It is for programmatic use. -->

			<?=$Currency_Sym.$Shipping_Total?><br><br>
			<?=$Currency_Sym.$Grand_Total?>
		</td>
	</tr>
</table>
<br>
<div class="cart_instruction" style="font-size: 8pt">
	<b>Note:</b> The information above represents the full details of your order, at the time that it was placed. 
	When clicking on the product links above, you will see the product(s) as they are currently listed in our inventory, which may or may not match the information above. 
</div><br>

