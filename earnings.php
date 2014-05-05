<?php
include ("include/config.php");
include_once("global.php");
$msg = "";

$do = $_REQUEST['do'];

if(isset($_GET['no_www'])){
    $msg = "You hav no website to advertise on. Please register a website first.";
}

if(isset($_POST['delete_pid'])){
	mysql_query("DELETE FROM publishersinfo WHERE pid='$_POST[del_pid]'");
	header("location: publishers.php");			
	exit();
}

if($_SESSION['utype'] != 'pub+adv'){
	header("location: account.php?smw&red_url=".urlencode(basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']));
	exit();
}

function getSiteEarnling(){

	if(isset($_GET['pid']) && $_SESSION[uid]>0){
		//echo "SELECT SUM(earnings) AS money FROM earnings WHERE uid='$_SESSION[uid]' AND pid='$_GET[pid]'";
		$my_site_earnings = mysql_query("SELECT SUM(earnings) AS money FROM earnings WHERE uid='$_SESSION[uid]' AND pid='$_GET[pid]'");

		if (mysql_num_rows($my_site_earnings)) {
			$my_site_money = mysql_result($my_site_earnings, 0, 'money');
			//echo    $my_site_money;
			return my_money_format('%i', $my_site_money);
    	} 
	
	}
}
	
if(isset($_GET['pid'])){
$res2 = mysql_query("SELECT * FROM publishersinfo WHERE uid='$_SESSION[uid]' AND pid='$_GET[pid]'");
while($info = @mysql_fetch_assoc($res2)){
	$_POST['pid'] = $info['pid'];
	$_POST['wname'] = $info['websitename'];
	$_POST['url'] = $info['url'];
	$_POST['wdes'] = $info['description'];
	$_POST['cats'] = $info['catid'];	
	$_POST['catIds'] = $info['catIds'];	
	$_POST['domain_age'] = $info['domain_age'];
	$_POST['subcats'] = $info['subcatid'];
	$_POST['keywords'] = $info['keywords'];
	$_POST['tad'] = $info['targetedad'];	
	$_POST['clickrate'] = $info['clickrate'];
	$_POST['isadult'] = $info['isadult'];
	$_POST['lang'] = $info['langid'];
	$_POST['adposition'] = $info['adposition'];
	$_POST['isrestricted'] = $info['isrestricted'];
	$_POST['restriction'] = $info['restriction'];
	$_POST['script'] = $info['script'];
	$g = mysql_query("select gid from pub_geo where pid=$info[pid]");
		for($i=0; $i< mysql_num_rows($g); $i++)
			$_POST[dest][$i] = mysql_result($g,$i,0);
	}
}

$_POST['catIds'] = explode(" , ", $_POST['catIds']);


if(isset($_POST[subcats]) && isset($_POST[cats])){
    $scat_list = get_sub_cat_list($_POST[cats]);
} else {
    $scat_list = get_sub_cat_list($cat_list['cid'][0]);
}

$my_website_earnings = getSiteEarnling();
$smarty->assign('my_website_earnings',$my_website_earnings);
$smarty->assign('earning_date',date("F Y"));
$smarty->assign('scat_ids',$scat_list['sid']);
$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);
$smarty->assign('right_panel','off');

$content = $smarty->fetch('website-earnings.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>