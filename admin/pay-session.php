<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_bank.php'); $cls_bank = new Bank(); $smarty->assign('cls_bank', $cls_bank);
require('../classes/class_session_pay.php'); $cls_session_pay = new SessionPay(); $smarty->assign('cls_session_pay', $cls_session_pay);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
#
$uid = $_GET['uid'];
$oneUser = $cls_user->getOne($uid);
$smarty->assign('oneUser', $oneUser);
#
if($_POST['data'] && $_POST['data']['type']!='' && $_POST['data']['money']!='') {
    if($_SESSION[admin_utype]==1){
        $data = $_POST['data'];
        $field = 'reg_date, uid'; $value = "'".time()."', '".$uid."'";
        foreach ($data as $key => $val) {
            if($val!=''){
                $field.=",".$key;
                $value .= ",'".addslashes($val)."'";
            }
        }
        if(!$cls_session_pay->insertOne($field, $value)) {
            die('Error');
        } else {
            $cls_user->plusMoney($uid, $data['money']);
        }
    }else $msg='Bạn không có quyền nạp tiền cho user';
}
#
$cons = "uid='$uid'";
$all_session_pay = $cls_session_pay->getListPage($cons." order by reg_date desc ");
$smarty->assign('all_session_pay', $all_session_pay);
$paging = $cls_session_pay->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);
$smarty->assign('cursorTime', time());

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('pay-session.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>