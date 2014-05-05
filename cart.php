<?php
include ("include/config.php");
include_once("global.php");
if(!isset($_SESSION[uid])){	
	header("location: ".$_config[www]."/account.php");			
	exit();
}

$msg = "";    
############
require('classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('classes/class_publishersinfo.php'); $cls_publishersinfo = new Publishersinfo(); $smarty->assign('cls_publishersinfo', $cls_publishersinfo);
require('classes/class_category.php'); $cls_category = new Category(); $smarty->assign('cls_category', $cls_category);
$smarty->assign('cls_user', $cls_user);

$totalPrice = $cls_publishersinfo->getTotalPrice();
$yourMoney = $cls_user->getYourMoney();

$smarty->assign('yourMoney', my_money_format('%i',$yourMoney));
$smarty->assign('yourMoneyStr', my_money_format('%i', $yourMoney));
$smarty->assign('act', $_GET['act']);

//@ case for coupon code submit

if($_POST['promotion']!='Enter code here' && isset($_POST['promotion'])){
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

if($_POST[update_card]=="Update"){
	if(intval($_POST[length])<=30) $_POST[length] = 30;
	$length = isset($_POST[length])?intval($_POST[length]):30;
	$_SESSION[length] = $length/30;
	$start_date = isset($_POST[start_date])?addslashes($_POST[start_date]):date("Y-m-d");
	$_SESSION[start_date] = $start_date;
	$end_date = date('Y-m-d', strtotime('+'.$length.' day', strtotime($start_date)));
}

$user_arr = array(); $user_arr[discount] = 0;	
if(!isset($_SESSION[start_date])){
	$start_date = date("Y-m-d");
	$end_date = date('Y-m-d', strtotime('+30 day', strtotime($start_date)));
}else{
	$start_date = $_SESSION[start_date];
	if($_SESSION[length]>=1){
		$end_date = date('Y-m-d', strtotime('+'.($_SESSION[length]*30).' day', strtotime($start_date)));
		$totalPrice = $_SESSION[length]*($totalPrice);
	}else{
		$end_date = date('Y-m-d', strtotime('+30 day', strtotime($start_date)));
	}
}

$list_text_ad = get_list('textad', 'length');
$smarty->assign('length',$list_text_ad['length']);

if($_SESSION['couponPrice']>0)
{
	if($_SESSION[length]>1){
		$user_arr[discount] = $totalPrice*($_SESSION['couponPrice'])*$_SESSION[length];
		$totalPrice = $_SESSION[length]*($totalPrice - $totalPrice*($_SESSION['couponPrice']));
		$day = $_SESSION[length]*30;		
		$end_date = date('Y-m-d', strtotime('+'.$day.' day', strtotime($start_date)));
	}
	else{
		$user_arr[discount] = $totalPrice*($_SESSION['couponPrice']);
		$totalPrice = $totalPrice - $totalPrice*($_SESSION['couponPrice']);
	}
}

$smarty->assign('totalPrice', my_money_format('%i',$totalPrice));
$smarty->assign('totalPriceStr', my_money_format('%i',$totalPrice));
$allAdvertisersinfo = $cls_advertisersinfo->getAll("is_paid='N' AND uid=$_SESSION[uid] ");

if($_POST['info']) {
    foreach ($_POST['info'] as $key => $val) {
        if(is_array($val) && validateURL($val['ad_url'])){
            $value = "ad_before='".$val['ad_before']."'";
            $value .= ",ad_des='".$val['ad_des']."'";
            $value .= ",ad_after='".$val['ad_after']."'";
            $value .= ",ad_url='".$val['ad_url']."'";
            $cls_advertisersinfo->updateOne($key, $value);
            header("location: ?act=checkout");
        }
    }
}
if($_GET['act']=='pay') {
    if($totalPrice<=$yourMoney) {		
		$day_length = ($_SESSION[length]>1)?($_SESSION[length]*30):30;
        if($cls_advertisersinfo->setPaid($day_length, $_SESSION[start_date])) {			
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
				foreach($allAdvertisersinfo as $key=>$ad_info){
					//update coupon info
					$coupon_length = ($_SESSION[length]>1)?$_SESSION[length]:1;
					if($coupon_length>=1 && $_SESSION['couponPrice']>0){
						$value = "coupon_price='".$_SESSION["couponPrice"]."'";				
						$value .= ",coupon_length='".$coupon_length."'";
						$value .= ",ref_code='".trim($_SESSION["ref_code"])."'";
						$cls_advertisersinfo->updateOne($ad_info[adv_id], $value);
					}
					//end update coupon info
					$pub_info = $cls_publishersinfo->getOne($ad_info[pid]);
					$adv_arr[] = array('pub_uid'=>$pub_info[uid], 'is_manual'=>$pub_info[is_manual],'pub_url'=>$pub_info[url], 'ad_before'=> $ad_info[ad_before], 'ad_after'=>$ad_info[ad_after], 'adv_id'=>$ad_info[adv_id], 'pub_url'=>$pub_info[url], 'price'=>$ad_info[price],'url'=>$ad_info[ad_url], 'ad_des'=>$ad_info[ad_des], 'end_date'=>$ad_info[end_date]);
				}
						
				$utype='adv';				
				mailTemplates($to_email, $to_username, $type, $utype, $publisher_arr, $adv_arr, $user_arr);
	            //end send mail
				unset($_SESSION['couponPrice']);
				unset($_SESSION['length']);
				unset($_SESSION['start_date']);
                $_SESSION['totalPrice'] = $totalPrice;
                $_SESSION['yourMoney'] = $yourMoney;
                header("location: ?act=paysuccess&price=".$totalPrice);
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

$smarty->assign('start_date', $start_date);
$smarty->assign('end_date', $end_date);
$smarty->assign('allAdvertisersinfo', $allAdvertisersinfo);
$smarty->assign('total_cost', $tc);
$smarty->assign('balance', $bal);
//$smarty->assign('total_payable', (($tc-$bal)<0)?0:($tc-$bal));
$smarty->assign('total', count($f_cart)+count($cmp_cart)+count($ad_cart));
$smarty->assign('ad_cart', $ad_cart);
$smarty->assign('cmp_cart', $cmp_cart);
$smarty->assign('f_cart', $f_cart);
$smarty->assign('msg', $msg);
$smarty->assign('right_panel', 'off');
$content = $smarty->fetch('cart.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>