<?php
$admin_page = 'Y';
include ("../include/config.php");

require('class/class_publishersinfo.php'); $cls_publishersinfo = new Publishersinfo(); $smarty->assign('cls_publishersinfo', $cls_publishersinfo);
require('class/class_users.php'); $cls_users = new Users(); $smarty->assign('cls_users', $cls_users);
	

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
			
			if(isset($_GET[del_acc_id])) {
				mysql_query("delete from users where uid='$_GET[del_acc_id]'");
				mysql_query("delete from publishersinfo where uid='$_GET[del_acc_id]'");
				mysql_query("delete from publishers_adspaces where uid='$_GET[del_acc_id]'");
				mysql_query("delete from pub_ad_code where uid='$_GET[del_acc_id]'");
				mysql_query("delete from advertisersinfo where uid='$_GET[del_acc_id]'");
				mysql_query("delete from advertisersinfo_edit where uid='$_GET[del_acc_id]'");
				mysql_query("delete from adv_campaign where uid='$_GET[del_acc_id]'");
				mysql_query("delete from featured where uid='$_GET[del_acc_id]'");
				mysql_query("delete from featured where uid='$_GET[del_acc_id]'");
				}
				
			if(isset($_GET[new_acc])) {
				$smarty->assign('tabcontent', 'Y');
				$index = 0;
				$res_users = mysql_query("select * from users where status > 1 ");
				$users = array();
				$ur = array();
				while($ur = mysql_fetch_assoc($res_users)) {
					foreach($ur as $k => $val) {
						$users[$index][$k] = $val;
						}
					$index++;
				}
					$smarty->assign('new_users', $users);
				
				
				$res_www = mysql_query("select distinct publishersinfo.pid, publishersinfo.member_since, publishersinfo.websitename, publishersinfo.url, users.username from publishersinfo, users where users.uid=publishersinfo.uid and publishersinfo.status <=1 ");
				$sites = array();
				$wr = array();
				$index = 0;
				while($wr = mysql_fetch_assoc($res_www)) {
					foreach($wr as $k => $val) {
						$sites[$index][$k] = $val;
						}
					$index++;
				}
					$smarty->assign('new_sites', $sites);
			
				if(isset($_GET[approve])) {
					
					mysql_query("update users set status = '1' where uid = '$_GET[approve]' limit 1");
					header("location: ../admin/?new_acc");
					exit();
				}
				
				if(isset($_GET[reject])) {
					mysql_query("delete from users where uid = '$_GET[reject]' limit 1");
					header("location: ../admin/?new_acc");
					exit();
				}
				
				if(isset($_GET[approve_site])) {
					mysql_query("update publishersinfo set status = '2' where pid = '$_GET[approve_site]' limit 1");
					header("location: ../admin/?new_acc");
					exit();
				}
				
				if(isset($_GET[reject_site])) {			
					
			if($_GET[reject_site]) {
            $pid = intval($_GET[reject_site]);
            $onePublishersinfo = $cls_publishersinfo->getOne($pid);
			
            $oneUser = $cls_users->getOne($onePublishersinfo['uid']);
			
			$to = $oneUser["email"];

			$subject = 'Chúng tôi rất tiếc!';

$message = '
<html>
<head>
  <title>LÝ DO TỪ CHỐI SITE WEBSITE! '.$onePublishersinfo["url"].'</title>
</head>
<body>
 <p>Xin chào, '.$oneUser["username"].'<strong></strong><br />
    <br />
 <p>Chúng tôi rất xin lỗi nhưng website <a href="'.$onePublishersinfo["url"].'>'.$onePublishersinfo["url"].'</a> của bạn không đạt đủ tiêu chuẩn để trở thành Publisher của Textlink.vn và chúng tôi không thể tiếp tục hiển thị website của bạn trên Marketplace nữa. Những lý do có thể khiến website của bạn bị từ chối bao gồm:</p>
<p>&bull; Website có chứa nội dung xấu, xuyên tạc, vi phạm thuần phong mỹ tục và luật pháp của nước Cộng hòa xã hội chủ nghĩa Việt Nam.<br />
  &bull; Website không phải do bạn sở hữu và có quyền quản lý.<br />
 &bull; Website sử dụng tools, công cụ bên ngoài để post bài, không có nội dung tự nhiên.<br />
  &bull; Website không đạt tiêu chuẩn về các chỉ số đánh giá website như PageRank, Alexa Rank, Backlinks và các chỉ số khác.<br />
  &bull; Website có số lượng textlink trỏ đến website khác (hay còn gọi là outbound links hay external links) lớn hơn 15.</p>
<p>Lần từ chối này không đồng nghĩa với việc Textlink.vn hoàn toàn từ chối website <a href="'.$onePublishersinfo["url"].'>'.$onePublishersinfo["url"].' của bạn. Bạn vẫn có thể đăng ký website làm publisher bất kỳ lúc nào khi bạn cảm thấy website mình đạt tiêu chuẩn. Chúng tôi luôn sẵn sàng trả lời mọi câu hỏi của bạn.</p>
<p>Cám ơn bạn rất nhiều.</p>
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
/*
$message = '
<html>
<head>
  <title>LÝ DO TỪ CHỐI SITE WEBSITE! '.$onePublishersinfo["url"].'</title>
</head>
<body>
 <p>Xin chào,<strong>'.$oneUser["username"].'</strong><br />
   <br />
 <p>Chúng tôi rất xin lỗi nhưng website [website_url] của bạn không đạt đủ tiêu chuẩn để trở thành Publisher của Textlink.vn và chúng tôi không thể tiếp tục hiển thị website của bạn trên Marketplace nữa. Những lý do có thể khiến website của bạn bị từ chối bao gồm:</p>
<p>Website có chứa nội dung xấu, xuyên tạc, vi phạm thuần phong mỹ tục và luật pháp của nước Cộng hòa xã hội chủ nghĩa Việt Nam.<br />
  Website không phải do bạn sở hữu và có quyền quản lý.<br />
  Website sử dụng tools, công cụ bên ngoài để post bài, không có nội dung tự nhiên.<br />
  Website không đạt tiêu chuẩn về các chỉ số đánh giá website như PageRank, Alexa Rank, Backlinks và các chỉ số khác.<br />
  Website có số lượng textlink trỏ đến website khác (hay còn gọi là outbound links hay external links) lớn hơn 15.</p>
<p>Lần từ chối này không đồng nghĩa với việc Textlink.vn hoàn toàn từ chối website [website_url] của bạn. Bạn vẫn có thể đăng ký website [website_url] làm publisher bất kỳ lúc nào khi bạn cảm thấy website mình đạt tiêu chuẩn. Chúng tôi luôn sẵn sàng trả lời mọi câu hỏi của bạn.</p>
<p>Cám ơn bạn rất nhiều.</p>
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
*/
if(mail($to, $subject, $message, $headers)) {	
	mysql_query("delete from publishersinfo where pid = '$_GET[reject_site]' limit 1");
	header("location: ../admin/?new_acc");
	exit();
}
else die('0');

        }
		
				}
				
				if(isset($_POST[app_config])) {
					foreach($_POST as $key => $val)
					@mysql_query("update configurations set value='$val' where name='$key'");
					header("location: ../admin/?new_acc");
					exit();
				}
				
			}




			if(isset($_GET[delete_tip]))
				mysql_query("delete from tips where id='$_GET[tip_id]'");

			if(isset($_POST[update_tip]))
				mysql_query("update tips set tip='$_POST[tip_txt]' where id='$_POST[tip_id]'");
				
			if(isset($_POST[add_tip]))
				mysql_query("insert into tips set tip='$_POST[tip_txt]' ");
	
				
			if(isset($_GET[tips])) {
				$res = mysql_query("select * from tips order by id desc");
				while ($row = mysql_fetch_assoc($res))
					$c[] = array('id' => $row[id], 'tip' => $row[tip]);
				$smarty->assign('tips', $c);
			}
			
			
			if(isset($_GET[del_cid]))
				mysql_query("delete from category where cid='$_GET[del_cid]'");
				
			if(isset($_POST[add_cat]))
				mysql_query("insert into category set category='$_POST[cat]' ");
				
			if(isset($_POST[update_cat]))
				mysql_query("update category set category='$_POST[cat]' where cid='$_POST[cid]'");
	
			
			if(isset($_GET[cat]))
				$smarty->assign('cats', get_list('category','cid'));
				
			if(isset($_GET[del_sid]))
				mysql_query("delete from subcategory where sid='$_GET[del_sid]'");
				
			if(isset($_POST[add_subcat]))
				mysql_query("insert into subcategory set subcategory='$_POST[subcat]', cid='$_GET[cid]' ");
				
			if(isset($_POST[update_subcat]))
				mysql_query("update subcategory set subcategory='$_POST[subcat]' where sid='$_POST[sid]'");
					
			if(isset($_GET[subcat]))
				$smarty->assign('subcats', get_sub_cat_list($_GET[cid]));	
				
			if(isset($_GET[del_lang]))
				mysql_query("delete from language where lid='$_GET[del_lang]'");
			
			if(isset($_POST[add_lang])) {
				mysql_query("insert into language set language='$_POST[lang_name]'");
			}		
			if(isset($_GET[lang]))
				$smarty->assign('lang', get_list('language', 'language'));
				
				
			////////////////////////
			if(isset($_POST['update_txt_size']))
				mysql_query("update text_size set layout_name='".htmlspecialchars($_POST[layout_name])."', width='$_POST[width]', height='$_POST[height]' where id='$_POST[id]'");
			if(isset($_GET[del_txt_layout]))
				mysql_query("delete from text_size where id='$_GET[del_txt_layout]'");
			if(isset($_POST[add_txt_size]))
				mysql_query("insert into text_size set layout_name='".htmlspecialchars($_POST[layout_name])."', width='$_POST[width]', height='$_POST[height]'");
				
			if(isset($_POST['update_img_size']))
				mysql_query("update image_size set layout_name='".htmlspecialchars($_POST[layout_name])."', width='$_POST[width]', height='$_POST[height]' where id='$_POST[id]'");
			if(isset($_GET[del_img_layout]))
				mysql_query("delete from image_size where id='$_GET[del_img_layout]'");
			if(isset($_POST[add_img_size]))
				mysql_query("insert into image_size set layout_name='".htmlspecialchars($_POST[layout_name])."', width='$_POST[width]', height='$_POST[height]'");

			if(isset($_POST['update_vdo_size']))
				mysql_query("update video_size set layout_name='".htmlspecialchars($_POST[layout_name])."', width='$_POST[width]', height='$_POST[height]' where id='$_POST[id]'");
			if(isset($_GET[del_vdo_layout]))
				mysql_query("delete from video_size where id='$_GET[del_vdo_layout]'");
			if(isset($_POST[add_vdo_size]))
				mysql_query("insert into video_size set layout_name='".htmlspecialchars($_POST[layout_name])."', width='$_POST[width]', height='$_POST[height]'");
				
			if(isset($_GET[del_txt_len]))
				mysql_query("delete from textad where id='$_GET[del_txt_len]' ");
			if(isset($_GET[del_img_len]))
				mysql_query("delete from imagead where id='$_GET[del_img_len]' ");	
			if(isset($_GET[del_vdo_len]))
				mysql_query("delete from videoad where id='$_GET[del_vdo_len]' ");		
				
			if(isset($_POST[add_txt_len]))
				mysql_query("insert into textad set length='$_POST[len]' ");
			if(isset($_POST[add_img_len]))
				mysql_query("insert into imagead set length='$_POST[len]' ");	
			if(isset($_POST[add_vdo_len]))
				mysql_query("insert into videoad set length='$_POST[len]' ");
					
			if(isset($_GET[size])) {
				$smarty->assign('txt_layouts', get_list('text_size', 'id'));
				$smarty->assign('img_layouts', get_list('image_size', 'id'));
				$smarty->assign('vdo_layouts', get_list('video_size', 'id'));
				
				$smarty->assign('txt_len', get_list('textad', 'length'));
				$smarty->assign('img_len', get_list('imagead', 'length'));
				$smarty->assign('vdo_len', get_list('videoad', 'length'));
				}
			
			/////////////////////	
	
				
			if(isset($_GET['stat'])) {
				$smarty->assign('ad_sold_today', mysql_result(mysql_query("select count(*) from advertisersinfo where buying_date = curdate() and (is_paid='Y' or is_paid='A') and is_auth='Y'"),0,0) );
				$smarty->assign('ad_sold_today_value', mysql_result(mysql_query("select round(tmp1.totalprice+tmp2.totalppc,2) as Total from  (select sum(price) as totalprice from advertisersinfo where ppc_balance=0 and buying_date = curdate() and (is_paid='Y' or is_paid='A') and is_auth='Y') as tmp1, (select sum(ppc_balance) as totalppc from advertisersinfo where buying_date = curdate() and (is_paid='Y' or is_paid='A') and is_auth='Y') as tmp2"),0,0) );
				$smarty->assign('ad_sold_week', mysql_result(mysql_query("select count(*) from advertisersinfo where weekofyear(buying_date) = weekofyear(curdate()) and year(buying_date)=year(curdate()) and (is_paid='Y' or is_paid='A') and is_auth='Y'"),0,0) );
				$smarty->assign('ad_sold_week_value', mysql_result(mysql_query("select round(tmp1.totalprice+tmp2.totalppc,2) as Total from  (select sum(price) as totalprice from advertisersinfo where ppc_balance=0 and weekofyear(buying_date) = weekofyear(curdate()) and year(buying_date)=year(curdate()) and (is_paid='Y' or is_paid='A') and is_auth='Y') as tmp1, (select sum(ppc_balance) as totalppc from advertisersinfo where weekofyear(buying_date) = weekofyear(curdate()) and year(buying_date)=year(curdate()) and (is_paid='Y' or is_paid='A') and is_auth='Y') as tmp2"),0,0) );
				$smarty->assign('total_ads', mysql_result(mysql_query("select count(*) from advertisersinfo where end_date>=curdate() and approved='Y' and is_paid='Y' and is_auth='Y'"),0,0) );
				$smarty->assign('total_clicks', mysql_result(mysql_query("select count(*) from hits where date=curdate() and is_click=1"),0,0) );
				$smarty->assign('total_users', mysql_result(mysql_query("select count(*) from users "),0,0) );
				$smarty->assign('total_newsletter_users', mysql_result(mysql_query("select count(*) from users where getnewsletter='Y'"),0,0) );
				$smarty->assign('unique_users', mysql_result(mysql_query("select count(distinct ip) from adquick_hits where date=curdate()"),0,0) );
				$smarty->assign('earning_today', mysql_result(mysql_query("select round(sum(earning),2) from admin_earnings where date=curdate()"),0,0) );
				$smarty->assign('earning_week', mysql_result(mysql_query("select round(sum(earning),2) from admin_earnings where weekofyear(date) = weekofyear(curdate()) and year(date)=year(curdate()) "),0,0) );
				$smarty->assign('earning_month', mysql_result(mysql_query("select round(sum(earning),2) from admin_earnings where month(date) = month(curdate()) and year(date)=year(curdate()) "),0,0) );
			}
			
			if(isset($_GET[send_id]) && isset($_GET[amount])) {
					$amount = $_GET[amount];
					mysql_query("update users set last_money_sent = curdate(), balance = ( balance - $amount ) where uid='$_GET[send_id]'");
			}
			if(isset($_GET[money])) {
					$r = mysql_query("select * from users where balance >= '$_config[min_pub_payout]'  and utype='pub+adv'");
					$index = 0;
					while ($row = mysql_fetch_assoc($r)) {
						if($row[balance] >= $_config[min_pub_payout] ) {
							$c[$index][status] = 'not_sent';
							$c[$index][amount] = $row[balance];
							}
						else {
							$c[$index][status] = 'sent';
							$c[$index][amount] = 0;
							}
						
						$c[$index][company] = $row[company];
						$c[$index][balance] = $row[balance];
						$c[$index][uid] = $row[uid];
						$c[$index][address] = $row[address];
						$c[$index][city] = $row[city];
						$c[$index][state] = $row[state];
						$c[$index][country] = $row[country];						
						$c[$index][paymethod_id] = $row[paymethod_id];
						$c[$index][pay_info] = $row[paymethod_info];
						$index++;
					}
				$smarty->assign('money', $c);
				}
			
			if(isset($_POST[add_news])) {
				mysql_query("INSERT INTO users set getnewsletter = 'Y', email='$_POST[email]', username='$_POST[email]'");
				mysql_query("update users set getnewsletter = 'Y' where email='$_POST[email]'");
				}
				
			if(isset($_GET[del_email]))
				mysql_query("update users set getnewsletter = 'N' where uid='$_GET[del_email]'");			
			
			if(isset($_GET[news_mem])) {
				$r = mysql_query("select email, uid from users where getnewsletter = 'Y' ");
				$index = 0;
					while ($row = mysql_fetch_assoc($r)) {
							$c[$index][uid] = $row[uid];
							$c[$index][email] = $row[email];
					$index++;		
					}
				$smarty->assign('email', $c);
				}
				
				
			if(isset($_GET[view_sent])) {
				$r = mysql_query("select * from newsletter order by date desc, id desc");
				$index = 0;
					while ($row = mysql_fetch_assoc($r)) {
							$c[$index][id] = $row[id];
							$c[$index]['date'] = $row['date'];
					$index++;		
					}
				$smarty->assign('newsl', $c);
				}	
			
			if(isset($_GET[newsl_id]))
				$smarty->assign('news', mysql_fetch_assoc(mysql_query("select * from newsletter where id='$_GET[newsl_id]' ")) );
				
				
			if(isset($_POST[send_emails]))	{
				$r = mysql_query("select email, username from users where getnewsletter = 'Y' ");
					while ($row = mysql_fetch_assoc($r)) {
						// multiple recipients
						$to  = $row[email]; // note the comma
						//$to .= 'wez@example.com';
						
						// subject
						$subject = stripslashes($_POST[sub]);
						
						// message
						$message = nl2br(stripslashes($_POST[body]));
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						
						// Additional headers
						$headers .= "To: $row[username] <$row[email]>" . "\r\n";
						$headers .= "From: $_config[website_name] <$_config[admin_email]>" . "\r\n";
						//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
						//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
						
						// Mail it
						mail($to, $subject, $message, $headers);

					}
					$t = mysql_num_rows($r);
				mysql_query("insert into newsletter set sub='".htmlspecialchars($_POST[sub])."', body='".htmlspecialchars($_POST[body])."', date=curdate(), total=$t");	
				header("location: ../admin/?view_sent");
				exit();
			}
			
			if(isset($_GET[featured])) {
				$r1 = mysql_query("select * from featured where is_paid='Y' and is_auth='Y' and status='Y' and (start <= curdate() and end>=curdate()) or (buying_date = '0000-00-00' and start <= curdate() and end>=curdate())");
				$c = array();
					while($row = mysql_fetch_assoc($r1))
						$c[] = array('fid' => $row[fid], 'company' => $row[wname], 'sdate' => $row[start], 'edate' => $row['end'], 'length' => $row[length]);
					$smarty->assign('cf', $c);
					
				$r2 = mysql_query("select * from featured where is_paid='Y' and is_auth='Y' and status='Y' and (start > curdate()) or (buying_date = '0000-00-00' and start > curdate() ) ");
				$w = array();
					while($row = mysql_fetch_assoc($r2))
						$w[] = array('fid' => $row[fid], 'company' => $row[wname], 'sdate' => $row[start], 'edate' => $row['end'], 'length' => $row[length]);
					$smarty->assign('wf', $w);
					
				$r3 = mysql_query("select * from featured where is_paid='Y' and is_auth='Y' and status<>'Y' ");
					$a = array();
					while($row = mysql_fetch_assoc($r3))
						$a[] = array('fid' => $row[fid], 'company' => $row[wname], 'sdate' => $row[start], 'edate' => $row['end'], 'length' => $row[length]);
					$smarty->assign('af', $a);
					
			}
			
			$smarty->register_modifier("sslash", "stripslashes");
			
			if(isset($_GET[edit_fid]))
				$smarty->assign('ef', mysql_fetch_assoc(mysql_query("select * from featured where fid='$_GET[edit_fid]'")) );
				
				$smarty->assign('web_list', get_list('publishersinfo', 'pid') );

			
			if(isset($_GET[del_fid])) {
				$finfo = mysql_fetch_assoc(mysql_query("select * from featured where fid='$_GET[del_fid]' and is_paid='Y' and is_auth='Y' and end >= curdate() "));
				if ($finfo[buying_date] != '0000-00-00') {
					mysql_query("update users set balance = ( balance + $_config[featured_rate] ) where uid = '$finfo[uid]' ");
					
				$post = mysql_fetch_assoc(mysql_query("select * from users where uid = '$finfo[uid]' "));
				$to  = $post[email];				
				// subject
				$subject = 'Featured Retailer request Rejected';
									
									// message
					$message = "<html>
									<head>
									 <title>Featured Retailer request Rejected</title>
									</head>
									<body>
									Your request of Featured Retailer for the following website has been rejected,<br />
					<br />
					Website: $finfo[wname]<br />
					Cost: $_config[currency] $_config[featured_rate] <br />
					<br />
					<br />
					<br />
					Your account has now been credited with the amount, $_config[currency] $_config[featured_rate] <br />
					<br />
					You can now purchase any other ads upto the value you have just been credited with.<br />
					<br />
					You can manage all the ads you buy, by logging into your account at, <a href=$_config[www]>$_config[www]</a>
					<br />
					<br />
					Regards<br />
					<br />
					$_config[website_name]<br />
					$_config[www]<br />
									</body>
									</html>
									";
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= "To: $post[username]<$post[email]>" . "\r\n";
				$headers .= "From: $_config[website_name]<$_config[admin_email]>" . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);

				}
			mysql_query("delete from featured where fid = '$_GET[del_fid]' ");
			
			header("location: ../admin/?featured");
					exit();
		}
				
			if(isset($_POST[update_f])) {
				$sdate = $_POST[Date_Year].'-'.$_POST[Date_Month].'-'.$_POST[Date_Day];
				$length = $_POST[length];
				
				$uid = mysql_result(mysql_query("select uid from publishersinfo where pid = '$_POST[pid]' limit 1"),0,0);
				$post = mysql_fetch_assoc(mysql_query("select * from users where uid = '$uid' "));
				if(isset($_POST[free])) {
					mysql_query("insert into featured set uid = '$uid', wname='$_POST[wname]', pid='$_POST[pid]', length='$_POST[length]', des='$_POST[des]', start='$sdate', end=DATE_ADD('$sdate', INTERVAL $length MONTH), status='Y', is_paid='Y', is_auth='Y' ");
					$file_id = mysql_insert_id();
				$to  = $post[email];				
				// subject
				$subject = 'Free Featured Retailer Award!';
									
									// message
					$message = "
									<html>
									<head>
									 <title>Free Featured Retailer Award!</title>
									</head>
									<body>
									Hello,<br />
									One of your website is awarded as our featured retailer for $_POST[length] month. From  $sdate your site will appear on our home page randomly.
					<br />
					Website: $_POST[wname]<br />
					Starting Date: $sdate <br>
					Cost: Free! <br />
					<br />
					You can manage all the ads you buy, by logging into your account at, <a href=$_config[www]>$_config[www]</a>
					<br />
					<br />
					Regards<br />
					<br />
					$_config[website_name]<br />
					$_config[www]<br />
									</body>
									</html>
									";
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= "To: $post[username]<$post[email]>" . "\r\n";
				$headers .= "From: $_config[website_name]<$_config[admin_email]>" . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);
						
				}
				else {
					mysql_query("update featured set wname='$_POST[wname]', pid='$_POST[pid]', length='$_POST[length]', des='$_POST[des]', start='$sdate', end=DATE_ADD('$sdate', INTERVAL $length MONTH), status='Y' where fid='$_GET[edit_fid]' ");
					$file_id = $_GET[edit_fid];
				$to  = $post[email];				
				// subject
				$subject = 'Featured Retailer request accepted';
									
									// message
					$message = "<html>
									<head>
									 <title>Featured Retailer request accepted</title>
									</head>                                                           
									<body>
									<br />
									Your request for featured retailer for $_POST[length] month is accepted. From $sdate your site will appear on our home page randomly.
					<br />
					Website: $_POST[wname]<br />
					Starting date: $sdate<br>
					Cost: $_config[currency] $_config[featured_rate] <br />
					<br />
					You can manage all the ads you buy, by logging into your account at, <a href=$_config[www]>$_config[www]</a>
					<br />
					<br />
					Regards<br />
					<br />
					$_config[website_name]<br />
					$_config[www]<br />
									</body>
									</html>
									";
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= "To: $post[username]<$post[email]>" . "\r\n";
				$headers .= "From: $_config[website_name]<$_config[admin_email]>" . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);
				
				mysql_query("update admin_earnings set earning = '$_config[featured_rate]' , date = curdate()");						
					}
					
				if(is_uploaded_file($_FILES['logo']['tmp_name'])) {
					$f = '../featured_logos/featured_'.$file_id.'.jpg';
					@unlink ($f);
					move_uploaded_file($_FILES['logo']['tmp_name'], $f);
					}
					header("location: ../admin/?featured");
					exit();
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
				
			if(isset($_GET[acc])) {
				
				$r = mysql_query("select * from users order by uid desc");
				$c = array();
					while ($row = mysql_fetch_assoc($r)) {
							$c[] = array('uid' => $row[uid], 'status' => $row[status] , 'uname' => $row[username], 'email' => $row[email], 'signup' => $row[signup_date], 'last' => $row[last_login]);
					}
				$smarty->assign('acc', $c);
			}
			
			if(isset($_POST[credit_acc])) {
				mysql_query("update users set balance = balance + $_POST[amount] where uid='$_POST[uid]'");
				$msg = "The account is Successfully credited";
			}
			if(isset($_GET[credit])) {
				
				$r = mysql_query("select * from users order by uid desc");
				$c = array();
					while ($row = mysql_fetch_assoc($r)) {
							$tmp = $row[uid];
							$c[$tmp] = $row[username].' ('.$_config[currency].$row[balance].')';
					}
				$smarty->assign('u_acc', $c);
			}
			
			if(isset($_POST[change_pass])) {
				$o_pass = mysql_result(mysql_query("select pass from admin"),0,0);
				if($o_pass != $_POST[old_pass])
					$msg = 'Wrong Old Password!';
				else {
					$name = (trim($_POST[name])=="") ? $_SESSION[admin_username] : trim($_POST[name]);
					$pss = ($_POST[new_pass]=="") ? $o_pass : $_POST[new_pass];
					if(mysql_query("update admin set pass = '".md5($pss)."', user='$name'")) {
						$_SESSION[admin_username] = $name;
						$msg = 'New Admin User/Password set successfully.';
					}
				}				
			}

			if(isset($_POST[update_config])) {
				
				if ($handle = opendir('../templates_c/')) {
				   while (false !== ($file = readdir($handle))) {
					   if ($file != "." && $file != "..") {
						   @unlink('../templates_c/'.$file);
					   }
				   }
				   closedir($handle);
				}	
				
				foreach($_POST as $key => $val)
					@mysql_query("update configurations set value='".mysql_real_escape_string($val)."' where name='$key'");
					if($_POST[currency] == '&pound;' || $_POST[currency] == '£') {
						mysql_query("update configurations set value='GBP' where name='CURRENCY_CODE' ");
						mysql_query("update configurations set value='&pound;' where name='currency' ");
						}
					if($_POST[currency] == '$')
						mysql_query("update configurations set value='USD' where name='CURRENCY_CODE' ");
					if($_POST[currency] == '&#8364;' || $_POST[currency] == '€') {
						mysql_query("update configurations set value='EUR' where name='CURRENCY_CODE' ");
						mysql_query("update configurations set value='&#8364;' where name='currency' ");
						}
				header("location: ../admin/?pref");	
				exit();
			}

			
			
			if(isset($_GET[pref])) {
			$lang_files = array();
				if ($handle = opendir('../include/lang/')) {
				   while (false !== ($file = readdir($handle))) {
					   if ($file != "." && $file != "..") {
						   $lang_files[] = substr($file, 0, -4);
					   }
				   }
				   closedir($handle);
				}				
				$smarty->assign('lang_files', $lang_files);
				
				
			$tpl_folders = array();
				if ($handle = opendir('../templates/')) {
				   while (false !== ($file = readdir($handle))) {
					   if ($file != "." && $file != "..") {
						   $tpl_folders[] = $file;
					   }
				   }
				   closedir($handle);
				}				
				$smarty->assign('tpls', $tpl_folders);

			}
			

$tu = mysql_result(mysql_query("select count(*) from users"),0,0);
$smarty->assign('tu', $tu);
$smarty->assign('msg', $msg);

$content = $smarty->fetch('index.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>