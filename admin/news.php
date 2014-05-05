<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
//include_once("bosoanthao/fckeditor.php");
###
require('../classes/class_news.php'); $class_news = new News(); $smarty->assign('class_news', $class_news);
require('../classes/class_news_cat.php'); $class_news_cat = new NewsCat(); $smarty->assign('class_news_cat', $class_news_cat);
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
#

$allcat = $class_news_cat->getAll(''); $smarty->assign('allcat', $allcat);

$action = $_REQUEST[action];
$Title = isset($_POST[Title])?$_POST[Title]:'';
$Intro = isset($_POST[Intro])?$_POST[Intro]:'';
$Content = isset($_POST[Content])?$_POST[Content]:'';
$CatID = isset($_POST[CatID])?$_POST[CatID]:'';
$order_no = isset($_POST[order_no])?$_POST[order_no]:'';

switch($action){
case 'edit':
    $Id = isset($_REQUEST[Id])?intval($_REQUEST[Id]):0;
    if($Id>0)
        $new_info = $class_news->getOne($Id);
        $smarty->assign('new_info', $new_info);
        if($Title && $Content){

        if(!$class_news->updateOne($Id, "Title='".$Title."', Intro='".$Intro."', Content='".$Content."' , CategoryId='".$CatID."' , order_no='".$order_no."'")){
            die('Error');
        }
        header("location: ".$_config['www']."/admin/news.php?Id=".$Id."&action=edit");

    }

    break;
    case 'insert':
    if($Title && $Content){
            $field = 'Title, Intro, Content, NewsCreateTime, CategoryId, order_no';
            $value = "'".strip_tags($Title)."','".strip_tags($Intro)."', '".addslashes(trim($Content))."', CURDATE() ,'".addslashes($CatID)."','".addslashes($order_no)."'";
        //die($value);
        $sql =$class_news->insertOne($field, $value);
        header("location: ".$_config['www']."/admin/news.php");
    }
    break;


    case 'view':
    $Id = isset($_REQUEST[Id])?intval($_REQUEST[Id]):0;
    if($Id>0){
        $new_info = $class_news->getOne($Id);
        $smarty->assign('new_info', $new_info);
    }
    break;

defaul:
    echo 'abc';

}
	
if($_GET['action']=='delete') {;
    $Id = isset($_REQUEST[Id])?intval($_REQUEST[Id]):0;
    if($Id>0)
    if($class_news->deleteOne($Id));
    header("location: ".$_config['www']."/admin/news.php");
}

$cons = '1=1 ';
if($_GET['keyword']) {
    $cons .= " and Title  like '%".$_GET['keyword']."%' ";
    $smarty->assign('keyword', $_GET['keyword']);
}

$all_news = $class_news->getListPage($cons.' order by order_no');
$smarty->assign('all_news', $all_news);
$paging = $class_news->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('news.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>