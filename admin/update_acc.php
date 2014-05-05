<?php

include ("../include/config.php");
include ("global.php");
if(!isset($_SESSION[admin_uid])) {
	header("location: ../admin/");
	exit();
	}

$_SESSION[uid] = $_GET[acc_id];
$msg = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(update_user($_POST))
		$msg = "Account update successful!";
	else $msg = "There was a server error right this moment. Please try again later...";
}
$ui = mysql_fetch_assoc(mysql_query("select * from users where uid = '$_SESSION[uid]' "));
foreach($ui as $key => $val)
	eval ("\$_POST['".$key."'] = \"".stripslashes($val)."\";");

$country = get_list('country','country');
	
$smarty->assign('country',$country['country']);
$smarty->assign('msg',$msg);
$smarty->assign('payment_methods',get_payment_methods());
$smarty->assign('right_panel','off');
$content = $smarty->fetch('update.tpl');
$smarty->assign('content', $content);
$smarty->display('master_page.tpl');
?>

