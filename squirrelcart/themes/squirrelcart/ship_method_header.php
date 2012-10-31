<?=$Shipping_Method_Image?><br><br>

<!-- DO NOT REMOVE OR CHANGE THE NEXT LINE!!! PROGRAMMATIC USE ONLY!! -->
<? if ($Dont_Compete) { ?>




<div class="cart_instruction">Please click a shipping courier to view rates and services...</div><br>




<!-- DO NOT REMOVE OR CHANGE THE NEXT LINE!!! PROGRAMMATIC USE ONLY!! -->
<? } else { ?>




<div class="cart_instruction">Please choose your shipping method...</div>
<form name="cart" id="cart" action="<?=$Form_Action?>" method="get">
<input type="hidden" name="shipping_method" value="1">



<!-- DO NOT REMOVE OR CHANGE THE NEXT LINE!!! PROGRAMMATIC USE ONLY!! -->
<? } ?>







