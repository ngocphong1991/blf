<?php
include ("include/config.php");
include_once("global.php");
if($_SESSION[uid])
header('Location: '.$_config[www].'/marketplace');

require('classes/class_news.php'); $class_news = new News(); $smarty->assign('class_news', $class_news);
$allnews = $class_news->getAll('1=1 order by order_no limit 0,4');
$smarty->assign('allnews',$allnews);

$content = $smarty->fetch('advertisers.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>