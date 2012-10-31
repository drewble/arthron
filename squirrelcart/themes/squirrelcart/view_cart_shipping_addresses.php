<!--
	Template file: view_cart_shipping_addresses
	This file controls the appearance of the address section at the top of the table on the Viewing Cart page, 
	which is seen when you click Checkout 
-->
<div style="width: 100%; text-align: left;margin-bottom: 10">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" align="left">
			<table class="stat_table" cellspacing="0" cellpadding="4" align="left">
				<tr class="stat_top_row">
					<td colspan="2" class="stat_top_td" style="text-align:left">
						Billing Address
					</td>
				</tr>
				<tr>
					<td class="stat_td" style="text-align:left">
							<?=$Billing['First_Name'] ?> <?=$Billing['Last_Name'] ?>
							<br>
							<?=$Billing['Street']?>
							<br>
							<?=$Billing['City'] ?>, <?=$Billing['State_Abbrev'] ?> <?=$Billing['Postal_Code']?>
					</td>
					<td class="stat_td" valign="bottom">
						<span style="text-align: right"><a href="?shipping_info=1"><?=$Pencil_Left?></a></span>
					</td>
				</tr>
			</table>
		</td>
		<td width="50">&nbsp;</td>
		<td width="200">
			<table class="stat_table" cellspacing="0" cellpadding="4" align="left">
				<tr class="stat_top_row">
					<td class="stat_top_td" colspan="2" style="text-align:left">
							Shipping Address
					</td>
				</tr>
				<tr>
					<td class="stat_td" style="text-align: left">
							<?=$Shipping['First_Name'] ?> <?=$Shipping['Last_Name'] ?>
							<br>
							<?=$Shipping['Street']?>
							<br>
							<?=$Shipping['City'] ?>, <?=$Shipping['State_Abbrev'] ?> <?=$Shipping['Postal_Code']?>
					</td>
					<td class="stat_td" valign="bottom">
						<span style="text-align: right"><a href="?shipping_info=1"><?=$Pencil_Left?></a></span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
