<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "include/config.php";
$user_refer = isset($_GET[ref])?addslashes($_GET[ref]):'';
if($user_refer) $_SESSION[ref] = $user_refer;
$tmp = $_SERVER['PHP_SELF'];
$tmp = explode('/', $tmp);
$page = $tmp[count($tmp) - 1];

require('classes/class_news.php'); $class_news = new News(); $smarty->assign('class_news', $class_news);
$allnews = $class_news->getAll('1=1 order by order_no limit 0,4');
$smarty->assign('allnews',$allnews);

$meta[title] ='Buylink - Mạng quảng cáo buylink hàng đầu và duy nhất tại Việt Nam !';
$meta[des] ='Buylink mang đến cho các chủ website cơ hội phát triển và kiếm tiền bền vững cùng chúng tôi. Đến với Buylink, các bạn sẽ là những người mang đến sự đổi mới cho ngành Internet Marketing tại Việt Nam. Bạn còn chần chừ gì nữa ?
Keywords: buylink, backlinks, seo, sem, internet marketing, online marketing, top 1 google, top 1 yahoo.';
$smarty->assign('meta', $meta);

$smarty->assign('nmsg',$nmsg);	
$content = $smarty->fetch('index.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>
