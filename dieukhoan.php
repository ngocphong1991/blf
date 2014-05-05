<?php
include "include/config.php";

$do = isset($_GET['do'])?addslashes($_GET['do']):'';
if($do == 'dieukhoan')
$content = $smarty->fetch('dieukhoan.tpl');
else 
$content = $smarty->fetch('chinhsach.tpl');	
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>