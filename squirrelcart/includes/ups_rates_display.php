<!-- purpose of this file is to display UPS rates and services in the back end -->
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="150" >
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools - Rates and Services Lookup Results
		</td>
	</tr>
	<tr>
		<td width="75" valign="top" align="center">
			<br>
			<?=$UPS_Logo?>
		</td>
		<td valign="top">
			<?=$UPS_Error_Message?>
			<br>
			<div style="font-size: 12pt; font-weight: bold">Results</div><br>
			<?=$Description?><br><br>
			<?=$Rates?>
			<br>
		</td>
	</tr>
</table>