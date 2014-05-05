<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");

if($_POST){
    foreach($_POST as $name => $value){
        mysql_query("UPDATE configurations SET `value`= '".$value."' WHERE `name` = '".$name."'");
    }
    header('Location: '. $_config['www'].'/admin/config.php?update=success');
}
$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);
$smarty->assign('config', $_config);
$content = $smarty->fetch('config.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>