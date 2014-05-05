<?php include ("include/config.php");
if(!isset($_SESSION[uid]) || $_SESSION[uid]<=0) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<center>
  <font face='Verdana, Arial, Helvetica, sans-serif'>Please Wait...</font>
  <form name="paypal_pay" method="post" action="https://www.paypal.com/cgi-bin/webscr" >
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="tax" value="0">
  <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
  <input type='hidden' name='no_shipping' value='1'>
  <input type='hidden' name='shipping' value='0' />
  <input type='hidden' name='currency_code' value="<?=$_config['CURRENCY_CODE']?>" />
  <input type='hidden' name='no_note' value='1' />
  <input type="hidden" name="business" value="thanhtoan@textlink.vn">
  <input type='hidden' name='upload' value='1' />
  <input type='hidden' name='return' value='<?=$_config['www']?>/cart?charge=success'>
  <input type='hidden' name='custom' value='<?=$_SESSION[uid]?>' />
  <input type='hidden' name='cancel_return' value='<?=$_config['www']?>/browse.php'>
  <input type='hidden' name='notify_url' value='<?=$_config['www']?>/notify.php?uid=<?=$_SESSION[uid]?>&status=1'> 

  <?php
	$adv_payment = mysql_query("select * from advertisersinfo where uid='$_SESSION[uid]' and is_paid='N' order by adv_id desc");
	$counter=0;
	while($row = mysql_fetch_assoc($adv_payment)) {	
		$info_site = mysql_query('select websitename from publishersinfo where pid='.$row[pid]);
		//echo 'select websitename, set_price from publishersinfo where pid='.$row[pid];
		$web_name = mysql_result($info_site, 0, 'websitename');
		if($_SESSION[length]>1 && $_SESSION[couponPrice]>0)
			$price = ($row[price] - $row[price]*$_SESSION[couponPrice])*$_SESSION[length];
		elseif($_SESSION[couponPrice]>0)
			$price = $row[price] - $row[price]*$_SESSION[couponPrice];
		else $price = $row[price];
		?>
		<input type="hidden" name="item_name_<?=++$counter?>" value="<?=$row[ad_url].' (on '.$web_name.')'?>">
		<input type="hidden" name="amount_<?=$counter?>" value="<?=$price;?>">
		<input type="hidden" name="item_number_<?=$counter?>" value="ADV<?=$row[adv_id]?>">	
  <?php }?>
  </form>  
<script type="text/javascript">
	document.forms['paypal_pay'].submit();
</script>
</center>
</body>
</html>