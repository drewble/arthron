<table width="100%" height="100" border="0"  cellpadding="0" cellspacing="0" <?=$row_style?>>
	<tr>
		<td width="150" align="left" valign="top" style="padding-left: 10px; padding-top: 10px; padding-bottom: 10px; border-right: silver solid 1">
				<?=$descriptor?><br><br>
				<?=$image_code?>
		</td>
		<td valign="top" style="line-height: 30px; padding-top: 6px; padding-left: 10px">
			<input style="position: relative; top: 1px" type="radio" name="image_action_<?=$field_name?>" value="new">
			<span style="width: 30px">new:</span>
			<input onFocus="javascript:record_form.image_action_<?=$field_name?>[0].checked='true' " class="field_input" type="file" name="<?=$field_name?>" style="width: 330"><br>

			<input style="position: relative; top: 1px" type="radio" name="image_action_<?=$field_name?>" value="edit">
			<span style="width: 30px">edit:</span>
			<input onFocus="javascript:record_form.image_action_<?=$field_name?>[1].checked='true' " type="text" name="new_image_path_<?=$field_name?>" value="<?=$edit_value?>" style="width: 285px; position: relative; right: 0px">
			<a class="menuButton3" style="width: 19px; position: relative; top: 5px" href="image_picker_popup.php?dir=<?=$field_def['Path']?>&field_name=<?=$field_name?>&table=<?=$table?>" onClick="record_form.image_action_<?=$field_name?>[1].checked='true'" target="new"><?=$folder_image?></a>
			<a class="menuButton3"  style="width: 19px; position: relative; top: 5px" href="#" onClick="javascript: record_form.new_image_path_<?=$field_name?>.value='' ; record_form.image_action_<?=$field_name?>[1].checked='true'" ><?=$eraser_image?></a>
			<input type="hidden" name="upload_file[]" value="<?=$field_name?>">
			<input type="hidden" name="upload_path[]" value="<?=$field_def['Path']?>">

			<div style="display: <?=$autogen_section_vis?>">
				<input style="position: relative; top: 1px" type="checkbox" name="autogen_<?=$field_name?>" value="1" <?=$autogen_value?>
				onClick="javascript: 
				if (autogen_<?=$field_name?>.checked == 1) { 
					autogen_info_<?=$field_name?>.style.display = ''
				} else { 
					autogen_info_<?=$field_name?>.style.display = 'none'
				}"
				 <?=$autogen_value?>>
				<span style="width: 30px">autogenerate:</span>
			</div>
			<div align="right" id="autogen_info_<?=$field_name?>" style="display: <?=$autogen_default_vis?>; padding-right: 30px">
				from: 
				<select name="autogen_from_<?=$field_name?>" style="margin-right: 20px">
					<?=$autogen_from_options?>
				</select>
				width: <input type="text" name="autogen_x_<?=$field_name?>" value="<?=$autogen_x?>" style="width: 30px; text-align: right" onFocus="javascript: if (record_form.autogen_lockaspect_<?=$field_name?>.checked == 1) autogen_y_<?=$field_name?>.value='auto'; this.value=''"> px&nbsp;&nbsp;&nbsp;
				height: <input type="text" name="autogen_y_<?=$field_name?>" value="<?=$autogen_y?>" style="width: 30px; text-align: right" onFocus="javascript: if (record_form.autogen_lockaspect_<?=$field_name?>.checked == 1) autogen_x_<?=$field_name?>.value='auto'; this.value=''"> px
				<br>
				lock aspect ratio: <input name="autogen_lockaspect_<?=$field_name?>" type="checkbox" value="1" <?=$autogen_lock?>>
				<?=$default_link?>
			</div>
			<br>
		</td>
	</tr>
</table>