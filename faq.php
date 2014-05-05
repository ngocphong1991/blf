<?php
include ("include/config.php");
$msg = "";

if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=="submit"){

}
require('classes/class_news_cat.php'); $class_news_cat = new NewsCat(); $smarty->assign('class_news_cat', $class_news_cat);
require('classes/class_news.php'); $class_news = new News(); $smarty->assign('class_news', $class_news);
$allcat = $class_news_cat->getAll('');

 $smarty->assign('allcat',$allcat);

if($_GET['cat']) {$item_cat = $class_news_cat->getAll('Id='.$_GET['cat']);}
else {$item_cat = $allcat;}
$smarty->assign('item_cat',$item_cat);

if($_GET['id']) $smarty->assign('id_active',$_GET['id']);
if($_GET['cat']) $smarty->assign('cat',$_GET['cat']);

$meta[title] ='Các câu hỏi thường gặp dành cho Advertiser và Publisher - Textlink.vn';
$meta[des] ='Mọi câu hỏi và thắc mắc của bạn sẽ được đội ngũ chuyên gia của Textlink giải đáp tận tình. Đừng ngại ngần đặt câu hỏi với chúng tôi!.';
$smarty->assign('meta', $meta);

$content = $smarty->fetch('faq.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>