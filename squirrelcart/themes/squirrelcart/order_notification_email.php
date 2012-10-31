<?=$Company_Name?> - Order # <?=$Order_Number?>
----------------------------------------------------------------
Date of order: <?=$Order_Date?>

Order Summary:
----------------------------------
Total number of items ordered: <?=$Number_of_Items?>
Product total: <?=$Product_Total?>
Shipping total: <?=$Shipping_Total?>
Tax total: <?=$Tax_Total?>
Grand Total: <?=$Grand_Total?>

Item breakdown:
----------------
<?=$Item_Breakdown?>

Billing Address:
--------------------------------
<?=$Billing_First_Name?> <?=$Billing_Last_Name?>
<?=$Billing_Street?>
<?=$Billing_Street_2?>
<?=$Billing_City?>, <?=$Billing_State_or_Province?> <?=$Billing_Postal_Code?>
<?=$Billing_Country?>
Email Address: <?=$Billing_Email_Address?>
Phone: <?=$Billing_Phone?>

Shipping Address
--------------------------------
<?=$Shipping_First_Name?> <?=$Shipping_Last_Name?>
<?=$Shipping_Street?>
<?=$Shipping_Street_2?>
<?=$Shipping_City?>, <?=$Shipping_State_or_Province?> <?=$Shipping_Postal_Code?>
<?=$Shipping_Country?>
Email Address: <?=$Shipping_Email_Address?>
Phone: <?=$Shipping_Phone?>
Special Instructions: <?=$Shipping_Special_Instructions?>

<?=$Shipping_Breakdown?>
Payment Info
--------------------------------
Payment method: <?=$Payment_Method?>
<?=$CC_Info?>

For your security, here is some information about the computer that placed this order:

IP Address: <?=$IP_Address?>
Host Name: <?=$REMOTE_HOST?>
User Agent: <?=$HTTP_USER_AGENT?>
Referer: <?=$HTTP_REFERER?>