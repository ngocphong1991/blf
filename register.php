<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "include/config.php";
include "global.php";
require_once('classes/class_country.php'); $cls_country = new Country(); $smarty->assign('cls_country', $cls_country);
$msg =array();
$msg_quick = array();
if(isset($_POST['quick-register']) && $_POST['quick-register'] == 1){
    if($_POST['email']!='' && $_POST['email']){
        $email_valid = isValid($_POST['email'], 'email');
        if($email_valid==1) $msg_quick['email'] = "The email had exist.";
        elseif($email_valid==2)
            $_SESSION['email'] = $_POST['email'];
        else $msg_quick['email'] = "The email not format correct";
    }else $msg_quick['email'] = "Please enter your email";

    if($_POST['username']!='' && $_POST['username']){
        if(strlen($_POST['username'])<4) $msg_quick['username'] = "The username must be at least 4 characters.";
        $username_valid = isValid($_POST['username'], 'username');
        if($username_valid==1) $msg_quick['username'] = "The username had exist";
        elseif($username_valid==2)
            $_SESSION['username'] = $_POST['username'];
        else $msg_quick['username'] = "The username not format correct";
    }else $msg_quick['username'] = "Please enter your username";

    if(count($msg_quick)==0){
        if(quick_register_new_user($_POST)){
            login(trim($_POST['username']), $_POST['password']);
            header('Location: '.$_config['wwww'].'profile');
        }
    }else{
        foreach($msg_quick as $err_mess){
            $mess .= '<p><span>'.$err_mess.'</span></p>';
            $smarty->assign('msg_quick',$mess);
        }
    }
}
elseif(isset($_POST) && count($_POST)){
	if($_POST['email']!='' && $_POST['email']){
		$email_valid = isValid($_POST['email'], 'email');
		if($email_valid==1) $msg['email'] = "The email had exist.";
		elseif($email_valid==2)
			$_SESSION['email'] = $_POST['email'];
		else $msg['email'] = "The email not format correct";
	}else $msg['email'] = "Please enter your email";

	if($_POST['mobile']!='' && $_POST['mobile']){

		if(!ereg("(^['a-zA-Z0-9']{1,}['a-zA-Z0-9|\.|\_']{1,}['a-zA-Z0-9']{1,}$)",trim($_POST['mobile']))){
     		$msg['mobile'] = "The phone must be number";
   		 }
		$_SESSION['phone'] = $_POST['mobile'];
	}


	if($_POST['text_ad_pass']!='' && $_POST['text_ad_pass']){
		if(strlen($_POST['text_ad_pass'])<6) $msg['pass'] = "The password must be at least 6 characters.";
		if($_POST['text_ad_pass']!=$_POST['text_ad_pass2']) $msg['pass'] = "The re-password not match.";
		if(count($msg)==0)
			$_SESSION['text_ad_pass'] = $_POST['text_ad_pass'];
	}else $msg['pass'] = "Please enter the password.";

	if($_POST['username']!='' && $_POST['username']){
		if(strlen($_POST['username'])<4) $msg['username'] = "The username must be at least 4 characters.";
		$username_valid = isValid($_POST['username'], 'username');
		if($username_valid==1) $msg['username'] = "The username had exist";
		elseif($username_valid==2)
			$_SESSION['username'] = $_POST['username'];
		else $msg['username'] = "The username not format correct";
	}else $msg['username'] = "Please enter your username";

    if(isExist('firstName', $_POST) && isExist('lastName', $_POST)){
        $_SESSION['fname'] = $_POST['firstName'].' '.$_POST['lastName'];
    }else $msg['full-name'] = "Please enter your name.";

    if(isExist('type', $_POST)){
        $_SESSION['utype'] = $_POST['type'];
    }

    if(isExist('company', $_POST)){
        $_SESSION['company'] = $_POST['company'];
    }

    if(isExist('country', $_POST)){
        $_SESSION['country'] = $_POST['country'];
    }

    if(isExist('address', $_POST)){
        $_SESSION['address'] = $_POST['address'];
    }else $msg['address'] = "Please enter your address";

    if(isExist('city', $_POST)){
        $_SESSION['city'] = $_POST['city'];
    }else $msg['city'] = "Please enter your city";

    if(isExist('state', $_POST)){
        $_SESSION['state'] = $_POST['state'];
    }else $msg['state'] = "Please enter your state";

	if(count($msg)==0){
        if(register_new_user($_SESSION)){
            login(trim($_SESSION['username']), $_SESSION['text_ad_pass']);
            header('Location: '.$_config['wwww'].'profile');
        }
    }
	else{
		$mess='<p>The highlighted information is missing or incorrect.<br> If you need further assistance, please contact SEOsupport@mediawhiz.com</p>';
		foreach($msg as $err_mess){
			$mess .= '<p><span>'.$err_mess.'</span></p>';
			$smarty->assign('msg',$mess);
		}
	 }
}

$allCountry = $cls_country->getAll('');
$smarty->assign('allCountry',$allCountry);
$content = $smarty->fetch('register.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>
