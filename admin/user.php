<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_bank.php'); $cls_bank = new Bank(); $smarty->assign('cls_bank', $cls_bank);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_ref_user.php'); $cls_ref_user = new RefUser(); $smarty->assign('cls_ref_user', $cls_ref_user);
$ref_val = $cls_ref_user->get_my_ref();

//@ get Affiate earning this user.
$affiliate_money = $cls_ref_user->getAffiliateEarning(1);

//@ end get Affiliate earning.
$cons = '1=1 ';
 if($_GET['keyword']) {
    $cons .= " and username like '%".$_GET['keyword']."%' ";
    $smarty->assign('keyword', $_GET['keyword']);
}
//echo $cons;
$all_user = $cls_user->getListPage($cons);
$smarty->assign('all_user', $all_user);
$paging = $cls_user->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

###
$smarty->assign('msg', $msg);
$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST']."/admin/user.php";
$smarty->assign('protocol', $protocol);
$content = $smarty->fetch('user.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>