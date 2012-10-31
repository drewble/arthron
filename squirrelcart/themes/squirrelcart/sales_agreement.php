<!--
Template file: sales_agreement
Controls the display of a sales agreement
-->

<table width="<?=$Width?>">
	<tr>
		<td style="text-align: center">
			<b><?=$Name?>:</b><br><br>
			<div style="text-align: left; width: <?=$Width?>; height: <?=$Height?>; overflow: auto; border: black solid 1px; padding: 5px; background-color: #ECECEC">
				<?=$Agreement?>
			</div>
		</td>
	</tr>
	<tr>
		<td style="text-align: right">
			<a target="new" href="<?=$Print_Agreement_HREF?>">Print Agreement</a>
		</td>
	</tr>
	<tr>
		<td style="text-align: center">
			<br>
			I agree<input type="checkbox" name="agreement_agreed[]">
			<input type="hidden" name="agreement_name[]" value="<?=$Name?>"><br>
		</td>
	</tr>
</table>
<br>