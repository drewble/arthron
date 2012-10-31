<form action="<?=$Form_Action?>" method="get">
	<?=$Show_Cart?><!-- DO NOT REMOVE OR MODIFY THIS LINE! It controls whether or not the checkout is displayed when adding to the cart -->
	<input type="hidden" name="microtime" value="<?=$Microtime?>">
	
  <table border="0">
    <tr> 
      <td colspan="2"> <div class="product_name" style="margin-bottom: 10; width: 100%"> 
          <?=$Name?>
          <?=$Admin_Link?>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" td valign="top"> 
        <?=$Image_in_Large_Image_Link?>
      </td>
    </tr>
    <tr> 
      <td colspan="2" td valign="top"> 
        <?=$Description?>
      </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <?=$Base_Price?>
        <br> <br> 
        <?=$Options?>
      </td>
    </tr>
    <tr> 
      <td colspan="2" style="text-align: center"> 
        <?=$Agreement?>
      </td>
    </tr>
    <tr> 
      <td colspan="2"> <table width="100%" border="0" cellpadding="8">
          <tr> 
            <td width="50%" style="text-align:right"> <b>Quantity: </b> <input type="text" name="quantity" size="3" value="1"> 
            </td>
            <td width="50%" style="padding-top:10px; text-align: left"> 
              <?=$Add_to_Cart?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>