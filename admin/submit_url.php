<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");

if(isset($_POST[login])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if (admin_login(trim($_POST[username]), $_POST[pass]))
            header("location: ../admin/");
        else
            $msg = 'User name & Password does not match';
    }
}

if(!isset($_SESSION[admin_uid]) && !isset($_GET[install_success]))
{
    $_SESSION = array();
    $_GET = array();
    $_POST = array();
    unset($_SESSION, $_GET, $_POST);
}

if(isset($_GET[logout])){
    mysql_query("update admin set last_login=CURRENT_TIMESTAMP");
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    header("location: ../admin/");
}

if(isset($_GET[suspend_acc_id])) {
    $st = $_GET[ts];
    if($st)
        $st = 0;
    else $st = 1;
    mysql_query("update users set status=$st where uid='$_GET[suspend_acc_id]'");
}

if(isset($_POST[update_default_pay_rate])) {
    mysql_query("update configurations set value='$_POST[rate]' where name='default_pay_rate'");
        header("location: ../admin/?rates");
}

if(isset($_POST[update_pay_rate])) {
    mysql_query("update publishersinfo set pay_rate='$_POST[rate]' where pid='$_GET[pid]'");
}

if(isset($_GET[rates]))
    $smarty->assign('web_list', get_list('publishersinfo', 'pid') );
if(isset($_GET[pid]))
    $smarty->assign('pay_rate', mysql_result(mysql_query("select pay_rate from publishersinfo where pid='$_GET[pid]' "),0,0) );

$tu = mysql_result(mysql_query("select count(*) from users"),0,0);

###
require('class/get_pagerank.php');
require('class/class_publishersinfo.php'); $cls_publishersinfo = new Publishersinfo(); $smarty->assign('cls_publishersinfo', $cls_publishersinfo);
require('class/class_users.php'); $cls_users = new Users(); $smarty->assign('cls_users', $cls_users);
require('class/class_submit_url.php'); $cls_submit_url = new SubmitUrl(); $smarty->assign('cls_submit_url', $cls_submit_url);
#
$cons = 'parentId=0';
$all_publishersinfo = $cls_publishersinfo->getListPage($cons);
$smarty->assign('all_publishersinfo', $all_publishersinfo);
$paging = $cls_publishersinfo->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);


if($_GET['act']=='add_url') {
    $title = $_POST['title'];
    $url = $_POST['url'];
    $pid = $_POST['pid'];
    $one = $cls_publishersinfo->getOne($pid); if($one['pid']=='') die('0');
    $field = 'parentId, websitename, url, google_page_rank, uid';
    $page_rank = 1;//google_page_rank($url);

    $value = "'".addslashes($pid)."'";
    $value .= ",'".addslashes($title)."'";
    $value .= ",'".addslashes($url)."'";
    $value .= ",'".addslashes($page_rank)."'";
    $value .= ",'".addslashes($one['uid'])."'";
    if($cls_publishersinfo->insertOne($field, $value)) {
        $all = $cls_publishersinfo->getAll("url='".$url."' order by pid desc limit 0,1");
        $one = $all[0];
        $res = '<tr class="tr-submiturl-'.$one['parentId'].'" accesskey="'.$one['pid'].'" id="submit_url_'.$one['pid'].'"><td style="border-left: 2px solid #77AAFC; padding-left: 20px">'.$one['websitename'].'</td><td>'.$one['url'].'</td><td></td><td>'.$one['google_page_rank'].'</td><td><button class="smart-btn btn-del">Del</button></td></tr>';
        die($res);
    }
    die('0');
}

if($_GET['act']=='del_url') {
    $pid = $_POST['pid'];
    if($cls_publishersinfo->deleteOne($pid)) die('1');
    die('0');
}

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('submit_url.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>