<?php
include "include/config.php";
$tmp = $_SERVER['PHP_SELF'];
$tmp = explode('/', $tmp);
$page = $tmp[count($tmp) - 1];
  
	$smarty->assign('show_alexa_gpr','Y');
	
	$f = mysql_query("SELECT * FROM featured where status='Y' and is_paid='Y' and is_auth='Y' and start <= curdate() and end>=curdate() order by rand() limit $_config[max_featured]");
	
	while ($r = mysql_fetch_assoc($f)) {
		$mc = mysql_result(mysql_query("select min(cost) from publishers_adspaces where pid='$r[pid]'"),0,0);
		$w = mysql_fetch_assoc(mysql_query("select * from publishers_adspaces where cost = '$mc' and pid='$r[pid]' limit 1"));
		$len = $w[length];
		if($len == 0) {
			if($w[ad_type] == 'ppc_txt_ad')
				$ad = '<b> Price '.$_config[currency].$w[cost].' Pay per click text link</b>';
			elseif($w[ad_type] == 'ppc_img_ad')
				$ad = '<b> Price '.$_config[currency].$w[cost].' Pay per click image link</b>';
			elseif($w[ad_type] == 'ppc_vdo_ad')
				$ad = '<b> Price '.$_config[currency].$w[cost].' Pay per click video link</b>';	
		}
		else {
			if($w[ad_type] == 'txt_ad')
				$ad = '<b> Price '.$_config[currency].$w[cost]." $len day text link</b>";
			elseif($w[ad_type] == 'img_ad')
				$ad = '<b> Price '.$_config[currency].$w[cost]." $len day image link</b>";
			elseif($w[ad_type] == 'vdo_ad')
				$ad = '<b> Price '.$_config[currency].$w[cost]." $len day video link</b>";
		}
		
		$des = '<a href="website_page.php?pid='.$r[pid].'">'.$r[wname].'</a> - '. $r[des] . $ad;
		$c[] = array('fid' => $r['fid'], 'des' => stripslashes($des) , 'pid' => $r['pid'], 'ad' => $ad, 'wname' => $r[wname]);
	}

	$smarty->assign('featured', $c);
	
	if(isset($_POST[subscribe])) {
		if (mysql_num_rows(mysql_query("select email from users where email='$_POST[email]'"))) 
			mysql_query("update users set getnewsletter='$_POST[getnewsletter]' where email='$_POST[email]'");
		else mysql_query("insert into users set username='$_POST[email]', email='$_POST[email]', getnewsletter='$_POST[getnewsletter]'");
		
		$nmsg = 'Request Accepted';
	}
$smarty->assign('nmsg',$nmsg);	
$content = $smarty->fetch('index.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>
