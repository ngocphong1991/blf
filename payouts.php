<?php
include ("include/config.php");
$msg = "";
require('classes/class_withdraw.php'); $class_withdraw = new Withdraw(); $smarty->assign('class_withdraw', $class_withdraw);
require('classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);	
require('classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo();
$smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);

$smarty->assign('yes', 0);
if($_SESSION[utype] =='pub' || $_SESSION[utype] =='pub+adv'){
	$cons = 'user_id= '.$_SESSION[uid];	   
    //$cons .= " and status=1 ";
      
    $all_withdraw = $class_withdraw->getListPage($cons);
	if(count($all_withdraw)>0)
	$smarty->assign('yes', 1);
    $smarty->assign('all_withdraw', $all_withdraw);
    $paging = $class_withdraw->getNavPage($cons);
    $smarty->assign('paging', $paging);
    $cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
    $smarty->assign('cursorPage', $cursorPage);
}

$content = $smarty->fetch('payouts.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>