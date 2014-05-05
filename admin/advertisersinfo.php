<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo(); $smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
#

$cons = '1=1 ';
if($_GET['keyword']) {
    $cons .= " and uid in (SELECT uid FROM users WHERE username like '%".$_GET['keyword']."%') ";
    $smarty->assign('keyword', $_GET['keyword']);
}
if($_GET['is_manual']=='Y') {
    $cons .= " and pid in (SELECT pid FROM advertisersinfo WHERE is_manual='Y') ";
    $smarty->assign('is_manual', $_GET['is_manual']);
}elseif($_GET['is_manual']=='N'){
    $cons .= " and pid in (SELECT pid FROM advertisersinfo WHERE is_manual='N') ";
    $smarty->assign('is_manual', $_GET['is_manual']);
}

if($_GET['approved']!='') {
    $cons .= " and approved='".$_GET['approved']."' ";
    $smarty->assign('approved', $_GET['approved']);
}
if($_GET['auth']!='') {
    $cons .= " and is_auth='".$_GET['auth']."' ";
    $smarty->assign('auth', $_GET['auth']);
}
if($_GET['paid']!='') {
    $cons .= " and is_paid='".$_GET['paid']."' ";
    $smarty->assign('paid', $_GET['paid']);
}
if($_GET['is_manual']!='') {
    $cons .= " and is_manual='".$_GET['is_manual']."' ";
    $smarty->assign('is_manual', $_GET['is_manual']);
}
echo $cons;
$all_advertisersinfo = $cls_advertisersinfo->getListPage($cons);
$smarty->assign('all_advertisersinfo', $all_advertisersinfo);
$paging = $cls_advertisersinfo->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('advertisersinfo.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>