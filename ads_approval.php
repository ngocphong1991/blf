<?php
include ("include/config.php");
if(!isset($_SESSION[uid]))
	header("location: account.php");
	
	$advid = mysql_fetch_assoc(mysql_query("select * from advertisersinfo where adv_id = '$_GET[adv_id]'"));
	$post = mysql_fetch_assoc(mysql_query("select * from users where uid = '$advid[uid]' "));
	$pubname = mysql_result(mysql_query("select websitename from publishersinfo where pid = '$advid[pid]'"),0,0);
	if($advid[length] == 0) {
		$adlen = 'N/A (PPC)';
		$adcost = $advid[ppc_balance];
	}
	else {
		$adlen = $advid[length].' Day';
		$adcost = $advid[price];
	}
	
	if(isset($_POST[reject])) {
		if(mysql_query("update advertisersinfo set approved='R' where adv_id='$_GET[adv_id]' and pub_uid='$_SESSION[uid]' and approved='N' and is_paid='Y' and is_auth='Y' ")) {
		$price = mysql_fetch_assoc(mysql_query("select uid, price, ppc_balance from advertisersinfo where pub_uid='$_SESSION[uid]' and adv_id = '$_GET[adv_id]' and is_paid = 'Y' and is_auth='Y'  and approved='R'"));
						$adv_uid = $price[uid];
						if($price[ppc_balance] == 0)
							$cost = $price[price];
						else $cost = $price[ppc_balance];
						mysql_query("update users set balance = ( balance + $cost ) where uid='$adv_uid' ");
					}				
				
				$to  = $post[email];				
				// subject
				$subject = 'Ad Rejected';
				
				// message
$message = "
				<html>
				<head>
				 <title>Ad Rejected</title>
				</head>
				<body>
				Your ad for the following website has been rejected,<br />
<br />

Website: $pubname<br />

Ad Length: $adlen<br />

Ad Cost: $_config[currency] $cost<br />


The website owner may have left a reason why they have rejected your ad. <br />


You can read this reason by logging into your account and clicking on the 'Current Ads Running' and viewing your rejected ads there. <br />

<br />
<br />
<br />



Your account has now been credited with the amount, $_config[currency] $cost <br />
<br />


You can now purchase any other ads upto the value you have just been credited with.<br />
<br />



You can manage all the ads you buy, by logging into your account at, <a href=$_config[www]>$_config[www]</a>

<br />
<br />


Regards<br />
<br />


$_config[website_name]<br />

$_config[www]<br />

				</body>
				</html>
				";

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= "To: $post[username]<$post[email]>" . "\r\n";
				$headers .= "From: $_config[website_name]<$_config[admin_email]>" . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);
				

	
	
	}
	
	if(isset($_POST[reject_edit])) {
		mysql_query("update advertisersinfo_edit set approved='R' where adv_id='$_GET[adv_id]' ");
	}

	
	if(isset($_POST[reason])) {
		if (mysql_query("update advertisersinfo set refuse_reason='$_POST[why]' where adv_id='$_GET[adv_id]' and pub_uid='$_SESSION[uid]' "))
			header ("location: account.php?new_ads");			
	}
	
	if(isset($_POST[approve])) {
		if(mysql_query("update advertisersinfo set approved='Y' where adv_id='$_GET[adv_id]' and pub_uid='$_SESSION[uid]' and approved='N' and is_paid='Y' and is_auth='Y' ")) {
			$price = mysql_fetch_assoc(mysql_query("select pid, price, ppc_balance from advertisersinfo where pub_uid='$_SESSION[uid]' and adv_id = '$_GET[adv_id]' and is_paid = 'Y' and is_auth='Y' and approved='Y'"));
						$pid = $price[pid];
						if($price[ppc_balance] == 0)
							$cost = $price[price];
						else $cost = $price[ppc_balance];
						//// % calculation ... !!!
						$percent = mysql_result(mysql_query("select pay_rate from publishersinfo where pid = '$pid'"),0,0);
						if($percent == 0) $percent = $_config[default_pay_rate];
						$pub_earning = round((($cost * $percent) / 100),2);
						$admin_earning = $cost - $pub_earning;
						
						mysql_query("update users set balance = ( balance + $pub_earning ) where uid='$_SESSION[uid]' ");
						mysql_query("insert into admin_earnings set date = curdate() , earning = '$admin_earning' ");
		}	
		
		
						$to  = $post[email];				
				// subject
				$subject = 'Ad Accepted';
				
				// message
$message = "
				<html>
				<head>
				 <title>Ad Accepted</title>
				</head>
				<body>
				Your ad for the following website has been accepted,<br />
<br />

Website: $pubname<br />

Ad Length: $adlen<br />

Ad Cost: $adcost<br />


Your ad is now live, and will run for the length of time you paid for.

<br />
<br />
<br />


You can manage all the ads you buy, by logging into your account at, <a href=$_config[www]>$_config[www]</a>

<br />
<br />


Regards<br />
<br />


$_config[website_name]<br />

$_config[www]<br />

				</body>
				</html>
				";
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= "To: $post[username]<$post[email]>" . "\r\n";
				$headers .= "From: $_config[website_name]<$_config[admin_email]>" . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);
				

		
		
					
	}

	if(isset($_POST[approve_edit])) {
		mysql_query("update advertisersinfo_edit set approved='Y' where adv_id='$_GET[adv_id]' ");
		$e = mysql_fetch_assoc(mysql_query("select * from advertisersinfo_edit where adv_id='$_GET[adv_id]' "));
		mysql_query("update advertisersinfo set site_name='$e[site_name]',ad_hl='$e[ad_hl]', ad_des='$e[ad_des]', ad_url='$e[ad_url]', ad_img='$e[ad_img]', approved='Y' where adv_id='$_GET[adv_id]' and pub_uid='$_SESSION[uid]' ");
	}
	
	
	$res = mysql_fetch_assoc(mysql_query("select * from advertisersinfo where adv_id = '$_GET[adv_id]' and pub_uid='$_SESSION[uid]' and is_paid='Y' and is_auth='Y' "));
		$smarty->assign('ad', $res);
	
	$as = mysql_fetch_assoc(mysql_query("select * from publishers_adspaces where ad_id='$res[ad_id]'"));
		$smarty->assign('ad_space', $as);
		
	if($as['length'] == 0) {
		$smarty->assign('price', $res['ppc_balance']);
		if($res['ad_type'] == 'ppc_txt_ad')
		$smarty->assign('product', ' Pay per Click Text Ad ');
		if($res['ad_type'] == 'ppc_img_ad')
		$smarty->assign('product', ' Pay per Click Image Ad ');
		if($res['ad_type'] == 'ppc_vdo_ad')
		$smarty->assign('product', ' Pay per Click Video Ad ');
	}
	else {
	
		if($as[cost] != $res[price])
			$smarty->assign('offer', 'Y');

		$smarty->assign('price', $res['price']);
		
		if($res['ad_type'] == 'txt_ad')
		$smarty->assign('product', $as[length].' Day Text Ad ');
		if($res['ad_type'] == 'img_ad')
		$smarty->assign('product', $as[length].' Day Image Ad ');
		if($res['ad_type'] == 'vdo_ad')
		$smarty->assign('product', $as[length].' Day Video Ad ');
	}
	
				
	$user = mysql_result(mysql_query("select username from users where uid='$res[uid]' "),0,0);
			$smarty->assign('user', $user);
				
	
			
	if(isset($_REQUEST[edit])) {
		unset($res);  ////////////////////////////////
		$res = mysql_fetch_assoc(mysql_query("select * from advertisersinfo_edit where adv_id = '$_GET[adv_id]' "));
		$smarty->assign('new_hl', $res[ad_hl]);
		$smarty->assign('new_des', $res[ad_des]);
		$smarty->assign('new_url', $res[ad_url]);
	}
			
	if (file_exists($res['ad_img'])) {
				$smarty->assign('has_file', 'Y');

					$tmp = explode('.', $res['ad_img']);
					$ext = $tmp[count($tmp)-1];
						$smarty->assign('ext', $ext);
				}
			else $smarty->assign('has_file', 'N');


	$sz = explode('x', $as['size']);
				$smarty->assign('div_size', $sz);
				
				
$smarty->assign('right_panel', 'off');

$smarty->assign('swf_object', 'Y');

$content = $smarty->fetch('ads_approval.tpl');
$smarty->assign('content', $content);
$smarty->display('master_page.tpl');

?>