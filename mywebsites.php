<?php
include ("include/config.php");
$msg = "";
if(isset($_GET['no_www'])){
    $msg = "You hav no website to advertise on. Please register a website first.";
}

if(isset($_POST['delete_pid'])){
	mysql_query("DELETE FROM publishersinfo WHERE pid='$_POST[del_pid]'");
	header("location: seller_mywebsites.php");			
	exit();
}

if($_SESSION['utype'] != 'pub+adv'){
	header("location: account.php?smw&red_url=".urlencode(basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']));
	exit();
}

if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST['update_pid'])) {
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
	

$res = mysql_query("SELECT * FROM publishersinfo WHERE uid = '$_SESSION[uid]' ORDER BY pid DESC");
while($r = @mysql_fetch_assoc($res)) {
	$rr[] = array('pid'=>$r['pid'], 'web'=>$r['websitename']);
}
$smarty->assign('www',$rr);
	
if(isset($_GET['pid'])){
$res2 = mysql_query("SELECT * FROM publishersinfo WHERE uid='$_SESSION[uid]' AND pid='$_GET[pid]'");
while($info = @mysql_fetch_assoc($res2)){
	$_POST['wname'] = $info['websitename'];
	$_POST['url'] = $info['url'];
	$_POST['wdes'] = $info['description'];
	$_POST['cats'] = $info['catid'];
	$_POST['subcats'] = $info['subcatid'];
	$_POST['keywords'] = $info['keywords'];
	$_POST['tad'] = $info['targetedad'];	
	$_POST['clickrate'] = $info['clickrate'];
	$_POST['isadult'] = $info['isadult'];
	$_POST['lang'] = $info['langid'];
	$_POST['adposition'] = $info['adposition'];
	$_POST['isrestricted'] = $info['isrestricted'];
	$_POST['restriction'] = $info['restriction'];
	
	$g = mysql_query("select gid from pub_geo where pid=$info[pid]");
		for($i=0; $i< mysql_num_rows($g); $i++)
			$_POST[dest][$i] = mysql_result($g,$i,0);
	}
}
	
	$geo_list = get_list('pub_geolist','location');
	
	for ($i=0;$i<count($geo_list['gid']);$i++)
	{
		if(@in_array($geo_list['gid'][$i], $_POST['dest'])){
		 $right_list['location'][] = $geo_list['location'][$i];
		 $right_list['gid'][] = $geo_list['gid'][$i];
		 }
		 else{
		 $left_list['location'][] = $geo_list['location'][$i];
		 $left_list['gid'][] = $geo_list['gid'][$i];
		 }
	}
	

	
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

$smarty->assign('scats',$scat_list['subcategory']);
$smarty->assign('scat_ids',$scat_list['sid']);
$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);
$smarty->assign('right_panel','off');
$content = $smarty->fetch('mywebsites.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>