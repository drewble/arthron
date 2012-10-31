<!--
	Template file: order_detail_addresses
	This file controls the appearance of the shipping and billing addresses when viewing a previously submitted order,
	by clicking on an order number after clicking on the Order Status link
-->
<div style="width: 100%; text-align: left;margin-bottom: 10">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="150" align="left">
			<table class="stat_table" cellspacing="0" cellpadding="4" align="left">
				<tr class="stat_top_row">
					<td class="stat_top_td" style="text-align: left">
						Billing Address
					</td>
				</tr>
				<tr>
					<td class="stat_td" style="text-align: left;">
						<?=$Bill_First_Name ?> <?=$Bill_Last_Name ?>
						<br>
						<?=$Bill_Street?>
						<br>
						<?=$Bill_City ?>, <?=$Bill_State_Abbrev ?> <?=$Bill_Postal_Code?>
					</td>
<!--
					<td valign="bottom">
						<span style="text-align: right"><a href="?shipping_info=1"><?=$Pencil_Left?></a></span>
					</td>
-->
				</tr>
			</table>
		</td>
		<td width="200">
			<table class="stat_table" cellspacing="0" cellpadding="4">
				<tr class="stat_top_row">
					<td class="stat_top_td" style="text-align: left">
						Shipping Address
					</td>
				</tr>
				<tr>
					<td class="stat_td" style="text-align: left">
						<?=$Ship_First_Name ?> <?=$Ship_Last_Name ?>
						<br>
						<?=$Ship_Street?>
						<br>
						<?=$Ship_City ?>, <?=$Ship_State_Abbrev ?> <?=$Ship_Postal_Code?>
					</td>
<!--
 					<td valign="bottom">
						<span style="text-align: right"><a href="?shipping_info=1"><?=$Pencil_Left?></a></span>
					</td>
 -->
 				</tr>
			</table>
		</td>
	</tr>
</table>
</div>