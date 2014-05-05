<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
//include_once("bosoanthao/fckeditor.php");
###
	require('../classes/class_news_cat.php'); $class_news_cat = new NewsCat(); $smarty->assign('class_news_cat', $class_news_cat);
    require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
    require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
    #

	$action = $_REQUEST[action];
	$Title = isset($_POST[Title])?$_POST[Title]:'';

	switch($action){
	case 'edit':
		$Id = isset($_REQUEST[Id])?intval($_REQUEST[Id]):0;
		if($Id>0)
			$new_info = $class_news_cat->getOne($Id);
			$smarty->assign('new_info', $new_info);
			if($Title){

			if(!$class_news_cat->updateOne($Id, "Title='".$Title."'")){
				die('Error');
			}
			header("location: ".$_config['www']."/admin/news_cat.php?Id=".$Id."&action=edit");

		}

		break;
		case 'insert':
		if($Title){
				$field = 'Title';
				$value = "'".strip_tags($Title)."'";
			$sql =$class_news_cat->insertOne($field, $value);
			header("location: ".$_config['www']."/admin/news_cat.php");
		}
		break;


		case 'view':
		$Id = isset($_REQUEST[Id])?intval($_REQUEST[Id]):0;
		if($Id>0){
			$new_info = $class_news_cat->getOne($Id);
			$smarty->assign('new_info', $new_info);
		}
		break;

	defaul:
		echo 'abc';

	}

	if($_GET['action']=='delete') {;
		$Id = isset($_REQUEST[Id])?intval($_REQUEST[Id]):0;
		if($Id>0)
        if($class_news_cat->deleteOne($Id));
		header("location: ".$_config['www']."/admin/news_cat.php");
    }
	
    $cons = '1=1 ';
    if($_GET['keyword']) {
        $cons .= " and Title  like '%".$_GET['keyword']."%' ";
        $smarty->assign('keyword', $_GET['keyword']);
    }    

    $all_news = $class_news_cat->getListPage($cons);
    $smarty->assign('all_news', $all_news);
    $paging = $class_news_cat->getNavPage($cons);
    $smarty->assign('paging', $paging);
    $cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
    $smarty->assign('cursorPage', $cursorPage);    
  

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('news_cat.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>