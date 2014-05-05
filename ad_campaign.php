<?php
include ("include/config.php");

if(!isset($_SESSION[uid]))
	header("location: account.php?red_url=".urlencode(basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']));
	
	$smarty->assign('cats', get_list('category', 'category'));
	$smarty->assign('geo', get_list('pub_geolist', 'location'));
	$smarty->assign('img_ad_sizes', get_list('image_size', 'width'));
	$smarty->assign('vdo_ad_sizes', get_list('video_size', 'width'));
	
	
	if(isset($_POST[submit_cmp])) {
		
		if(isset($_GET[campaign]))
			$query = "update adv_campaign set title='$_POST[title]', ad_type='$_POST[ad_type]', is_adult='$_POST[is_adult]'  ";
		else
		$query = "insert into adv_campaign set uid='$_SESSION[uid]', title='$_POST[title]', ad_type='$_POST[ad_type]', is_adult='$_POST[is_adult]', start_date=curdate() ";
		if($_POST[geo_target] == 'all')
			$query .= ", geo_target=NULL ";
		else {
			$tmp = '#'.implode('#', $_POST[geo]).'#';
			$query .= ", geo_target='$tmp' ";
		}
		
		if($_POST[cat_target] == 'all')
			$query .= ", cat_target=NULL ";
		else {
			$tmp = '#'.implode('#', $_POST[cats]).'#';
			$query .= ", cat_target='$tmp' ";
		}
			
		if($_POST[key_target] == '')
			$query .= ", key_target=NULL ";
		else {
			$parts = explode(',', $_POST[key_target]);
			foreach($parts as $key => $val) {
				$parts[$key] = trim($val);
				if($parts[$key]=='') unset($parts[$key]);
				}
			$tmp = '#'.implode('#', $parts).'#';
			$query .= ", key_target='$tmp' ";
		}
		
		if($_POST[ad_type] == 'img')
			$query .= ", size='$_POST[img_size]' ";
		else {
			$query .= ", size='$_POST[vdo_size]' ";
		}
		
		if(isset($_GET[campaign]))
			$query .= " where uid='$_SESSION[uid]' and cmp_id = '$_GET[campaign]'";
			
		mysql_query($query);
		if(isset($_GET[campaign]))
			$smarty->assign('cmp_id', $_GET[campaign]);
		else
		$smarty->assign('cmp_id', mysql_insert_id());
		$smarty->assign('type', $_POST[ad_type].'_ad');
	}
	
	if(isset($_POST[spend])) {
		mysql_query("update adv_campaign set total_budget='$_POST[total_budget]', remaining_budget='$_POST[total_budget]', max_cpc='$_POST[max_cpc]', daily_budget='$_POST[daily_budget]' where cmp_id='$_POST[cmp_id]' and uid='$_SESSION[uid]'");
		header ("location: buy_ads.php?cmp_id=$_POST[cmp_id]&t=$_POST[type]");
	}
	
	if(isset($_GET[campaign])) {
		$cr = mysql_fetch_assoc(mysql_query("select * from adv_campaign where cmp_id='$_GET[campaign]' and uid='$_SESSION[uid]' limit 1"));
		$smarty->assign('cdata', $cr);
		$geos = explode("#",trim($cr[geo_target],"#"));
		$smarty->assign('geo_sel', $geos);
		
		$cats = explode("#",trim($cr[cat_target],"#"));
		$smarty->assign('cat_sel', $cats);
	}
$smarty->assign('right_panel', 'off');
$content = $smarty->fetch('ad_campaign.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');	
?>