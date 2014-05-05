<?php
if($_SESSION['uid']){
	include_once('../classes/class_user.php');
	$cls_user = new User(); 
	$my_balance = $cls_user->getYourMoney();
	$smarty->assign('my_balance',$my_balance);
	
}
?>