<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_bank.php'); $cls_bank = new Bank(); $smarty->assign('cls_bank', $cls_bank);
require('../classes/class_pay_atm.php'); $cls_pay_atm = new PayAtm(); $smarty->assign('cls_pay_atm', $cls_pay_atm);
require('../classes/class_session_pay.php'); $cls_session_pay = new SessionPay(); $smarty->assign('cls_session_pay', $cls_session_pay);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
#
if($_GET['confirm']!='') {
    $id = $_GET['confirm'];
    $onePay = $cls_pay_atm->getOne($id);
    $oneBank = $cls_bank->getOne($onePay['bank_id']);
    if($_GET['type']=='yes') $status = '1';
    else $status = '-1';
    $cls_pay_atm->updateOne($id, "status='".$status."'");

    if($status=='1') {
        $message = '<p>Dear '.$onePay['fullname'].'!</p>Tài khoản của bạn đã được xác nhận';
        $f = 'uid, type, money, reg_date';
        $v = "'".$onePay['uid']."','".$oneBank['name']."','".$onePay['money']."','".time()."'";
        if(!$cls_session_pay->insertOne($f, $v)) die('Error SQL: Cannot insert session table');
        if(!$cls_user->plusMoney($onePay['uid'],$onePay['money'] )) die('Error SQL: Cannot update money field in user table');
        #

    } elseif($status=='-1') {
        $message = '<p>Dear '.$onePay['fullname'].'!</p>TextLink chưa nhận được tài khoản của bạn. Vui lòng kiểm tra lại';
    }
    $to      = $onePay['email'];
    $subject = 'Thông báo từ TextLink Ads về ...';
    $headers = 'TextLink Ads';
    mail($to, $subject , $message);
    header('location: ?');
}
#
$cons = '1=1';
$all_pay_atm = $cls_pay_atm->getListPage($cons." order by reg_date desc ");
$smarty->assign('all_pay_atm', $all_pay_atm);
$paging = $cls_pay_atm->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('pay-card.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>