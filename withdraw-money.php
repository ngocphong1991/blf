<?php
include ("include/config.php");
$msg = "";

require('classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('classes/class_transection.php'); $cls_transection = new Transection(); $smarty->assign('cls_transection', $cls_transection);

require('classes/class_ref_user.php'); $cls_ref_user = new RefUser(); $ref_val = $cls_ref_user->get_my_ref();

$affiliate_earnings=0; $affiliate_earnings = $cls_ref_user->getAffiliateEarning($_SESSION[uid]);
if($_SESSION['uid'] == '' or !$cls_user->is_publishers($_SESSION['uid'])) header('location: '.$_config[www]);

$money = isset($_POST[data_trans])?intval($_POST[data_trans]):0;
$name_card = isset($_POST[fullname])?addslashes($_POST[fullname]):'';
$payment_method = isset($_POST[payment_method])?addslashes($_POST[payment_method]):'';
$name_bank = isset($_POST[name_of_bank])?addslashes($_POST[name_of_bank]):'';
$number_card = isset($_POST[number_account_bank])?intval($_POST[number_account_bank]):0;
$mobile = isset($_POST[mobile])?intval($_POST[mobile]):0;
$email_paypal = isset($_POST[paypal_email])?addslashes($_POST[paypal_email]):'';
$color = 'red';
$code = unique_id(7);
// check error 
if(isset($_POST[data_trans])){
	if($money<=0) $error[] = "Your money withdraw must be greater than 0.";		
	if(!$payment_method) $error[] = "Please choose your withdraw method.";
	
	if($_SESSION[uid]>0)
	$one = $cls_user->getOne($_SESSION[uid]);  
	
	if($payment_method=='2' && $_SESSION[uid]){
	if(!$name_card) $error[] = "Vui lòng nhập họ tên chủ tài khoản nhận tiền.";
	if(!$name_bank) $error[] = "Vui lòng điền thông tin ngân hàng mà bạn muốn nhận tiền.";
	if(!$number_card) $error[] = "Vui lòng điền thông tin số tài khoản ngân hàng của bạn.";
   
if(count($error)==0 && $money>0 && $money <= $one['pub_money']){	
	$res = mysql_query('' . 'INSERT INTO `withdraw` ( `user_id` , `money` , `withdraw_date` , `method` , `name_card` ,`number_card`, `phone` , `email_paypal` , `email` , `name_bank` , `code`) VALUES (\'' . $_SESSION['uid'] . '\', \'' . $money . '\', curdate(), \'' . $payment_method . '\', \'' . $name_card . '\', \'' . $number_card . '\', \'' . $phone . '\', \'' . $email_paypal . '\', \'' . $email . '\', \'' . $name_bank . '\', \'' . $code . '\' )');
	
if($money>0 && $res){
		$cls_user->WithDraw($money);
		$color ='green';
		$error[] = "Yêu cầu rút tiền của bạn đã được gửi tới ban quản trị. Chúng tôi sẽ tiến hành thanh toán trong tuần đầu tiên của tháng kế tiếp.";
		}
	}
}
elseif($payment_method=='1' && $_SESSION[uid]){
	if(!$email_paypal) $error[] = "Please enter your PayPal email address.";
	if(count($error)==0 && $money>0 && ($money < $one['pub_money'])){
		//echo '' . 'INSERT INTO `withdraw` ( `user_id` , `money` , `withdraw_date` , `method` , `name_card` ,`number_card`, `phone` , `email_paypal` , `email` , `name_bank` , `code`) VALUES (\'' . $_SESSION['uid'] . '\', \'' . $money . '\', curdate(), \'' . $payment_method . '\', \'' . $name_card . '\', \'' . $number_card . '\', \'' . $phone . '\', \'' . $email_paypal . '\', \'' . $email . '\', \'' . $name_bank . '\', \'' . $code . '\' )';
		
		$res = mysql_query('' . 'INSERT INTO `withdraw` ( `user_id` , `money` , `withdraw_date` , `method` , `name_card` ,`number_card`, `phone` , `email_paypal` , `email` , `name_bank` , `code`) VALUES (\'' . $_SESSION['uid'] . '\', \'' . $money . '\', curdate(), \'' . $payment_method . '\', \'' . $name_card . '\', \'' . $number_card . '\', \'' . $phone . '\', \'' . $email_paypal . '\', \'' . $email . '\', \'' . $name_bank . '\', \'' . $code . '\' )');
		
		if($money>0 && $res)
		$cls_user->WithDraw($money);
		$color ='green';
		$error[] = "Update successful we will transfer money to you in 24 hours.";
	}
}

$smarty->assign('color',$color);
$smarty->assign('error',$error);
}
$my_profile = $cls_user->getOne($_SESSION['uid']);
$smarty->assign('my_profile', $my_profile);

$pub_money_str = number_format($my_profile['pub_money']); $smarty->assign('pub_money_str', $pub_money_str);
$adv_money_str = 0; $smarty->assign('adv_money_str', $adv_money_str);
$smarty->assign('affiliate_money_str', $affiliate_earnings);
$content = $smarty->fetch('withdraw-money.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>