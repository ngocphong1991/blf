<?php
include ("../include/config.php");
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo();
require('../classes/class_publishersinfo.php'); $class_publishersinfo = new Publishersinfo();
include_once("../global.php");
if($_SESSION[uid]<=0){
	$arr = array("result"=>"failure","output"=> "");
	echo json_encode($arr);
}


if($_POST[action]=="cancel_link"){
	include_once("../include/libs/template.mail.php");
	$type ="cancel";
	if($_SESSION['email'])
	mailTemplates($_SESSION['email'], $_SESSION[username], $type, 'pub');
		
	$url = isset($_POST[url])?$_POST[url]:'';
	$adv_id = isset($_POST[id])?intval($_POST[id]):0;
	if($adv_id>0){
		$totalPrice = cancelAdvertiser($adv_id, $url);
		if($totalPrice){
			 if($cls_user->plusMoney($_SESSION['uid'], $totalPrice)) {
				$arr = array("result"=>"success","output"=> "Cancel link successful.");
			}
		}
		else
		$arr = array("result"=>"failure","output"=> "");
		echo json_encode($arr);
	}
}elseif($_POST[action]=="renew_link"){		
	$url = isset($_POST[url])?$_POST[url]:'';
	$adv_id = isset($_POST[id])?intval($_POST[id]):0;
	
	if($adv_id>0 && $_SESSION['uid']>0){
		$totalPrice = $cls_advertisersinfo->getSalePrice($adv_id);
		if($user_info[adv_money]>=$totalPrice){
			 RenewlAdvertiser($adv_id, $url,30);	
			 if($cls_user->minusMoney($_SESSION['uid'], $totalPrice)) {
				$arr = array("result"=>"success","output"=> "Cancel link successful.");
			 }
		}
		else
		$arr = array("result"=>"failure","output"=> "Please add more advertiser money.");
		echo json_encode($arr);
	}
}elseif($_POST[action]=="active_manual"){
	$adv_id = isset($_POST[id])?intval($_POST[id]):0;
	$pid = isset($_POST[pid])?intval($_POST[pid]):0;
	if($adv_id && $pid){
		//$advertiser_info = $cls_advertisersinfo->getOne($adv_id);
		//$publisher_info = $class_publishersinfo->getOne($pid);
		$cls_advertisersinfo->updateOne($adv_id, "approved='Y'");
		$arr = array("result"=>"success","output"=> "Approved advertiser link successful.");
		echo json_encode($arr);
	}
	//print_r($advertiser_info);	
}elseif($_POST[action]=="advertiser_cancel"){
	$url = isset($_POST[url])?$_POST[url]:'';
	$adv_id = isset($_POST[id])?intval($_POST[id]):0;
	if($adv_id>0 && $_SESSION['uid']>0){
		$totalPrice = cancelAdvertiser($adv_id, $url);
		if($totalPrice){
			 if($cls_user->plusMoney($_SESSION['uid'], $totalPrice)) {
				$arr = array("result"=>"success","output"=> "Cancel advertiser link successful.");
			}
		}
		else
		$arr = array("result"=>"failure","output"=> "");
		echo json_encode($arr);
	}	
}elseif($_POST[action]=="get_domainage"){
	$url = $_POST[url];
	$pid = $_POST[pid];
	if(isset($url) && $pid>0){
		$domain_age = getDomainAge($url);
		updateDomainAge($domain_age,$pid);
		$arr = array("result"=>"success","output"=> "This website has been updated.");
	}
	echo json_encode($arr);
}

?>
