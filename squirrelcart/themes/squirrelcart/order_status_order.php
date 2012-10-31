<!--
	Template file: order_status_order
	This file controls the appearance of an single order in the Order Status section, which appears when 
	a customer clicks on "Order Status" in account options. This file displays a link that will take the customer to
	a page to view the detail of the order, which is controlled by template file "order_status_detail"
-->
	<tr>
		<td class="<?=$TD_Class?>" style="text-align: left"><?=$Order_Month?>/<?=$Order_Day?>/<?=$Order_Year?></td>
		<td class="<?=$TD_Class?>" style="text-align:right"><?=$Order_Time?></td>
		<td class="<?=$TD_Class?>"><a href="<?=$Order_Detail_HREF?>"><?=$Order_Number?></a></td>
		<td class="<?=$TD_Class?>" style="text-align: right"><?=$Grand_Total?></td>
		<td class="<?=$TD_Class?>" style="text-align: right"><?=$Order_Status?></td>
	</tr>
