<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
require('../classes/class_coupon_card.php'); $class_coupon = new Coupon(); $smarty->assign('class_coupon', $class_coupon);
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo();
$smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);
#

$uid = isset($_GET[uid])?intval($_GET[uid]):0;

//confirm=0&type=yes
$coupon_id = isset($_GET[confirm])?intval($_GET[confirm]):0;
if($coupon_id>=0 && $_GET[type]=='yes') {
    $class_coupon->updateOne($coupon_id, "status=1");
    $msg = ' Cập nhật trạng thái thành công';
}elseif($coupon_id>=0 && $_GET[type]=='no'){
    $class_coupon->updateOne($coupon_id, "status=0");
    $msg = ' Cập nhật trạng thái thành công';
}elseif($coupon_id>0 && $_GET[type]=='delete'){
    $class_coupon->deleteOne($coupon_id);
    $msg = ' Xóa Coupon thành công';
}

$temp_date = date("Y-m-d");
$action = isset($_POST[admore_coupon])?$_POST[admore_coupon]:'';

if(isset($_POST["gen_code"])){
    $gen_code = $class_coupon->getRandom();
    $smarty->assign('gen_code', $gen_code);
}
if($action=='addmore'){
    $total = isset($_POST[total])?$_POST[total]:0;
    //$start_date = isset($_POST[start_date])?$_POST[start_date]:date('Y-m-d');
    //$end_date = isset($_POST[end_date])?$_POST[end_date]:date('Y-m-d', strtotime('+30 day', strtotime($temp_date)));
    //$total = isset($_POST[total])?$_POST[total]:0;
    $use_time = isset($_POST[use_time])?$_POST[use_time]:1;
    $ref_code = isset($_POST[ref_code])?$_POST[ref_code]:'';
    $f = 'total, use_time, ref_code, for_uid';
    $v = "'".$total."'";
    $v .= ",'".addslashes($use_time)."'";
    $v .= ",'".addslashes($ref_code)."'";
    $v .= ",'".$uid."'";
    if($class_coupon->insertOne($f  , $v)) $msg='Thêm Coupon thành công';
}

$cons = '1=1 ';
 if($_GET['keyword']) {
    $cons .= " and total like '%".$_GET['keyword']."%' ";
    $smarty->assign('keyword', $_GET['keyword']);
}

$all_coupon = $class_coupon->getListPage($cons);
$smarty->assign('all_coupon', $all_coupon);
$paging = $class_coupon->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

$smarty->assign('msg', $msg);
$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('coupon_card.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>