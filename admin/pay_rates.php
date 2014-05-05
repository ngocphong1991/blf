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
require('class/class_publishersinfo.php'); $cls_publishersinfo = new Publishersinfo(); $smarty->assign('cls_publishersinfo', $cls_publishersinfo);
require('class/class_users.php'); $cls_users = new Users(); $smarty->assign('cls_users', $cls_users);

$cons = 'parentId=0 ';
if($_GET['keyword']) {
$cons .= " and uid in (SELECT uid FROM users WHERE username like '%".$_GET['keyword']."%') ";
$smarty->assign('keyword', $_GET['keyword']);
}

if($_GET['url']) {
$cons .= " and  url like '%".$_GET['url']."%' ";
$smarty->assign('url', $_GET['url']);
}

$cons .= ' order by pid DESC';
$all_publishersinfo = $cls_publishersinfo->getListPage($cons);
$smarty->assign('all_publishersinfo', $all_publishersinfo);
$paging = $cls_publishersinfo->getNavPage($cons);
$smarty->assign('paging', $paging);
$cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
$smarty->assign('cursorPage', $cursorPage);
#

if($_GET[show]){
$pid = intval($_GET[show]);
$value = "status=2";
if($cls_publishersinfo->updateOne($pid, $value)) {
    header('Location: '.$_config[www].'/admin/pay_rates.php?rates');
}
}elseif($_GET[hide]){
$pid = intval($_GET[hide]);
$value = "status=1";
if($cls_publishersinfo->updateOne($pid, $value)) {
    header('Location: '.$_config[www].'/admin/pay_rates.php?rates');
}
}

if($_GET['act']=='ajax') {
if($_POST['pid'] && $_POST['admin_rate']) {
    $pid = $_POST['pid'];
    $admin_rate = $_POST['admin_rate'];
    $value = "set_price='".$admin_rate."'";
    if($cls_publishersinfo->updateOne($pid, $value)) {
        $cls_publishersinfo->set_link_confirm($pid);
        die('1');
    }
    else die('0');
}
die('0');
}
if($_GET['act']=='update_sale') {
if($_POST['pid'] && $_POST['sale_rate']) {
    $pid = $_POST['pid'];
    $sale_rate = $_POST['sale_rate'];
    $value = "sale_price='".$sale_rate."'";
    if($cls_publishersinfo->updateOne($pid, $value)) {
        $cls_publishersinfo->set_link_confirm($pid);
        die('1');
    }
    else die('0');
}
die('0');
}
if($_GET['act']=='send_mail') {
if($_POST['pid']) {
    $pid = $_POST['pid'];
    $onePublishersinfo = $cls_publishersinfo->getOne($pid);

    $oneUser = $cls_users->getOne($onePublishersinfo['uid']);

    $to = $oneUser["email"];
    $subject = 'Textlink.vn Important:Set pirce for your website!';

    $message = '
<html>
<head>
  <title>ĐỊNH GIÁ WEBSITE!</title>
</head>
<body>
 <p>Xin chào, '.$oneUser["username"].'<strong></strong><br />
    <br />
  Xin chúc mừng bạn! Website <a href="'.$onePublishersinfo["url"].'" target="_blank">'.$onePublishersinfo["url"].'</a>&nbsp;đã được định giá. Textlink luôn đưa ra một mức giá hấp dẫn nhất dành cho các website chất lượng. Để website của bạn luôn xuất hiện trên <a href="'.$onePublishersinfo["url"].'">marketplace</a> của chúng tôi, Bạn hãy <a href="http://textlink.vn/publishers.php?step=1">vào đây</a> để cài đặt code của textlink ngay hôm nay và kiếm tiền dễ dàng với số lượng lớn Advertiser của chúng tôi. <br />
  <br />
  Textlink trên website của bạn được bán với giá: '.$onePublishersinfo["sale_price"].' USD/textlink/tháng và bạn sẽ nhận được: '.$onePublishersinfo["set_price"].' USD/textlink/tháng. Mức giá này được Textlink đưa ra dựa trên việc đánh giá rất nhiều yếu tố trên website của bạn.<br />
  Thu nhập từ việc bán textlink trên website của bạn sẽ được tự động chuyển vào tài khoản của bạn sau khi các đơn hàng kết thúc thành công. Bạn có thể&nbsp;<u>truy cập vào tài khoản</u><a href="http://textlink.vn/account.php/">your</a><u> account</u>&nbsp;bất cứ lúc nào để quản lý và theo dõi thu nhập của bạn.<br />
  Nếu bạn gặp bất cứ vấn đề nào về việc cài đặt code hoặc không hài lòng với mức giá chúng tôi đưa ra, xin vui lòng liên hệ với chúng tôi.<br />
  <br />
  Xin chân thành cảm ơn!<br />
  <br />
  <strong>Textlink.vn</strong><br />
  <u>support@textlink.vn</u> <br />
  <a href="http://www.textlink.vn">http://www.textlink.vn</a><u> </u><br />
  <br />
  Tầng 15, Tòa nhà Chamvit Tower | 117 Trần Duy Hưng, Cầu Giấy, Hà Nội |&nbsp;04.62698999 |&nbsp;<a href="$_config[www]/" target="_blank">Textlink.vn</a> <br />
  &copy; 2012 Textlink.vn.  All rights reserved.</p>
</body>
</html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Additional headers
$headers .= 'To: <'.$to.'>, <'.$to.'>' . "\r\n";
$headers .= 'From: TextLink.vn <noreply@textlink.vn>' . "\r\n";
// Mail it
if(mail($to, $subject, $message, $headers)) die(1);
else die('0');

        }
    }
    if($_GET['act']=='confirm') {
        $key = $_GET['u'];
        if($key) {
            if($cls_publishersinfo->is_confirm($key)) die('Xác nhận thành công. Cảm ơn bạn!');
        }
        die('Xác nhận thất bại. Sai key');
    }
###

$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('pay_rates.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>