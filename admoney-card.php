<?php
include ("include/config.php");
include_once("global.php");
$msg = "";
if(!$_SESSION[uid] || $_SESSION[uid]<=0) exit();
$smarty->assign('cls_user', $cls_user);

require('classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('classes/class_country.php'); $cls_country = new Country();$smarty->assign('cls_country', $cls_country);
require('classes/class_ref_user.php'); $cls_ref_user = new RefUser(); 
require('classes/class_transection.php'); $cls_transection = new Transection(); $smarty->assign('cls_transection', $cls_transection);
require('classes/class_payments.php'); $cls_payments = new Payments();
require('classes/class_coupon_card.php'); $cls_coupon_card = new Coupon();

if($_SESSION['uid'] == '') header('location: '.$_config[www]);
$msn='';
if($_POST['charge']=='1'){
	if($_SESSION[uid]>0)
		$one = $cls_user->getOne($_SESSION[uid]);
		
		$ref_code  = isset($_POST[ref_code])?addslashes($_POST[ref_code]):'';
		if($ref_code){
			//echo '' . 'SELECT coupon_card_id, user_id FROM coupon_card WHERE ref_code=\'' . $ref_code . '\' LIMIT 1';
			
			$res = mysql_query('' . 'SELECT coupon_card_id,total, user_id FROM coupon_card WHERE ref_code=\'' . $ref_code . '\' LIMIT 1');
			
			if (mysql_num_rows($res)) {             
				$coupon_card_id      = mysql_result($res, 0, 'coupon_card_id');
				$total      = mysql_result($res, 0, 'total');
				$user_id      = mysql_result($res, 0, 'user_id');	
				//echo $total;
				if($coupon_card_id>0 && $total>0 && $user_id==0){
					$cls_coupon_card->updateOne($coupon_card_id, "user_id=".$_SESSION[uid]."");
					$cls_user->plusMoney($_SESSION[uid], $total);
					$smarty->assign('msn','<span tyle="color:green">Nạp tiền từ tài tài khoản thẻ TextLink thành công, cảm ơn bạn đã sử dụng dịch vụ của TextLink!.</span>');
				}else
				$smarty->assign('msn','<span style="color:red">Mã này đã được nạp bởi user khác hoặc không tồn tại, bạn vui lòng thử lại.</span>');
			}else 
				$smarty->assign('msn','<span style="color:red">Mã này đã được nạp bởi user khác hoặc không tồn tại, bạn vui lòng thử lại.</span>');
		}else
			$smarty->assign('msn','<span style="color:red">Vui lòng nhập mã thẻ TextLink.</span>');	  
}

$content = $smarty->fetch('admoney_card.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>