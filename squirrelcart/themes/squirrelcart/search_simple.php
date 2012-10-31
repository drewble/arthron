<!-- template for a smiple search that searches only the name, description, and keywords of all products -->
<br>
<form id="search" action="" style="margin: 0;">
<!--Search:-->
<input type="text" name="qry" size="9" value="<?=$qry_value?>" style="margin:0" <? if($qry_value != "Search") ?> onFocus="javascript:search.qry.value=''" <?;?>>
<span style="position:relative; top: 3"><?=$Search_Simple_Submit_Button?></span>
	<input type="hidden" name="action" value="show">
	<input type="hidden" name="mode" value="post">
	<input type="hidden" name="search_type" value="any">
	<input type="hidden" name="search_mode" value="simple">
<br>
<?=$Advanced_Search_Link?>
</form>