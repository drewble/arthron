<!--
	Template file: view_cart_item
	This file controls the appearance of a single item in the Viewing Cart page, 
	which is seen when you click Checkout 
-->
	<tr>
		<td width="80%" valign="top" style="border-right: solid 1px black; padding: 0">
			<table border=0 width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2" style="text-align: left; padding-left: 6; padding-top: 4; border-right: solid 1px black">
						<!-- DO NOT REMOVE OR MODIFY THIS LINE ! --><? if ($Product_Link) { ?><!-- DO NOT REMOVE OR MODIFY THIS LINE! -->
						<div style="color:red"><a href="<?=$Product_Link?>"><?=$Item_Name ?></a></div>
						<!-- DO NOT REMOVE OR MODIFY THIS LINE ! --><? } else { ?><!-- DO NOT REMOVE OR MODIFY THIS LINE! -->
						<?=$Item_Name ?>
						<!-- DO NOT REMOVE OR MODIFY THIS LINE ! --><? } ?><!-- DO NOT REMOVE OR MODIFY THIS LINE! -->
					</td>
					<td rowspan="2" width="140" valign="top" align="right" style="text-align:right; padding: 2">
						<?	if($Base_Price != "0.00") print "Base Price: <br>";	?>
						<?=$Options ?>
						<br><br>
					</td>
				</tr>
				<tr>
					<td width="20%" style="padding: 6">
						<a href="<?=$Product_Link?>">
							<!-- DO NOT REMOVE OR MODIFY THIS LINE ! --><? if ($Thumbnail_Image) { ?><!-- DO NOT REMOVE OR MODIFY THIS LINE! -->
							<img border="0" src="<?=$Thumbnail_Image ?>">
							<!-- DO NOT REMOVE OR MODIFY THIS LINE ! --><? } ?><!-- DO NOT REMOVE OR MODIFY THIS LINE! -->
						</a>
					</td>
					<td align="left" valign="top" style="padding: 4; padding-right: 10; text-align: left; border-right: solid black 1px">
						<table height="100%" border="0" cellspacing="0" cellpadding="0" >
							<tr>
								<td height="85" valign="top" style="text-align:left">
									<?=$Brief_Description ?>
								</td>
							</tr>
							<tr>
								<td height="10" style="text-align:right">
									<?=$Remove_From_Cart_Button?>
								</td>
							</tr>
						</TABLE>

					</td>
				</tr>
			</table>

			<!-- <br>Total Sales Tax for item: <?=$Item_Tax_Total?>-->
		</td>
		<td width="10%" style="border-right: solid black 1px; text-align: right" valign="top" >
			<? if($Base_Price != "0.00") print "$Base_Price<br>"; ?>
			<?=$Options_Price ?>
		</td>
		<td width="10%"></td>
	</tr>
	<tr class="stat_td_alternate">
		<td width="80%" valign="top" align="right" style="border-right: solid 1px black; border-top: solid black 1px; border-bottom: solid black 1px; padding: 0 2 0 4; text-align:right">
			<span style="width: 260"><?=$Quantity?> @</span>
		</td>
		<td width="10%" style="border-right: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px; text-align: right" >
			<?=$Currency_Sym.$Item_Total ?>
		</td>
		<td width="10%" style="border-top: solid black 1px; border-bottom: solid black 1px; text-align: right">
			<?=$Currency_Sym.$Item_Subtotal ?>
		</td>
	</tr>




