<?php
include ("include/config.php");
$msg = "";

if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=="submit"){

}

$content = $smarty->fetch('blog.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>