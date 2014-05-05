<?php
include ("include/config.php");
include_once("global.php");

if(!isset($_SESSION[uid])){	
	header("location: ".$_config[www]."/account.php");			
	exit();
}

$meta[title] ='Textlink.vn - Nơi bạn thỏa mãn niềm đam mê SEO của mình !';
$meta[des] ='Textlink.vn giúp bạn chọn mua các textlink có giá trị cao với chi phí hợp lý, thỏa mãn niềm đam mê xây dựng backlinks và nâng cao thứ hạng từ khóa cho website của bạn.';
$smarty->assign('meta', $meta);
if(isset($_GET['offset']))
$offset=$_GET['offset'];
else $offset=0;
$limit=10;
$num=0;




$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);

$cat_list = get_list('category','category');
$smarty->assign('cats',$cat_list['category']);
$smarty->assign('cat_ids',$cat_list['cid']);

$smarty->assign('len_menu', $lens);
$smarty->assign('right_panel', 'off');
$content = $smarty->fetch('buyalink.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
 ?>