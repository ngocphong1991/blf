<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
//include_once("bosoanthao/fckeditor.php");
require('../classes/class_admin.php'); $class_admin = new Admin(); $smarty->assign('class_admin', $class_admin);
$list_all = $class_admin->getAll();
$smarty->assign('list_all',$list_all);

if($_SESSION[admin_utype]==1){
	$action = $_REQUEST[action];	
	$user = $_POST[user];
	$pass = md5($_POST[pass]);
	$email = $_POST[email];
	$utype = isset($_POST[utype])?intval($_POST[utype]):2;

	
	switch($action){
	case 'edit':
		$uid = isset($_REQUEST[uid])?intval($_REQUEST[uid]):0;
		if($uid>1)
			$admin_info = $class_admin->getOne($uid);
			$smarty->assign('admin_info', $admin_info);			
			if($user && $pass){	
							
			if(!$class_admin->updateOne($uid, "user='".$user."', pass='".$pass."', email='".$email."' , utype='".$utype."' ")){
				die('Error');
			}
			header("location: ".$_config['www']."/admin/admin.php?uid=".$uid."&action=edit"); 			       
			
		}
				
		break;
		case 'insert':		
		if($user && $pass){			
			$field = 'user, pass, email, utype'; 
			$value = "'".strip_tags($user)."','".strip_tags($pass)."', '".addslashes(trim($email))."','".addslashes($utype)."'"; 						    
			// Case insert user
			$sql =$class_admin->insertOne($field, $value);
			$smarty->assign('msn','Tạo user thành công!');
			header("location: ".$_config['www']."/admin/admin.php");
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
	
	// Case delete user
	if($_GET['action']=='delete') {;
		$uid = isset($_REQUEST[uid])?intval($_REQUEST[uid]):0;
		if($uid>1){
        if($class_admin->deleteOne($uid));
		header("location: ".$_config['www']."/admin/admin.php");
		}else $smarty->assign('msn','Bạn không có quyền xóa user này!');
    }
	
}else{
	$smarty->assign('msn','Bạn không có quyền tạo user');
}
###

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('admin.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>