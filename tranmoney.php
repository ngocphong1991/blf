<?php
include ("include/config.php");
$msg = "";

require('classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('classes/class_transection.php'); $cls_transection = new Transection(); $smarty->assign('cls_transection', $cls_transection);

if($_SESSION['uid'] == '' or !$cls_user->is_publishers($_SESSION['uid'])) header('location: '.$_config[www]);

if($_POST['data_trans']) {
    if($cls_user->trans_money($_POST['data_trans'])) {
        $f = 'user_id, money, reg_date';
        $v = "'".$_SESSION['uid']."'";
        $v .= ",'".$_POST['data_trans']."'";
        $v .= ",'".time()."'";
        
        if($cls_transection->insertOne($f, $v)) $msg = "Transfer money successful";
        else $msg = "Error insert transection";
        
    } else $msg = "Error while transfer money";
    
    $smarty->assign('msg', $msg);
}

$my_profile = $cls_user->getOne($_SESSION['uid']);
$smarty->assign('my_profile', $my_profile);

$pub_money_str = number_format($my_profile['pub_money']); $smarty->assign('pub_money_str', $pub_money_str);
$adv_money_str = number_format($my_profile['adv_money']); $smarty->assign('adv_money_str', $adv_money_str);


$content = $smarty->fetch('tranmoney.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>