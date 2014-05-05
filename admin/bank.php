<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_bank.php'); $cls_bank = new Bank(); $smarty->assign('cls_bank', $cls_bank);
#
if($_POST['data'] && $_POST['data']['name']!='' && $_POST['data']['branch']!='') {
    $data = $_POST['data'];
    $field = 'reg_date'; $value = "'".time()."'";
    foreach ($data as $key => $val) {
        if($val!=''){
            $field.=",".$key;
            $value .= ",'".addslashes($val)."'";
        }
    }
    if(!$cls_bank->insertOne($field, $value)) {
        die('Error');
    }
}
if($_GET['del']!='') {
    $id = $_GET['del'];
    if($cls_bank->deleteOne($id));
}
#
$cons = '';
$all_bank = $cls_bank->getListPage($cons);
$smarty->assign('all_bank', $all_bank);
$paging = $cls_bank->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('bank.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>