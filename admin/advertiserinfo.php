<?php
$admin_page = 'Y';
include ("../include/config.php");
include ("global.php");
###
require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo(); $smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);
require('../classes/class_earnings.php'); $cls_earnings = new Earnings();
require('../classes/class_cronjob_publisher.php'); $cls_cronjob_publisher = new Cronjob_publisher(); $smarty->assign('cls_cronjob_publisher', $cls_cronjob_publisher);
#


if($_POST['refunds']!='' && isset($_POST[refunds])) {
    $adv_id = isset($_POST['adv_id'])?intval($_POST['adv_id']):0;
    $adv_info = $cls_advertisersinfo->getOne($adv_id);

    // add money for Advertiser.
    $cls_user->plusMoney(1, 1000);
    $total_wesite_earn = $cls_earnings->getSiteEarning($adv_info[pid], $adv_info[adv_id]);
    echo $total_wesite_earn;
    //$cls_user->minusMoney($adv_info[uid], $adv_info[price]);
}
if($_GET['auth']!='' && isset($_GET[action])) {
    $auth_action = isset($_GET['auth'])?intval($_GET['auth']):0;
    if($auth_action>0){


        $adv_info = $cls_advertisersinfo->getOne($auth_action);

            $oneUser = $cls_user->getOne($adv_info['uid']);


        $onePublishersinfo = $cls_Publishersinfo->getOne($adv_info['pid']);


        $smarty->assign('adv_info', $adv_info);
            //@ update action
            $action = isset($_GET[action])?addslashes($_GET[action]):'';
            if($action=='active'){
                $value = "is_auth='Y'";

                $cls_advertisersinfo->updateOne($auth_action, $value);

                // Send mail
                //$to = $adv_info["email"];

        $to = $oneUser["email"];
        $subject = 'TextLink: Link confirmation!';

        $message = '
<html>
<head>
  <title>TextLink: Link confirmation!</title>
</head>
<body>
 <p>Xin chào '.$oneUser["username"].',<br>
  (Các) liên kết dưới đây đã được xuất hiện trên website mà bạn đã chọn mua, bạn vui lòng kiểm tra và nếu có thông tin sai sót xin hãy liên hệ với chúng tôi:<br>
  <br>
  <br>
  <strong>Thông tin chi tiết: </strong><br>
  <br>
  Tên Website	'.$onePublishersinfo["wesitename"].' <br>
  Giá/tháng:	'.$adv_info[price].' <br>
  Site URL:	'.$onePublishersinfo["url"].' <br>
  Từ khóa:	'.$adv_info[ad_des].'<br>
  Đường dẫn đích:	'.$adv_info[ad_url].' </p>
<p>Để đăng nhập và quản lý tài khoản, bạn vui lòng truy cập:<br>
  http://www.textlink.vn</p>
<p>Cám ơn bạn rất nhiều.<br>
</p>
  <strong>Textlink.vn</strong><br />
  <u>support@textlink.vn</u> <br />
  <a href="'.$_config[www].'">'.$_config[www].'</a><u> </u><br />
  <br />
  Tầng 15, Tòa nhà Chamvit Tower | 117 Trần Duy Hưng, Cầu Giấy, Hà Nội |&nbsp;04.62698999 |&nbsp;<a href="'.$_config[www].'/" target="_blank">Textlink.vn</a> <br />
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
if(mail($to, $subject, $message, $headers)) echo 'OK';
// end sendmail

				}elseif($action=='cancel'){
					$value = "is_auth='N'";
					$cls_advertisersinfo->updateOne($auth_action, $value);
				}
		}		header("location: ".$_config['www']."/admin/advertiserinfo.php");  

    }
	
    $cons = '1=1 ';
    if($_GET['keyword']) {
        $cons .= " and uid in (SELECT uid FROM users WHERE username like '%".$_GET['keyword']."%') ";
        $smarty->assign('keyword', $_GET['keyword']);
    }
	 if($_GET['pub_user']) {
        $cons .= " and pub_uid in (SELECT uid FROM users WHERE username like '%".$_GET['pub_user']."%') ";
        $smarty->assign('pub_user', $_GET['pub_user']);
    }	

    if($_GET['approved']!='') {
        $cons .= " and approved='".$_GET['approved']."' ";
        $smarty->assign('approved', $_GET['approved']);
    }
    if($_GET['auth']!='' && !isset($_GET[action])) {
        $cons .= " and is_auth='".$_GET['auth']."' ";
        $smarty->assign('auth', $_GET['auth']);
    }
	if($_GET['is_manual']=='Y') {
        $cons .= " and pid in (SELECT pid FROM publishersinfo WHERE is_manual='Y') ";
        $smarty->assign('is_manual', $_GET['is_manual']);
    }elseif($_GET['is_manual']=='N'){
		$cons .= " and pid in (SELECT pid FROM publishersinfo WHERE is_manual='N') ";
        $smarty->assign('is_manual', $_GET['is_manual']);
	}	
    if($_GET['paid']!='') {
        $cons .= " and is_paid='".$_GET['paid']."' ";
        $smarty->assign('paid', $_GET['paid']);
    }else $cons .= " and is_paid='Y' ";
	 if($_GET['today']!='') {
        $cons .= " and buying_date=CURDATE() ";
        $smarty->assign('today', $_GET['today']);
    }
	
	$cons .=' ORDER BY adv_id DESC ';
	
    $all_advertisersinfo = $cls_advertisersinfo->getListPage($cons);
    $smarty->assign('all_advertisersinfo', $all_advertisersinfo);
    $paging = $cls_advertisersinfo->getNavPage($cons);
    $smarty->assign('paging', $paging);
    $cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
    $smarty->assign('cursorPage', $cursorPage);
    
  

###
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('advertisersinfo.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>