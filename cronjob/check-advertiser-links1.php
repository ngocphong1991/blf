<?php
include ("../include/config.php");
date_default_timezone_set('Asia/Bangkok');

require_once('../classes/class_user.php'); 
$cls_user = new User();

// multiple recipients
$arr_urr = getListAds();
$arr_user = getFileContent($arr_urr);

function getFileContent($arr_urr){
	$arr_user = array();
	foreach($arr_urr as $url){
		$pub_url = str_replace("http://", "", trim($url['url']));
        $pub_url = "http://" . $pub_url;
		//echo $url;
		$content = get_web_page(trim($pub_url));
		preg_match_all("/href=\"([^\"]*)\"(?:[^>]*)>(?:[^<]*)/is", $content, $links);
		//print_r($links[1]);
		if (in_array(trim($url['ad_url']), $links[1])) {
    		//echo $url['ad_url'].'có tồn tại trong'.$url['url'];
			//echo '<br>';
			mysql_query('' . 'UPDATE publishersinfo SET update_date = CURDATE() WHERE pid=\'' . $url["pid"] . '\' LIMIT 1');
		}
		else {
			$res_cron = mysql_query('' . 'SELECT uid, adv_id, pid FROM cronjob_publisher WHERE pid= ' . $url["pid"] . ' AND cron_time= CURDATE() LIMIT 1');
			if (mysql_num_rows($res_cron)) {
				continue;
			}else{
				mysql_query('' . 'insert into cronjob_publisher set pid=\''.$url["pid"].'\', uid=\''.$url["uid"].'\', adv_id = \''.$url["adv_id"].'\',adv_url = \''.addslashes($url["ad_url"]).'\', url=\''.addslashes($url["url"]).'\', cron_time= CURDATE() ');
				//email to publisher notify
				
				$arr_user["web"][$url["uid"]] .= $url["url"];
				$arr_user["text"][$url["uid"]] .='<b>Link Text:</b> '.addslashes($url[ad_des]).'<br><b>Link URL:</b>  <a href="'.addslashes($url["ad_url"]).'" target="_blank">'.addslashes($url["ad_url"]).'</a><br><b>Placed On:</b>  <a href="'.addslashes($url["url"]).'" target="_blank">'.addslashes($url["url"]).'</a><br>';				
				//print_r($arr_user);				
				//sent_mail('tien.pham@netlink.vn', 'Pham tien', $url["ad_des"], $url["ad_url"], $url["url"]);
				//sent mail				
			}
		}
	}
	return $arr_user;
}

if(count($arr_user)>0){
	foreach($arr_user["text"] as $userId=>$text){
		//echo $text;
		//get email
		$to = $cls_user->getEmail($userId);
		
		//$to  = 'tien.pham@netlink.vn';
//$to .= 'kisyrua@yahoo.com';
// subject
$subject = 'Quan trọng: Textlink - Quảng cáo không hiển thị';

// message
$message = '
<html>
<head>
  <title>Textlink.vn: Quảng cáo không hiển thị</title>
</head>
<body>
Xin chào,<br><br>
Textlink kiểm tra và thấy rằng một link quảng cáo trên website <a href="'.$arr_user["web"][$userId].'" target="_blank">'.$arr_user["web"][$userId].'</a> của bạn không còn hiển thị. Bạn hãy vui lòng kiểm tra và đặt lại link đã đặt trên website trong vòng 48 tiếng, nếu không Textlink buộc phải hoàn tiền lại cho advertiser và tất cả thu nhập của bạn từ việc đặt link quảng cáo này sẽ bị hủy bỏ.<br>
<br>
Nếu bạn đặt chọn đặt link bằng tay thì hãy kiểm tra lại quá trình đặt link vào website. Còn nếu bạn cài đặt code tự động của textlink.vn thì hãy đảm bảo rằng nó vẫn đang hoạt động bình thường. Đối với giao diện website là Wordpress, hãy đảm bảo rằng plugin textlink đã được kick hoạt và Bạn đã active thanh sidebar của Textlink.</b><br>
<br>
Nếu bạn có bất kỳ câu hỏi hay sự không hài lòng nào về link quảng cáo, Xin vui lòng liên hệ với chúng tôi. Đây là thông tin chi tiết về text link ad:<br><br>
'.$text.'<br>
Cảm ơn bạn đã giúp chúng tôi giải quyết vấn đề này!<br><br>
<br>
IntelliLinks Support<br>
<a href="mailto:support@textlink.vn" target="_blank">support@textlink.vn</a><br>
<a href="http://textlink.vn" target="_blank">http://textlink.vn</a>

</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: <'.$to.'>, <'.$to.'>' . "\r\n";
$headers .= 'From: TextLink.vn <support@textlink.vn>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
	}
}

function getListAds(){
	$arr_url = array();
	$slq ="select publishersinfo.pid, publishersinfo.uid, publishersinfo.url, publishersinfo.set_price, advertisersinfo.end_date,advertisersinfo.adv_id, advertisersinfo.ad_url,advertisersinfo.ad_des from publishersinfo LEFT JOIN (advertisersinfo) ON (advertisersinfo.pid = publishersinfo.pid) where publishersinfo.pid NOT IN (SELECT cronjob_publisher.pid FROM cronjob_publisher WHERE cron_time =  CURDATE()) AND publishersinfo.status = 2 and publishersinfo.update_date < CURDATE() and advertisersinfo.is_paid='Y' and advertisersinfo.start_date <= CURDATE() and advertisersinfo.end_date >= CURDATE() limit 15 ";
		
	//$order_by = " order by advertisersinfo.adv_id DESC";
	$money_earn_obj = mysql_query($slq.$order_by);
    while ($row = mysql_fetch_assoc($money_earn_obj)) {
		//print_r($row);
		//$arr_url[] = array($row['url'], $row['ad_url']);
		$arr_url[] = $row;
	}
	return $arr_url;
}
?>
