<!-- 
	purpose of this file is to display a form to collect UPS tracking number -

	file modified on 11/22/03 for v1.3.0 - changed method to get so we can hit the back button without refreshing
-->
<form name="track_form" method="get" action="<?=$Form_Action ?>" onSubmit="return false">
<table border="0" class="ups_window" cellspacing="0" cellpadding="5" height="150" >
	<tr>
		<td class="ups_window_header" colspan="2">
			UPS OnLine® Tools - Shipment Tracking
		</td>
	</tr>
	<tr>
		<td width="50" valign="top" style="text-align: center">
			&nbsp;&nbsp;&nbsp;<?=$UPS_Logo?>
		</td>
		<td width="100%" valign="top" style="text-align: center">
			<?=$UPS_Error_Message?>
			<?=$Cart_Error_Message?>
			<br>
			<br>
			<br>
			Please enter your Reference Number or
			UPS Tracking number.<br>
			<br>
			<input type="hidden" name="ups_track" value="track_form_post">
			<input type="text" name="ups_info[TrackingNumber]" size="25" value="<?=$ups_info['TrackingNumber']?>"> &nbsp;<input type="button" onClick="document.track_form.submit()" value="track">
			<br>
			<br><br>
			<input <?=$Tracking_Terms_Checked?> type="checkbox" name="ups_info[Disclaimer] value="1">
			By selecting this box and the "Track" button, <br>
			I agree to these <?=$Tracking_Terms_Link?>
			<br>
			<br>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<br>
			<br>
			<br>
			<div style="font-size: 7pt"><?=$Disclaimer?></div>
		</td>
	</tr>
</table>
</form>



