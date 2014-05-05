<?php
include ("include/config.php");

if(!isset($_SESSION[uid]))
	header("location: account.php");


	$as = mysql_fetch_assoc(mysql_query("select * from publishers_adspaces where ad_id='$_REQUEST[order_product_id]'"));
			$smarty->assign('ad_space', $as);
	
	$getit = mysql_fetch_assoc(mysql_query("select * from advertisersinfo where uid='$_SESSION[uid]' and adv_id='$_REQUEST[adv_id]'"));
			$smarty->assign('ainfo', $getit);		
			
	$w = mysql_fetch_assoc(mysql_query("select * from publishersinfo where pid='$as[pid]'"));
			$smarty->assign('winfo', $w);
		
if(isset($_POST[submit_ppc]))
	if(mysql_query("update advertisersinfo set ppc_balance='$_POST[ppc_balance]' where adv_id='$_GET[adv_id]' and uid='$_SESSION[uid]'"))
		header("location: cart.php");

	


$smarty->assign('right_panel', 'off');
$smarty->assign('number_format_js', 'Y');
$content = $smarty->fetch('buy_ads_ppc.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>