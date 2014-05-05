<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");

require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo(); $smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);	

require('../classes/class_ref_user.php'); $cls_ref_user = new RefUser(); 
$userId = isset($_GET[uid])?intval($_GET[uid]):0;
if($userId>0){
    $affiliate_earnings = 0;
    $affiliate_earnings = $cls_ref_user->getAffiliateEarning($userId,'arr');

    $ref_val = $cls_ref_user->get_my_ref($userId);
    if($ref_val)
    $total_coupon = $cls_ref_user->getAffiliateFromAdv($userId,$ref_val);
    $affiliate_earnings[refer_coupon]= $total_coupon;

    $affiliate_earnings[total] =  my_money_format('%i',$affiliate_earnings[total] + $total_coupon);
    $affiliate_earnings[publisher] =  my_money_format('%i',$affiliate_earnings[publisher]);
    $affiliate_earnings[advertiser] =  my_money_format('%i',$affiliate_earnings[advertiser]);

    $smarty->assign('affiliate_earnings', $affiliate_earnings);
    $smarty->assign('from_name', $cls_user->getUserName($userId));

    $cons = '1=1 ';
    $cons .= " and ref_code='".$ref_val."' ";
    $cons .= " ORDER BY aff_money DESC ";

    $all_affiliateninfo = $cls_user->getListPage($cons);
    $smarty->assign('all_affiliateninfo', $all_affiliateninfo);
    $paging = $cls_user->getNavPage($cons);
    $smarty->assign('paging', $paging);
    $cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
    $smarty->assign('cursorPage', $cursorPage);
}
//@ case for edit action
$edit_action = isset($_GET[edit])?intval($_GET[edit]):0;
if($edit_action>0){
    $pub_info = $cls_Publishersinfo->getOne($edit_action);
    $smarty->assign('pub_info', $pub_info);
        //@ update action
        $websitename = isset($_POST[websitename])?addslashes($_POST[websitename]):'';
        $description = isset($_POST[description])?addslashes($_POST[description]):'';
        if($websitename && $description){
        $value = "websitename='".$websitename."'";
        $value .= ",description='".$description."'";
        $cls_Publishersinfo->updateOne($edit_action, $value);
        header("location: ".$_config['www']."/admin/publisherinfo.php");
    }
}

$smarty->assign('msg', $msg);
$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('affiliateinfo.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>