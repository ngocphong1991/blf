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

if(!isset($_SESSION[uid])){	
	header("location: ".$_config[www]."/account.php");			
	exit();
}

//@ get lastest order
function getLastestOrder(){
	if(!$_SESSION[uid]) return false;
	$lastest_order = mysql_query("SELECT * FROM advertisersinfo WHERE uid = '$_SESSION[uid]' and is_paid ='Y' ORDER BY pid DESC LIMIT 1");	
	while($r = @mysql_fetch_assoc($lastest_order)) {		
		$lastest_order_arr[] = array('pid'=>$r['pid'], 'ad_des'=>$r['ad_des'], 'ad_url'=>$r['ad_url'], 'price'=>my_money_format('%i', $r['price']));		
	}
	
	return $lastest_order_arr;
}

$lastest_order = getLastestOrder();

if($lastest_order) $smarty->assign('lastest_order',$lastest_order);

$res = mysql_query("SELECT * FROM publishersinfo WHERE uid = '$_SESSION[uid]' ORDER BY pid DESC");
$idx=0;
while($r = @mysql_fetch_assoc($res)) {	
	$val = ($idx%2==0)?'1':'2';
	$rr[] = array('pid'=>$r['pid'], 'url'=>$r['url'], 'title'=>$r['websitename'], 'description'=>$r['description'],'catId'=>$r['catid'], 'is_homepage'=>$r['is_homepage'],'date'=>$r['member_since'], 'price'=>my_money_format('%i', $r['set_price']),'google_page_rank'=>$r['google_page_rank'],'alexa_rank'=>$r['alexa_rank'],'domain_age'=>timeAgo($r['domain_age']),'status'=>$r['status'], 'key'=>$val);
	$idx++;
}

$smarty->assign('info_edit',$info_edit);
$smarty->assign('www',$rr);

$_POST['catIds'] = explode(" , ", $_POST['catIds']);

$cat_list = get_list('category','category');
$smarty->assign('cats',$cat_list['category']);
$smarty->assign('cat_ids',$cat_list['cid']);
$smarty->assign('scats',$scat_list['subcategory']);
$smarty->assign('scat_ids',$scat_list['sid']);
$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);
$smarty->assign('right_panel','off');
$content = $smarty->fetch('dashboard.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>