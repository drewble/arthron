<!-- UPS tracking results activity - this template controls the display of each row of activity in the tracking results ------->
				<tr>
					<td class="<?=$TD_Class?>" style="text-align: left">
						<?=$Activity['Month']?>/<?=$Activity['Day']?>/<?=$Activity['Year']?>
					</td>
					<td  class="<?=$TD_Class?>" style="text-align: right">
						<?=$Activity['Time']?>
					</td>
					<td  class="<?=$TD_Class?>">
						<?=$Activity['City']?>, <?=$Activity['State']?> (<?=$Activity['Country']?>)
					</td>
					<td  class="<?=$TD_Class?>" style="text-align: right">
						<?=$Activity['Status']?>
					</td>
				</tr>
