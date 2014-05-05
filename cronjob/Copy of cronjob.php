<?php
date_default_timezone_set('Asia/Bangkok');
require_once("../include/db_connection.php");
$money_earn_today = moneyEarns();

if($money_earn_today){
	//updateAlexaRank();
}

function moneyEarn($userID, $set_price){
	if($userID<=0 || $set_price<=0) return false;
	$money_obj= mysql_query('' . 'UPDATE users SET pub_money = pub_money + '.$set_price.',last_money_sent = CURDATE() WHERE last_money_sent <> CURDATE() AND uid=\'' . $userID . '\' LIMIT 1');	  
	if($money_obj) return true;
}

//@ function update earnings today
function website_earnings($pid, $userID, $money_earn, $adv_id){
	if($userID<=0 || $money_earn<=0 || $adv_id<=0) return false;
	$money = $money_earn/30;
	if(check_website_earning($pid, $userID, $money_earn, $adv_id)){
		//echo "insert into earnings set uid=$userID, pid=$pid, adv_id= $adv_id update_time=CURDATE(), earnings='$money',  time='".time()."' ";
		$insert_earnings = mysql_query("insert into earnings set uid=$userID, pid=$pid,adv_id= $adv_id, update_time=CURDATE(), earnings='$money',  time='".time()."' ");	
		unset($insert_earnings);
	}
}

function check_website_earning($pid, $userID, $money_earn, $adv_id){
	$check_obj = mysql_query("SELECT uid, pid, adv_id, update_time FROM earnings WHERE uid= '$userID' and update_time = CURDATE() and pid = '$pid' and adv_id= '$adv_id' LIMIT 1");
    if (mysql_num_rows($check_obj)) {
		return false;
    }	
	else return true;
}
	
function checkdate_insert($uid){
   $res_date = mysql_query('' . 'SELECT uid, pub_money, last_money_sent FROM users WHERE uid= ' . $uid . ' LIMIT 1');
    if (mysql_num_rows($res_date)) {
		$last_money_sent = mysql_result($res_date, 0, 'last_money_sent');
    	if($last_money_sent == date("Y-m-d"))
        return false;
		else return true;
    }	
	return false;
}
	
function moneyEarns(){	
	$slq ="select publishersinfo.pid, publishersinfo.uid, publishersinfo.sale_price, publishersinfo.is_manual, advertisersinfo.set_price, advertisersinfo.adv_id, advertisersinfo.is_auth, advertisersinfo.end_date from publishersinfo LEFT JOIN (advertisersinfo) ON (advertisersinfo.pid = publishersinfo.pid) where advertisersinfo.is_paid='Y' and advertisersinfo.start_date<=CURDATE() and advertisersinfo.end_date >=CURDATE() ";
	//where condition: publishersinfo.update_status > ".(time() - 24*3600)." and	
	$order_by = " order by update_status DESC";
	$money_earn_obj = mysql_query($slq.$order_by);

    while ($row = mysql_fetch_assoc($money_earn_obj)) {
		$check_date = checkdate_insert($row['uid']);
		//@ cronjob check and update money
		if($row['set_price']>0 && $row['is_auth']=='Y'){		
			website_earnings($row['pid'], $row['uid'], $row['set_price'], $row['adv_id']);			
			$money_info[$row['uid']][date("Y-m-d")][] = $row['set_price']/30;			
		}
	}
	
	$money_earn_onday = 0;
	foreach($money_info as $userid=>$money){
		$money_earn_onday = array_sum($money[date("Y-m-d")]);
		moneyEarn($userid, $money_earn_onday);
		//echo "<br>";
	}
	return true;
}


//update alexa rank
function updateAlexaRank(){	
	$slq ="select pid, update_rank, url from publishersinfo where update_status > ".(time() - 24*3600)." and status = 2 ";
	
	$order_by = " order by update_rank ASC limit 10";
	$money_earn_obj = mysql_query($slq.$order_by);
	$arr = array();
    while ($row = mysql_fetch_assoc($money_earn_obj)) {
		$page_rank = google_page_rank($row[url]);		
		$alexa_rank = alexarank($row[url]);
		$arr[] = array('pid'=>$row[pid], 'google_page_rank'=>$page_rank, 'alexa_rank'=>$alexa_rank);
		//$arr[alexa_rank] = $alexa_rank;		
		sleep(1);
	}
	if($arr && is_array($arr)){
		foreach($arr as $key=>$rank_arr){
			if(intval($rank_arr['google_page_rank'])>0 && intval($rank_arr['alexa_rank'])>0){
				mysql_query('' . 'update `publishersinfo` set  `google_page_rank`=\'' . intval($rank_arr['google_page_rank']) . '\' , `alexa_rank`=\'' . intval($rank_arr['alexa_rank']) . '\', `update_rank`=\'' . time() . '\' where pid=\'' . $rank_arr['pid'] . '\'');
			}elseif(intval($rank_arr['google_page_rank'])>0){
				mysql_query('' . 'update `publishersinfo` set  `google_page_rank`=\'' . intval($rank_arr['google_page_rank']) . '\' `update_rank`=\'' . time() . '\' where pid=\'' . $rank_arr['pid'] . '\'');
			}elseif(intval($rank_arr['alexa_rank'])>0){
				mysql_query('' . 'update `publishersinfo` set `alexa_rank`=\'' . intval($rank_arr['alexa_rank']) . '\', `update_rank`=\'' . time() . '\' where pid=\'' . $rank_arr['pid'] . '\'');
			}
			else continue;
		}	
	}
}
?>
