<?php
include "include/config.php";
$content = $smarty->fetch('gioithieu.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>
