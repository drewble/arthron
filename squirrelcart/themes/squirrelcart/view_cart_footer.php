<!--
	Template file: view_cart_footer
	This file controls the appearance of the bottom of the Viewing Cart page, 
	which is seen when you click Checkout 
-->
	<tr>
		<td class="stat_td" colspan="2" align="right" style="text-align:right">
			Product total:<br>
			<?=$Tax_Description?><br>
			<?=$Shipping_Link?><br><br>
			Grand total:
		</td>
		<td class="stat_td"  align="right" style="text-align:right">
			<?=$Currency_Sym.$Product_Total?><br>
			<?=$Tax_Total?><br>
			<?=$Shipping_Total?><br><br>
			<?=$Currency_Sym.$Grand_Total?>
		</td>
	</tr>
</table>
<br>
<?=$Empty_Cart_Button?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?=$Update_Cart_Button?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?=$Checkout_Button?>
</form>


