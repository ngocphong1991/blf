<?php
include ("include/config.php");
include_once("global.php");
if(!isset($_SESSION[uid])) { header("location: account.php?red_url=".urlencode(basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING'])); exit(); }

$msg = "";
require('classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('classes/class_publishersinfo.php'); $cls_publishersinfo = new Publishersinfo(); $smarty->assign('cls_publishersinfo', $cls_publishersinfo);
require('classes/class_category.php'); $cls_category = new Category(); $smarty->assign('cls_category', $cls_category);
$smarty->assign('cls_user', $cls_user);

$adv_id = isset($_GET[id])?$_GET[id]:0;
$smarty->assign('adv_id', $adv_id);

$allAdvertisersinfo = $cls_advertisersinfo->getOne($adv_id);
if($allAdvertisersinfo[price]>0) $totalPrice = $allAdvertisersinfo[price];

$yourMoney = $cls_user->getYourMoney();
$smarty->assign('yourMoney', my_money_format('%i',$yourMoney));
$smarty->assign('yourMoneyStr', my_money_format('%i', $yourMoney));

$act = isset($_GET[act])?$_GET[act]:'checkout';
$smarty->assign('act', $act);

//@ case for coupon code submit
if($_POST[promotion]!='Enter code here' && isset($_POST[promotion])){
	require('classes/class_coupon.php'); $class_coupon = new Coupon();
	$promotion = strip_tags(trim($_POST[promotion]));
	 $all = $class_coupon->getAll("code='".$promotion."' AND start_date<=CURDATE() AND end_date>=CURDATE() AND status=1");
     $one = $all[0];
	 if($one[percent]!='' && $one[percent]>0){ 
	 	 if($one[length]>1){
		 	$msg = '<span style="color:green">Submit successful! This coupon discount '.$one[percent].'%, your ad length is '.$one[length].' months text ads.</span>';	
			 $_SESSION[length] = $one[length];
			 $_SESSION[ref_code] = $one[ref_code];
		 }else
		 	$msg = '<span style="color:green">Submit successful! TextLink discount <b>$'.$totalPrice*($one[percent]/100).'</b> with this Coupon.</span>';		
			$_SESSION[couponPrice] = $one[percent]/100;	
			$_SESSION[ref_code] = $one[ref_code];	 
	 }else{
		 unset($_SESSION[couponPrice]);
		 unset($_SESSION[length]);
		 unset($_SESSION[ref_code]);
		 $msg = '<span style="color:red">Coupon code <b>'.$promotion.'</b> is not valid. Please choose another one.</span>';
	}
}

$user_arr = array(); $user_arr[discount] = 0;
$date_now = date("Y-m-d");
$end_date = $allAdvertisersinfo[end_date];
if($end_date<$date_now) $end_date = $date_now;
$end_date_renew = date('Y-m-d', strtotime('+30 day', strtotime($end_date)));
		
if($_SESSION['couponPrice']>0)
{
	if($_SESSION[length]>1){
		$user_arr[discount] = $totalPrice*($_SESSION['couponPrice'])*$_SESSION[length];
		$totalPrice = $_SESSION[length]*($totalPrice - $totalPrice*($_SESSION['couponPrice']));
		$day = $_SESSION[length]*30;		
		$end_date_renew = date('Y-m-d', strtotime('+'.$day.' day', strtotime($end_date)));
	}
	else{
		$user_arr[discount] = $totalPrice*($_SESSION['couponPrice']);
		$totalPrice = $totalPrice - $totalPrice*($_SESSION['couponPrice']);
	}
}

$smarty->assign('totalPrice', my_money_format('%i',$totalPrice));
$smarty->assign('totalPriceStr', my_money_format('%i',$totalPrice));

if($_GET['act']=='pay') {
    if($totalPrice<=$yourMoney && $adv_id>0 && $end_date_renew) {
		$day_length = ($_SESSION[length]>1)?($_SESSION[length]*30):30;
        if($cls_advertisersinfo->setRenew($adv_id, $day_length, $end_date_renew)) {			
            if($cls_user->minusMoney($_SESSION['uid'], $totalPrice)) {				 
				//send mail		
				include_once("include/libs/template.mail.php");				
				$type ="order";	
				$to_email = $user_info[email];
				$to_username = $user_info[username];	
				//#user info			
				$user_arr[order_id] = '#'.$_SESSION['uid'];
				$user_arr[total_price] = $totalPrice;			
				$user_arr[address] = $user_info[address];
				$user_arr[city] = $user_info[city];
				$user_arr[length] = $day_length;				
				$adv_arr = array(); $publisher_arr = array();
				if($allAdvertisersinfo){
					//update coupon info
					$coupon_length = ($_SESSION[length]>1)?$_SESSION[length]:1;
					if($coupon_length>=1 && $_SESSION['couponPrice']>0){
						$value = "coupon_price='".$_SESSION["couponPrice"]."'";				
						$value .= ",coupon_length='".$coupon_length."'";
						$value .= ",ref_code='".trim($_SESSION["ref_code"])."'";
						$cls_advertisersinfo->updateOne($allAdvertisersinfo[adv_id], $value);
					}
					//end update coupon info
					$pub_info = $cls_publishersinfo->getOne($allAdvertisersinfo[pid]);
					$adv_arr[] = array('pub_uid'=>$pub_info[uid], 'is_manual'=>$pub_info[is_manual],'pub_url'=>$pub_info[url], 'ad_before'=> $allAdvertisersinfo[ad_before], 'ad_after'=>$allAdvertisersinfo[ad_after], 'adv_id'=>$allAdvertisersinfo[adv_id], 'pub_url'=>$pub_info[url], 'price'=>$allAdvertisersinfo[price],'url'=>$allAdvertisersinfo[ad_url], 'ad_des'=>$ad_info[ad_des]);
				}
						
				$utype='adv';				
				//mailTemplates($to_email, $to_username, $type, $utype, $publisher_arr, $adv_arr, $user_arr);
	            //end send mail
				unset($_SESSION['couponPrice']);
				unset($_SESSION['length']);
                $_SESSION['totalPrice'] = $totalPrice;
                $_SESSION['yourMoney'] = $yourMoney;
                header("location: ?act=success&price=".$totalPrice);
            }
            else die('Error');
        } else die('Error!');
    }
    else header('Location: '.$_config[www].'/payment');
}

if($_GET['act']=='success') {
    $smarty->assign('totalPrice', my_money_format('%i', $_GET[price]));
    $_SESSION['totalPrice'] = 0;
	unset($user_arr);
}

if(isset($_GET['remove']) && $_GET['remove']!='') {
    $adv_id = $_GET['remove'];
    $cls_advertisersinfo->deleteOne($adv_id);
}

$smarty->assign('start_date', $end_date);
$smarty->assign('end_date', $end_date_renew);
$smarty->assign('allAdvertisersinfo', $allAdvertisersinfo);
//$smarty->assign('total_payable', (($tc-$bal)<0)?0:($tc-$bal));
$smarty->assign('msg', $msg);
$content = $smarty->fetch('renew.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>