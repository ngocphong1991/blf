<?php
if(!isset($_GET[advertise])) exit();
include ("../include/config.php");


		$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$ip=gethostbyname($host_name);

if($_GET[network] == 'N') {
	$ad_row = mysql_fetch_assoc(mysql_query("select * from advertisersinfo where adv_id = '$_GET[advertise]'  limit 1"));
	mysql_query("insert into hits set is_click='1', adv_id = '$ad_row[adv_id]', pub_id = '$ad_row[pid]', ad_id='$ad_row[ad_id]', cmp_id = '0', date=curdate(), ip='$ip', ip_details='$host_name' ");

		if($ad_row[ad_type] == 'ppc_txt_ad' || $ad_row[ad_type] == 'ppc_img_ad' || $ad_row[ad_type] == 'ppc_vdo_ad') {
			$price = $ad_row[price];
			$balance = $ad_row[ppc_balance];
			$current_balance = $balance - $price;			
			if($current_balance < $price) $current_balance = 0;			
			mysql_query("update advertisersinfo set ppc_balance='$current_balance' where adv_id = '$ad_row[adv_id]' limit 1");
			}
	header ("location: $ad_row[ad_url]");
	exit();
	}
elseif($_GET[network] == 'Y') {
	$ad_row = mysql_fetch_assoc(mysql_query("select * from adv_campaign where cmp_id = '$_GET[advertise]' limit 1"));
	mysql_query("insert into hits set is_click='1', adv_id = '0', pub_id = '$_GET[pid]', ad_id='0', cmp_id = '$_GET[advertise]', date=curdate(), ip='$ip', ip_details='$host_name' ");

			$price = mysql_result(mysql_query("select clickrate from publishersinfo where pid='$_GET[pid]' "),0,0);
			$balance = $ad_row[remaining_budget];
			$current_balance = $balance - $price;
			if($current_balance < $price) $current_balance = 0;
			$last_click = $ad_row[last_click_date]; 
			$today = date("Y").'-'.date("m").'-'.date("d");
			
			if ($today == $last_click) {
				$exp_today = $ad_row[expense_today] + $price;
			}
			else 
				$exp_today = $price;
				
			mysql_query("update adv_campaign set expense_today = '$exp_today', last_click_date=curdate(), remaining_budget='$current_balance' where cmp_id = '$ad_row[cmp_id]' limit 1");
			

//						$price = mysql_fetch_assoc(mysql_query("select pid, price, ppc_balance from advertisersinfo where pub_uid='$_SESSION[uid]' and adv_id = '$_GET[adv_id]' and is_paid = 'Y' and is_auth='Y' and approved='Y'"),0,0);						
						$pid = $_GET[pid];
						$cost = $price;
						//// % calculation ... !!!
						$percent = mysql_result(mysql_query("select pay_rate from publishersinfo where pid = '$pid'"),0,0);
						$uid = mysql_result(mysql_query("select uid from publishersinfo where pid = '$pid'"),0,0);
						if($percent == 0) $percent = $_config[default_pay_rate];
						$pub_earning = $cost * $percent / 100;
						$admin_earning = $cost - $pub_earning;
						
						mysql_query("update users set balance = ( balance + $pub_earning ) where uid='$uid' ");
						mysql_query("insert into admin_earnings set date=curdate(), earning='$admin_earning'");

	header ("location: $ad_row[ad_url]");
exit();
}

exit();
?>