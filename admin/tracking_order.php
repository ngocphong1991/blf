<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_tracking.php'); $cls_tracking = new Tracking();
$tracking_info = $cls_tracking->getTrackingByUser('');
#
if($_GET && count($_GET)) {
    $con = " ";
    if(isset($_GET['fullname']) && $_GET['fullname']) $con .= " AND fullname LIKE '%".$_GET['fullname']."%'" ;
    if(isset($_GET['email']) && $_GET['email']) $con .= " AND email LIKE '%".$_GET['email']."%'" ;
    $tracking_info = $cls_tracking->getTrackingByUser($con);
}

$smarty->assign('tracking_info', $tracking_info);
$content = $smarty->fetch('tracking_order.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>