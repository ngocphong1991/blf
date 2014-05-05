<?php
date_default_timezone_set('Asia/Bangkok');
require_once("../include/db_connection.php");
$money_earn_today = totalEarning();
if(count($money_earn_today)>0)
foreach($money_earn_today as $userID=>$set_price){
	moneyEarn($userID, $set_price);
}

function totalEarning(){	
		$slq ="select publishersinfo.pid, publishersinfo.uid, publishersinfo.set_price, publishersinfo.is_manual, advertisersinfo.adv_id, advertisersinfo.start_date,advertisersinfo.ad_des, advertisersinfo.ad_url, advertisersinfo.pub_uid, advertisersinfo.money_sent_to_pub, advertisersinfo.end_date, advertisersinfo.adv_id, advertisersinfo.is_auth, advertisersinfo.end_date from publishersinfo LEFT JOIN (advertisersinfo) ON (advertisersinfo.pid = publishersinfo.pid) where  advertisersinfo.is_paid='Y' and  (advertisersinfo.money_sent_to_pub <= SUBDATE(CURDATE(), 30) and advertisersinfo.start_date <= SUBDATE(CURDATE(), 30)) and advertisersinfo.end_date >=CURDATE() ";
		$order_by = " order by update_status DESC";
		$money_earn_obj = mysql_query($slq.$order_by);
		$total=0;
		while ($row = mysql_fetch_assoc($money_earn_obj)) {
			if($row["pid"]>0){
				//if($row[money_sent_to_pub]> $row[start_date]);
				if(checkPayLogs($row["pid"], $row["pub_uid"], $row["adv_id"]))
				$update = updatePlayLogs($row["pid"], $row["pub_uid"], $row["adv_id"], $row["set_price"],  $row["start_date"], $row["end_date"]);
				if($update) 
				updateAdvertiser($row["pub_uid"], $row["pid"], $row["adv_id"]);
				//$arr_pub[$row["pub_uid"]] = $row;			
				$arr_pub[$row["pub_uid"]] +=  $row["set_price"];
			}else continue;
		}		
		//$smarty->assign('arr_pub',$arr_pub);		
		return $arr_pub;	
}

function updatePlayLogs($pid, $pub_uid, $adv_id, $money, $start, $end){	
		$insert_earnings = mysql_query("insert into pay_logs set user_id=$pub_uid, pid=$pid,adv_id=$adv_id, update_time=CURDATE(), money='$money', start_date='$start', end_date='$end', month='".date('n')."', year='".date('Y')."' ");		
		if($insert_earnings)
		return true;
		
}

function checkPayLogs($pid, $userID, $adv_id){
	if($pid<=0 || $userID<=0 || $adv_id<=0) return false;
	$check_obj = mysql_query("SELECT user_id, pid, month FROM pay_logs WHERE user_id= '$userID' and month = '".date('n')."' and pid = '$pid' and adv_id= '$adv_id' LIMIT 1");
    if (mysql_num_rows($check_obj)) {
		return false;
    }	
	else return true;
}

function updateAdvertiser($pub_uid, $pid, $adv_id){
	if($pub_uid<=0|| $pid<=0| $adv_id<=0) return false;
	//echo '' . 'UPDATE advertisersinfo SET money_sent_to_pub = "'.date('Y-m-d').'" where pub_uid=\'' . $pub_uid . '\' and pid=\'' . $pid . '\' and adv_id=\'' . $adv_id . '\' LIMIT 1';
	$money_obj= mysql_query('' . 'UPDATE advertisersinfo SET money_sent_to_pub = "'.date('Y-m-d').'" where pub_uid=\'' . $pub_uid . '\' and pid=\'' . $pid . '\' and adv_id=\'' . $adv_id . '\' LIMIT 1');	  
	if($money_obj) return true;
}

function moneyEarn($userID, $set_price){
	if($userID<=0 || $set_price<=0) return false;
	$money_obj= mysql_query('' . 'UPDATE users SET pub_money = pub_money + '.$set_price.',last_money_sent = CURDATE() WHERE last_money_sent <> CURDATE() AND uid=\'' . $userID . '\' LIMIT 1');	  
	if($money_obj) return true;
}


?>
