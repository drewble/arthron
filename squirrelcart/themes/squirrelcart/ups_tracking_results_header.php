<!-- purpose of this file is to display UPS tracking results !-->
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="150">
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools - Tracking Results
		</td>
	</tr>
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="middle" style="text-align: right">
			<table>
				<tr>
					<td width="40%">
						<table class="stat_table" width="100%" border="0" cellspacing="0" cellpadding="4">
							<tr class="stat_top_row">
								<td class="stat_top_td" width="15%" valign="top" style="text-align: left">
									Ship to Address
								</td>
							</tr>
							<tr>
								<td class="stat_td" width="30%" style="text-align: left" valign="top">
										<?=$Ship_To_Address['Street']?><br>
										<?=$Ship_To_Address['City']?>, <?=$Ship_To_Address['State_Abbrev']?><br>
										<?=$Ship_To_Address['Country_Abbrev']?><br>
										<!--<?=$Ship_To_Address['Postal_Code']?>-->
								</td>
							</tr>
						</table>
					</td>
					<td width="10%">&nbsp;</td>
					<td width="40%">
						<table class="stat_table" width="100%" border="0" cellspacing="0" cellpadding="4">
							<tr class="stat_top_row">
								<td class="stat_top_td" width="15%" valign="top" style="text-align: left">
									Ship From Address
								</td>
							</tr>
							<tr>
								<td class="stat_td" width="30%" style="text-align: left" valign="top">
									<?=$Shipper_Address['Street']?><br>
									<?=$Shipper_Address['City']?>, <?=$Shipper_Address['State_Abbrev']?><br>
									<?=$Shipper_Address['Country_Abbrev']?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
			<table width="100%" cellspacing="0" cellpadding="4" border="0" style="border: black solid 1px">
				<tr>
					<td class="stat_td" width="50%" valign="top" align="left" style="line-height: 20px">
						<b>Tracking Number:</b> <?=$Tracking_Number?><br>
						<b>Number of pkgs in shipment:</b> <?=$Number_of_Packages?>
						<b>Package Weight:</b> <?=$Package_Weight?> <?=$Weight_Symbol?>
					</td>
					<td class="stat_td" width="50%" valign="top" align="left" style="line-height: 20px">
						<b>Shipped on date:</b> <?=$Shipped_On_Date['Month']?>/<?=$Shipped_On_Date['Day']?>/<?=$Shipped_On_Date['Year']?> via </b><?=$Service?><br>
						<b>Scheduled delivery date:</b> <?=$Scheduled_Delivery_Date['Month']?>/<?=$Scheduled_Delivery_Date['Day']?>/<?=$Scheduled_Delivery_Date['Year']?>
					</td>
				</tr>
			</table>
			<br>
			<table class="stat_table" width="100%" cellspacing="0" cellpadding="4" border="0">
				<tr class="stat_top_row">
					<td class="stat_top_td" style="text-align: left">
						Date
					</td>
					<td class="stat_top_td">
						Time
					</td>
					<td class="stat_top_td">
						Location
					</td>
					<td class="stat_top_td" style="text-align: right">
						Activity
					</td>
				</tr>



	
