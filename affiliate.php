<?php
include ("include/config.php");
$msg = array();
require('classes/class_coupon.php'); $class_coupon = new Coupon(); $smarty->assign('class_coupon', $class_coupon);
require('classes/class_ref_user.php'); $cls_ref_user = new RefUser(); $smarty->assign('cls_ref_user', $cls_ref_user);
$ref_val = $cls_ref_user->get_my_ref(); $smarty->assign('ref_val', $ref_val);

if(!$_SESSION['uid']) header('Location: '.$_config['www'].'/account.php');

$do = isset($_GET['do'])?addslashes($_GET['do']):'';

//delete Coupon
if($_GET['confirm'] && $_GET['type']=='delete'){
		$count_coupon = $class_coupon->getCount('user_id='.$_SESSION['uid'].' and coupon_id='.intval($_GET[confirm]));
		if($count_coupon){
			$class_coupon->deleteOne(intval($_GET[confirm]));
			$msg['success']='Delete coupon successful!';
		}
	}
//end delete Coupon

if($do == 'manage'){
	//get List my coupon	
	$cons = " user_id =". $_SESSION['uid']." ";
	$all_coupon = $class_coupon->getListPage($cons);
    $smarty->assign('all_coupon', $all_coupon);
    $paging = $class_coupon->getNavPage($cons);
    $smarty->assign('paging', $paging);
    $cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
    $smarty->assign('cursorPage', $cursorPage);
	//end get list	
	$coupon_name = isset($_POST['code'])?$_POST[code]:'';
	$discount = isset($_POST['discount'])?$_POST[discount]:'';
	if(strlen($coupon_name)<6 && $coupon_name){
		$msg['error'] = 'Your coupon name must be a minimum of 6 characters in length.';
	}elseif(strlen($coupon_name)>=6 && $coupon_name){
		$temp_date = date("Y-m-d");
		$start_date = isset($_POST[start_date])?$_POST[start_date]:date('Y-m-d');
		$end_date = isset($_POST[end_date])?$_POST[end_date]:date('Y-m-d', strtotime('+100 day', strtotime($temp_date)));
		$percent = 10;
		$length = 1;
		$f = 'code, user_id, start_date, end_date, percent, length, ref_code';
		$v = "'".$coupon_name."'";
		$v .= ",'".$_SESSION['uid']."'";
		$v .= ",'".addslashes($start_date)."'";
		$v .= ",'".addslashes($end_date)."'";
		$v .= ",'".addslashes($percent)."'";		
		$v .= ",'".addslashes($length)."'";	
		$v .= ",'".addslashes($ref_val)."'";		
		if($class_coupon->insertOne($f  , $v)) $msg['success']='Coupon added!';
	}
	if($coupon_name)
	$smarty->assign('msg',$msg);
	$content = $smarty->fetch('affiliate_coupons.tpl');
}else{
	$content = $smarty->fetch('affiliate.tpl');
}
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>