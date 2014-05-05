<?php
include ("include/config.php");    
require_once('classes/class_user.php');
include_once("payments/NL.php");

$cls_user = new User();    

$uid  = isset($_SESSION[uid])?$_SESSION[uid]:0;
if($uid<=0) header('Location: '.$_config["www"].'/account.php');
$current_user = $cls_user->getOne($uid);

$transaction_info= isset($_GET["transaction_info"]) ? $_GET["transaction_info"] : '';
$order_code= isset($_GET["order_code"]) ? $_GET["order_code"] : '';
$price= isset($_GET["price"]) ? $_GET["price"] : 0;
$payment_id= isset($_GET["payment_id"]) ? $_GET["payment_id"] : '';
$payment_type= isset($_GET["payment_type"]) ? $_GET["payment_type"] : '';
$error_text= isset($_GET["error_text"]) ? $_GET["error_text"] : '';
$secure_code= isset($_GET["secure_code"]) ? $_GET["secure_code"] : '';
$currency = $_config['currency_char'];

$nl = new NL($_config['merchant_site_code'], $_config['secure_pass']);
$text = '';
$check= $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
if($check){
    mysql_query('insert into tracking_order set uid=\''.$uid.'\', amount = \''.$price.'\',transaction_info = \''.addslashes($transaction_info).'\', order_code=\''.$order_code.'\', payment_id=\''.$payment_id.'\', payment_type=\''.$payment_type.'\', error_text=\''.addslashes($error_text).'\', money_before = \''.$current_user['adv_money'].' \', money_after = \''.($current_user['adv_money']+$price).' \', date_order=\''. date('Y-m-d h:i:s', time('now')).'\' ');
    //Order now
    if($payment_type && $payment_type==1 && $error_text == ''){
        $user_info = $cls_user->plusMoney($uid, trim($amount));
        $text .= "<div class='alert alert-success'>Cám ơn quý khách, quá trình thanh toán đã được hoàn tất Bạn được cộng thêm $price $currency  vào tài khoản!</div>";
    }else $text .= "<div class='alert alert-info'>Cám ơn quý khách, quá trình thanh toán đã được hoàn tất. Bởi vì bạn lựa chọn hình thức thanh toán Tạm Giữ nên ngay khi tiền của bạn được chuyển vào tài khoản của chúng tôi thì tài khoản Buylink của bạn sẽ được cộng thêm $price $currency!</div>";
}
else
    $text .="<div class='alert alert-danger'>Quá trình thanh toán thất bại</div>";

$smarty->assign('text',$text);
$content = $smarty->fetch('success.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>