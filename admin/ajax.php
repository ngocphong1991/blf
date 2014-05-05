<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo(); $smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);
require('../classes/class_earnings.php'); $cls_earnings = new Earnings();
#

if($_POST['refunds']!='' && isset($_POST[refunds])) {
    $adv_id = isset($_POST['adv_id'])?intval($_POST['adv_id']):0;
    $adv_info = $cls_advertisersinfo->getOne($adv_id);
    if($_SESSION[admin_utype]==1){
        if($adv_info[uid]>0 && $adv_info[price]>0){
            $true_money = $cls_user->plusMoney($adv_info[uid], $adv_info[price]);
            $total_wesite_earn = $cls_earnings->getSiteEarning($adv_info[pid], $adv_info[adv_id]);
            if($total_wesite_earn>0)
            $cls_user->minusMoney($adv_info[uid], $total_wesite_earn);

            if($true_money){
                $value = "is_paid='A'";
                $cls_advertisersinfo->updateOne($adv_id, $value);
            //$cls_advertisersinfo->deleteOne($adv_id);
            }
        }
    }
}

if($_GET['auth']!='' && isset($_GET[action])) {
    $auth_action = isset($_GET['auth'])?intval($_GET['auth']):0;
    if($auth_action>0){
        $adv_info = $cls_advertisersinfo->getOne($auth_action);
        $smarty->assign('adv_info', $adv_info);
            //@ update action
            $action = isset($_GET[action])?addslashes($_GET[action]):'';
            if($action=='active'){
                $value = "is_auth='Y'";
                $cls_advertisersinfo->updateOne($auth_action, $value);
            }elseif($action=='cancel'){
                $value = "is_auth='N'";
                $cls_advertisersinfo->updateOne($auth_action, $value);
            }
    }		header("location: ".$_config['www']."/admin/advertiserinfo.php");

}

if(isset($_GET[q])) {
    $adv_id = isset($_GET['q'])?intval($_GET['q']):0;
    if($adv_id>0){
        $adv_info = $cls_advertisersinfo->getOne($adv_id);
        $start_date = $adv_info["start_date"];
         $end_date = $adv_info["end_date"];
          //echo $value;
          $date1 = date('Y-m-d');
          $date3 = strtotime($date1)-strtotime($start_date);
          $_days=24*60*60;
          //echo $start_date;
          $days = $date3-($date3%$_days);
          $days=$days/$_days;

          $start_date = date('Y-m-d', strtotime('+'.$days.' day', strtotime($start_date)));
         //echo $start_date;

          $end_date = date('Y-m-d', strtotime('+'.$days.' day', strtotime($end_date)));
          //echo $end_date;
          $value = "start_date='".$start_date."',end_date='".$end_date."' ";

          $cls_advertisersinfo->updateOne($adv_id, $value);
          echo $start_date;
    }
}
?>