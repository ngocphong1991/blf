<?php
include ("include/config.php");
include_once("global.php");
$msg = "";
if(!$_SESSION['uid'] || $_SESSION['uid']<=0) exit();
$smarty->assign('cls_user', $cls_user);

require('classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('classes/class_country.php'); $cls_country = new Country(); $smarty->assign('cls_country', $cls_country);
require('classes/class_ref_user.php'); $cls_ref_user = new RefUser();
require('classes/class_transection.php'); $cls_transection = new Transection(); $smarty->assign('cls_transection', $cls_transection);
require('classes/class_payments.php'); $cls_payments = new Payments();
require('classes/class_tracking.php'); $cls_tracking = new Tracking();

if(isset($_GET['page']) && $_GET['page'] == 'history'){
    $cls_tracking = $cls_tracking->getAll('uid='.$_SESSION['uid']);
}

$smarty->assign('genders',getGenders());
$smarty->assign('cls_tracking',$cls_tracking);
$pending_money = $cls_advertisersinfo->getPendingMoney();
$smarty->assign('pending_money',$pending_money);

$ref_val = $cls_ref_user->get_my_ref();
$affiliate_earnings = 0;
$affiliate_earnings = $cls_ref_user->getAffiliateEarning($_SESSION['uid'],'arr');

if($ref_val)
$total_coupon = $cls_ref_user->getAffiliateFromAdv($_SESSION['uid'],$ref_val);
$affiliate_earnings['refer_coupon']= $total_coupon;

$affiliate_earnings['total'] =  my_money_format('%i',$affiliate_earnings['total'] + $total_coupon);
$affiliate_earnings['publisher'] =  my_money_format('%i',$affiliate_earnings['publisher']);
$affiliate_earnings['advertiser'] =  my_money_format('%i',$affiliate_earnings['advertiser']);
if($_POST['action']=='update_info') {
    $myProfile = $cls_user->getMyProfile();
    $i = 0;
    foreach ($_POST['data'] as $key => $val) {
        if($val!=''){
            if($i==0) {
                $i++;
                $value = $key."='".addslashes($val)."'";
            } else {
                $value .= ",".$key."='".addslashes($val)."'";
            }
        }
    }

    if (!file_exists('uploads/avatars'))
        mkdir('uploads/avatars');
    if ($_FILES["avatar"]["name"] != null) {
        if(!in_array($_FILES["avatar"]["type"],array("image/jpeg", "image/pjpeg", "image/gif", "image/png")))
            $msg_error = 'Định dạng file ảnh không đúng, vui lòng chọn file ảnh có định dạng .jpg, .png hoặc .gif';
        else{
            $newFile = "avatar_" . $_FILES["avatar"]['size'] . "_" . time('now') . "." . substr($_FILES["avatar"]["name"], strrpos($_FILES["avatar"]["name"], '.') + 1);
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "uploads/avatars/" . $newFile);
            unlink($myProfile['avatar']);
            $value .= ", avatar = '".$_config['www']."/uploads/avatars/".$newFile."'";
        }
    }
    if(!$msg_error){
        if($cls_user->updateOne($myProfile['uid'], $value)) {
            $msg_profile = 'Thông tin của bạn đã được cập nhật';
        }
    }
}
if($_POST['action']=='update_pass') {
    $myProfile = $cls_user->getMyProfile();

    if(strlen($_POST['data']['password'])<6) {
        $msg_error = 'Mật khẩu phải có ít nhất 6 ký tự';
    } else {

        if($_POST['data']['password']==$_POST['data']['password_confirm']) {
            if($myProfile['password'] == md5($_POST['data']['password'])){
                $msg_error = 'Mật khẩu mới trùng với mật khẩu cũ!';
            }else{
                $value = "password='".md5($_POST['data']['password'])."'";
                if($cls_user->updateOne($myProfile['uid'], $value)) {
                    $msg_profile = 'Mật khẩu mới đã được cập nhật';
                }
            }
        } else {
            $msg_error = 'Mật khẩu xác nhận không trùng khớp';
        }
    }
}
if($_POST['action']=='update_email') {
    $myProfile = $cls_user->getMyProfile();

    if($_POST['data']['email_change']==$_POST['data']['email_change_confirm']) {
        $email_valid = isValid($_POST['data']['email_change'], 'email');
        if($email_valid==1) $msg_error = "Email này đã tồn tại, vui lòng chọn email khác!";
        elseif($email_valid==2){
            $value = "email='".$_POST['data']['email_change']."'";
            if($cls_user->updateOne($myProfile['uid'], $value)) {
                $msg_profile = 'Email mới đã được cập nhật';
            }
        }else $msg_error = "Email không đúng định dạng";
    } else {
        $msg_error = 'Email xác nhận không trùng khớp!';
    }

}
$smarty->assign('msg_profile',$msg_profile);
$smarty->assign('affiliate_earnings',$affiliate_earnings);
$allCountry = $cls_country->getAll('');
$smarty->assign('allCountry',$allCountry);
$myProfile = $cls_user->getMyProfile();
$smarty->assign('myProfile',$myProfile);

