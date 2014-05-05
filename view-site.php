<?php
include ("include/config.php");
require('classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo();
$smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);

if(!isset($_SESSION[uid])) header('Location: http://textlink.vn/');
$pid = isset($_GET[pid])?intval($_GET[pid]):0;
$list = $cls_Publishersinfo->getOne($pid);

if($list['domain_age'])
$list['domain_age'] = timeAgo($list['domain_age']);

$smarty->assign('list',$list);
$smarty->assign('site',$site);
$smarty->display('master_view.tpl');
?>