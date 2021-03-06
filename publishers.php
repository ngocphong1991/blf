<?php
include ("include/config.php");
include_once("global.php");
$msg = "";
$do = $_REQUEST['do'];

if(!isset($_SESSION[uid])){
	require('classes/class_news.php'); $class_news = new News(); $smarty->assign('class_news', $class_news);
	$allnews = $class_news->getAll('1=1 order by order_no limit 0,4');
	$smarty->assign('allnews',$allnews);
}
if(isset($_GET['no_www'])){
    $msg = "You hav no website to advertise on. Please register a website first.";
}

if(isset($_POST['delete_pid'])){
	mysql_query("DELETE FROM publishersinfo WHERE pid='$_POST[del_pid]'");
	header("location: publishers.php");			
	exit();
}


if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit_site'])) {
	if($_GET[step]==1) $function_publisher = "register_new_publisher_step";
	else $function_publisher = "register_new_publisher";
	
	if($pid = $function_publisher($_POST)) {
        if($_config['approve_new_site'] == 'yes') {
            header("location: account.php?warning_msg_www");
        } else {
            header("location: account.php");
        }
        exit();
    } else {
        $msg = "There was a server error right this moment. Please try again later...";
    }
} else if(isset($_POST['update_pid']) && $_POST['update_pid'] != '' && $_SERVER['REQUEST_METHOD']=='POST') {
	if(update_publisher($_POST)){
        header("location: seller_mywebsites.php?pid=".$_POST['update_pid']);
        exit();
    } else {
        $msg = "There was a server error right this moment. Please try again later...";
    }
}

$smarty->assign('msg',$msg);
if(!isset($_GET['pid']) && $_SESSION[uid]>0){	
	$res = mysql_query("SELECT * FROM publishersinfo WHERE uid = '$_SESSION[uid]' ORDER BY pid DESC");
	while($r = @mysql_fetch_assoc($res)) {		
		$rr[] = array('pid'=>$r['pid'], 'url'=>$r['url'], 'title'=>$r['websitename'], 'description'=>$r['description'],'catId'=>$r['catid'], 'is_homepage'=>$r['is_homepage'],'date'=>$r['member_since'], 'set_price'=>my_money_format('%i', $r['set_price']),'google_page_rank'=>$r['google_page_rank'],'alexa_rank'=>$r['alexa_rank'],'domain_age'=>timeAgo($r['domain_age']),'status'=>$r['status']);
	}
}
if($_SESSION[pid])
$smarty->assign('info_edit',$info_edit);

$smarty->assign('www',$rr);
	
if(isset($_GET['pid']) && $_SESSION[uid]>0){
    $res2 = mysql_query("SELECT * FROM publishersinfo WHERE uid='$_SESSION[uid]' AND pid='$_GET[pid]'");
    if(!mysql_num_rows($res2)) header("location: publishers.php");
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
        $_POST['langid'] = $info['langid'];
        $_POST['clickrate'] = $info['clickrate'];
        $_POST['isadult'] = $info['isadult'];
        $_POST['lang'] = $info['langid'];
        $_POST['wsale'] = $info['sale_price'];
        $_POST['adposition'] = $info['adposition'];
        $_POST['isrestricted'] = $info['isrestricted'];
        $_POST['restriction'] = $info['restriction'];
        $_POST['script'] = $info['script'];
        $_POST['is_manual'] = $info['is_manual'];
	}
}
$_POST['catIds'] = explode(" , ", $_POST['catIds']);	
$smarty->assign('geo',$left_list['location']);
$smarty->assign('g_id',$left_list['gid']);
$smarty->assign('r_geo',$right_list['location']);
$smarty->assign('r_g_id',$right_list['gid']);
$cat_list = get_list('category','category');
$smarty->assign('cats',$cat_list['category']);
$smarty->assign('cat_ids',$cat_list['cid']);

if(isset($_POST[subcats]) && isset($_POST[cats])){
    $scat_list = get_sub_cat_list($_POST[cats]);
} else {
    $scat_list = get_sub_cat_list($cat_list['cid'][0]);
}

$meta[title] ='Buylink - Giúp tối ưu doanh thu cho websites, blogs của bạn  !';
$meta[des] ='Buylink giúp bạn kiếm tiền bằng cách bán textlink trên các website, blog mà bạn đang sở hữu với chi phí tốt nhất và được duy trì ổn định.';
$smarty->assign('meta', $meta);

$smarty->assign('scats',$scat_list['subcategory']);
$smarty->assign('scat_ids',$scat_list['sid']);
$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);
$smarty->assign('right_panel','off');

if($do=='edit'){
    $res3 = mysql_query("SELECT * FROM publishersinfo WHERE uid='$_SESSION[uid]' AND pid='$_GET[pid]'");
    if(!mysql_num_rows($res3)) header("location: publishers.php");
	if (isset($_POST['download_script'])) {
		$domain = getDomainName($_POST['url'],'domain');
		$scrip_name = str_replace('.', '_', getTrueDomain($domain));
		$scirpt_file = strtolower("ad_files/".$scrip_name.".php");
		$my_file = fopen($scirpt_file, 'w') or die("can't open file");
		fwrite($my_file, script_content($_POST['script'], $_config['www'], $_POST['script_type']));
		fclose($my_file);

		downloadZipFile($scirpt_file);
		header('Location: '.$_config["www"].'/ad_files/'.$scrip_name.'.php.zip');
	}
	$content = $smarty->fetch('website-edit.tpl');
}
else
	$content = $smarty->fetch('publishers.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>