/* */

if($_POST['action']=='data_trans') {
    if($cls_user->trans_money($_POST['data_trans'])) {
        $f = 'user_id, money, reg_date';
        $v = "'".$_SESSION['uid']."'";
        $v .= ",'".$_POST['data_trans']."'";
        $v .= ",'".time()."'";

        if($cls_transection->insertOne($f, $v)) $msg = "Chuyển tiền thành công";
        else $msg = "Có lỗi xảy ra trong khi chuyển tiền.";

    } else $msg = "Có lỗi xảy ra trong khi chuyển tiền.";

    $smarty->assign('msg_profile', $msg);
}

$my_profile = $cls_user->getOne($_SESSION['uid']);
$smarty->assign('my_profile', $my_profile);

$pub_money_str = number_format($my_profile['pub_money']); $smarty->assign('pub_money_str', $pub_money_str);
$adv_money_str = number_format($my_profile['adv_money']); $smarty->assign('adv_money_str', $adv_money_str);

/* */

$affiliate_earnings=0; $affiliate_earnings = $cls_ref_user->getAffiliateEarning($_SESSION['uid']);
if($_SESSION['uid'] == '') header('location: '.$_config['www']);

$money = isset($_POST['data_trans'])?intval($_POST['data_trans']):0;
$name_card = isset($_POST['fullname'])?addslashes($_POST['fullname']):'';
$payment_method = isset($_POST['payment_method'])?addslashes($_POST['payment_method']):'';
$name_bank = isset($_POST['name_of_bank'])?addslashes($_POST['name_of_bank']):'';
$number_card = isset($_POST['number_account_bank'])?intval($_POST['number_account_bank']):0;
$mobile = isset($_POST['mobile'])?intval($_POST['mobile']):0;
$email_paypal = isset($_POST['paypal_email'])?addslashes($_POST['paypal_email']):'';
$color = 'red';
$code = unique_id(7);
// check error
if($_POST['action']=='data_withdraw'){
	if($money<=0) $error[''] = "Your money withdraw must be greater than 0.";
	if(!$payment_method) $error[''] = "Please choose your withdraw method.";

	if($_SESSION['uid']>0)
	$one = $cls_user->getOne($_SESSION['uid']);
    if($money > $one['pub_money']) $error[''] = "Your money withdraw must be smaller than your total money Publisher";

	if($payment_method=='2' && $_SESSION['uid']){
    	if(!$name_card) $error[''] = "Vui lòng nh?p h? tên tài kho?n nh?n ti?n.";
    	if(!$name_bank) $error[''] = "Vui lòng ?i?n thông tin ngân hàng mà b?n mu?n nh?n ti?n.";
    	if(!$number_card) $error[''] = "Vui lòng ?i?n thông tin s? tài kho?n c?a b?n.";

        if(count($error)==0 && $money>0 && $money <= $one['pub_money']){
        	$res = mysql_query('' . 'INSERT INTO `withdraw` ( `user_id` , `money` , `withdraw_date` , `method` , `name_card` ,`number_card`, `phone` , `email_paypal` , `email` , `name_bank` , `code`) VALUES (\'' . $_SESSION['uid'] . '\', \'' . $money . '\', curdate(), \'' . $payment_method . '\', \'' . $name_card . '\', \'' . $number_card . '\', \'' . $phone . '\', \'' . $email_paypal . '\', \'' . $email . '\', \'' . $name_bank . '\', \'' . $code . '\' )');
        }
        if($money>0 && $res){
            $cls_user->WithDraw($money);
            $color ='green';
            $error[''] = "Yêu c?u rút ti?n c?a b?n ?ã ???c g?i t?i ban qu?n tr?.";
        }
	}
    elseif($payment_method=='1' && $_SESSION['uid']){
    	if(!$email_paypal) $error[''] = "Please enter your PayPal email address.";
    	if(count($error)==0 && $money>0 && ($money < $one['pub_money'])){

    		$res = mysql_query('' . 'INSERT INTO `withdraw` ( `user_id` , `money` , `withdraw_date` , `method` , `name_card` ,`number_card`, `phone` , `email_paypal` , `email` , `name_bank` , `code`) VALUES (\'' . $_SESSION['uid'] . '\', \'' . $money . '\', curdate(), \'' . $payment_method . '\', \'' . $name_card . '\', \'' . $number_card . '\', \'' . $phone . '\', \'' . $email_paypal . '\', \'' . $email . '\', \'' . $name_bank . '\', \'' . $code . '\' )');

    		if($money>0 && $res)
    		$cls_user->WithDraw($money);
    		$color ='green';
    		$error[''] = "Update successful we will transfer money to you in 24 hours.";
    	}
    }
    $smarty->assign('error', $error);
    $smarty->assign('color', $color);
}
$smarty->assign('msg_error',$msg_error);
// Money history
/**/
$smarty->assign('page', isset($_GET['page']) && $_GET['page'] && in_array($_GET['page'], array('history', 'money_coupon','transfer'))  ? $_GET['page'] : '');
$content = $smarty->fetch('profile.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>