<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
require('../classes/class_withdraw.php'); $class_withdraw = new Withdraw(); $smarty->assign('class_withdraw', $class_withdraw);
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo();
$smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);
#
//confirm=0&type=yes
$withdraw_id = isset($_GET[confirm])?intval($_GET[confirm]):0;
if($withdraw_id>=0 && $_GET[type]=='yes') {
    $class_withdraw->updateOne($withdraw_id, "status=1, pay_date=CURDATE()");
    $msg = ' Cập nhật trạng thái thành công';
}elseif($withdraw_id>=0 && $_GET[type]=='no'){
    $class_withdraw->updateOne($withdraw_id, "status=0, pay_date=CURDATE()");
    $msg = ' Cập nhật trạng thái thành công';
}

$cons = '1=1 ';
 if($_GET['keyword']) {
    $cons .= " and uid in (SELECT uid FROM users WHERE username like '%".$_GET['keyword']."%') ";
    $smarty->assign('keyword', $_GET['keyword']);
}

if($_GET['status']!='') {
    $cons .= " and status='".$_GET['status']."' ";
    $smarty->assign('status', $_GET['status']);
}
if($_GET['code']!='') {
    $cons .= " and code='".$_GET['code']."' ";
    $smarty->assign('code', $_GET['code']);
}
$cons .= " ORDER BY withdraw_id DESC ";


$all_withdraw = $class_withdraw->getListPage($cons);
$smarty->assign('all_withdraw', $all_withdraw);
$paging = $class_withdraw->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('payouts.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>