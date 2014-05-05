<?php
function mailTemplates($to_email='', $to_username='', $type='', $utype='', $publisher_arr = array(), $adv_arr=array(), $user_arr=array() ){
global $_config;
	  if($type=='register'){
	  if($utype=='pub'){
	  $subject = 'Đăng ký tài khoản thành công!!!';
      $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
   <p><u>$_config[www]</u> <br />
  Xin chào <strong> $to_username </strong>, 
  <br />
  <br /> Cảm ơn bạn đã đăng ký trở thành Publisher của Textlink.vn. Kể từ bây giờ bạn có thể kiếm tiền dễ dàng với Website của bạn, Để bắt đầu bạn hãy <a href="$_config[www]/publishers.php?step=1">vào đây</a> để đăng ký website và cài đặt code quảng cáo cho nó. <br />
  Bạn thể tham khảo các câu hỏi thường gặp tại FAQs&nbsp;<a href="$_config[www]/faq/" target="_blank">here.</a>  <br />
  Hãy &nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">cài đặt code</a>&nbsp; ngay hôm nay dể kiếm tiền từ chính website của bạn!<br />
  <br />
  Chúng tôi rất vui lòng được hợp tác với bạn. Mọi thắc mắc xin hãy liên hệ với chúng tôi. <br />
  <br />
  Thông tin liên lạc<br />
  <u>support@textlink.vn</u> <br />
  <u>http://textlink.vn</u> <br />
  Tầng 15, tòa nhà Charmvit Tower&nbsp;|117 Trần Duy Hưng, Hà Nội | &nbsp; (04).62698999 | &nbsp;&nbsp;<u><a href="$_config[www]">Textlink.vn</a></u> <br />
  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($utype=='adv'){
 $subject = 'Đăng ký tài khoản thành công';
$message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">Xin Chào <strong> $to_username </strong>,
<br />
<br />Cảm ơn bạn đã đăng ký trở thành Advertiser của Textlink.vn. Với một Marketplace bao gồm rất nhiều website chất lượng, Textlink sẽ đem đến cho bạn cơ hội để xây dựng liên kết chất lượng cao, cải thiện thứ hạng từ khóa và mang lại lượng truy cập lớn cho website của bạn..:&nbsp;<br />
<br />
Quảng cáo Text Link - là hình thức quảng cáo phổ biến thường xuất hiện ở bên trái hay bên phải hoặc ở dưới chân trang trên các website .&nbsp;<br />
<br />
<strong>Lưu ý:</strong>&nbsp; Sau khi đặt quảng cáo Text Link, thường thì mất khoảng một đến ba tháng để thấy được hiệu quả của nó bởi vì các công cụ tìm kiếm cần thời gian để tính toán và đánh giá lại chất lượng link.&nbsp;<br />
<br />
Textlink rất mong muốn được đóng góp vào thành công của khách hàng! Mọi thắc xin vui lòng liên hệ với chúng tôi.&nbsp;<br />
<br />
 Thông Tin Liên Lạc <br />
  <u>support@textlink.vn</u> <br />
  <u>http://textlink.vn</u> <br />
  Tầng 15, Tòa nhà Charmvit Tower &nbsp;| &nbsp; 117 Trần Duy Hưng, Hà Nội | &nbsp; (04).62698999 | &nbsp;&nbsp;<u><a href="$_config[www]">Textlink.vn</a></u> <br />
  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($utype=='pub+adv'){
}
}elseif($type=='publisher_add_site'){// add more site action
	  $subject = 'Submit Website thành công!';
      $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
  <p><strong>Website của bạn đã được submit thành công!</strong><br>
		  Xin Chào <strong>$to_username</strong>,<br>
		  <br>
		  Chúc mừng website:&nbsp;<a href="$publisher_arr[url]" target="_blank">$publisher_arr[url]</a> của bạn đã được submit thành công.<br>
		  <br>
		  Ngay bây giờ bạn có thể &nbsp;<a href="http://textlink.vn/publishers.php?pid=$publisher_arr[pid]&do=edit" target="_blank">vào đây</a>&nbsp;page để chỉnh sửa thông tin và tải mã code quảng cáo.</p> <br>
		 <strong>Chú ý rằng:</strong> </p><br>
		<ul>
		  <li>Để website của bạn luôn xuất hiện trên marketplace của chúng tôi, bạn phải cài đặt và duy trì code trên website của ban (Cài đặt code của textlink.vn không ảnh hưởng gì tới wesbite và quảng cáo chỉ hiện khi advertiser order link quảng cáo trên site của bạn).</li>
		  <li>Sau khi submit website thành công bạn có thể chỉnh sửa và cập nhật thông tin cho nó ở đây: at&nbsp;<a href="http://textlink.vn/publishers.php?step=1" target="_blank">$_config[www]/r/publisher/list_sites</a> </li>
		</ul>
		<p><br>
		  Hãy&nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">cài đặt code</a>&nbsp;ngày bây giờ để kiếm tiềm với hệ thống hoàn toàn tự động của chúng tôi. Lưu ý rằng vị trí bạn đặt link quảng có có thể ảnh hưởng tới giá cả và sự hấp đẫn của link đối với Advertiser.&nbsp; <br>
		  <br>
		  Sau khi bạn cài đặt code, Textlink sẽ xem xét và định giá website của bạn với mức giá hài lòng nhất. Doanh thu hàng tháng sẽ được tự động chuyển vào tài khoản Publisher ngay sau khi một order kết thúc thành công. Bạn có thể &nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">truy cập vào tài khoản</a>&nbsp;bất kỳ thời gian nào để xem xét doanh thu.<br>
		  <br>
		  <strong>Thông Tin liên lạc<strong><br>
		  <strong>$_config[www]</strong><br>
		  <u>support@textlink.vn</u> <br>
		  <u>http://www.textlink.vn</u> <br>
		  Tầng 15, Tòa nhà Charmvit Tower | 117 Trần Duy Hưng, Hà Nội | &nbsp; &lt;(04).62698999&gt; | &nbsp;<a href="$_config[www]/" target="_blank">Textlink.vn</a> <br>
		  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($type=='cancel'){//cancel action
	if($utype=='pub'){
		 $subject = 'Hủy Đơn Đặt Hàng Quảng Cáo';
	}elseif($utype=='adv'){
		$subject = 'Hủy Đơn Đặt Hàng Quảng Cáo';
	}
$message = <<<EOF
<html>
  <body bgcolor="#DCEEFC"><p>Xin Chào <strong>$to_username</strong><br />
    <br />
  Chúng tôi gửi mail để thông báo rằng bạn vừa mới gửi yêu cầu huy bỏ đơn hàng with &lt;&lt; <strong>$publisher_arr[pid]</strong>&gt;&gt;&gt;<br />
  Nếu đây là lỗi thì hay click<a href="$_config[www]/marketplace/">vào đây</a> để đặt mua lại link quảng cáo. Chúng tôi luôn sẵn lòng phục vụ bạn!.<br />
  Nếu bạn không hài lòng với bất kỳ dịch vụ nào của Text link, Vui lòng xin liên hệ với chúng tôi để có giải pháp tốt nhất. Textlink đem đến cho bạn rất nhiều <a href="$_config[www]/marketplace">sự lựa chọn!</a><br />
  <br />
  Rất cảm ơn bạn đã quan tâm tới sản phẩm của Textlink!<br />
  <br />
  Thông tin hỗ trợ <br />
  <strong>Textlink.vn</strong><br />
  <u>support@textlink.vn</u> <br />
  <a href="$_config[www]">$_config[www]</a><u> </u><br />
  Tầng 15, Tòa nhà Charmvit Tower &nbsp;| 117 Trần Duy Hưng, Cầu Giấy, Hà Nội |&nbsp;04.62698999 |&nbsp;<a href="$_config[www]" target="_blank">Textlink.vn</a> <br />
  &copy; 2012 Textlink.vn.  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($type=='order'){	
	$subject = $_config[www].' Order confirmation';	
	include_once('../../classes/class_user.php'); 
	$cls_user = new User();	
	
	$content = ''; $conten_to_publisher = array(); $pub_email=''; $email_pub_info = array(); $user_info = array(); $pub_info_arr = array();
	
	$conten_to_publisher[$pub_email]='';
	foreach($adv_arr as $key=>$adv){
	
	$user_info = $cls_user->getUserInfo($adv[pub_uid]);
	$pub_email = $user_info[email];
	
	if($pub_email){
		$email_pub_info[$pub_email] .='<li>'.$adv[ad_before].' <a href="'.$adv[url].'">'.$adv[ad_des].'</a> '.$adv[ad_after].'</li>';
		$pub_info_arr[$pub_email] = array('username'=>$user_info[username],'url'=>$adv[pub_url]);
	}
  
	$conten_to_publisher[$pub_email] .='<strong>Nội dung trước link:</strong> '.$adv[ad_before].'<br />
	<strong>Nội dung sau link: </strong> '.$adv[ad_after].'<br />
	<strong>Từ khóa:</strong> '.$adv[ad_des].'<br />
	<strong>Link URL:</strong> '.$adv[url].'<br />
	<strong>Cần đặt trên website:</strong> '.$adv[pub_url].'<br />
	<strong>Thời hạn: </strong> '.$adv[end_date].'</p>';

	$content .='<tr>
    <td><strong>Website URL:</strong></td>
    <td><a href="'.$adv[pub_url].'" target="_blank">'.$adv[pub_url].'</a></td>
  </tr>
  <tr>
    <td><strong>Link Text:</strong></td>
    <td>'.$adv[ad_des].'</td>
  </tr>
  <tr>
    <td><strong>Link URL:</strong> </td>
    <td><a href="'.$adv[url].'" target="_blank">'.$adv[url].'</a></td>
  </tr>
   <tr>
    <td><strong>Ad lenght:</strong> </td>
    <td>'.$user_arr[length].' days text ads</td>
  </tr>
  <tr>
    <td><strong>Status:</strong> </td>
    <td>Placed</td>
  </tr>
  <tr>
    <td><strong>Price:</strong></td>
    <td>$'.$adv[price].'/mo</td>
  </tr>
  <tr height="10">
    <td></td>
    <td></td>
  </tr>';  
  }
$message = <<<EOF
<html>
  <body bgcolor="#DCEEFC"><p>Xin Chào,<br />
  <br />
  Cảm ơn bạn đã đặt mua link trên Textlink.vn! Chúng tôi rất vui lòng được giải đáp các thắc mắc của bạn về các dịch vụ của Textlink. Hãy <a href="mailto:$_config[admin_email]">liên hệ với cúng tôi</a> nếu bạn có bất kỳ câu hỏi nào! Sau đây là thông tin chi tiết về đơn đặt hàng của bạn:<br />
  <strong>Order $user_arr[order_id]</strong><br />
  <strong>Tên:<strong> $to_username<br />
  <strong>Địa Chỉ:<strong> $user_arr[address]<br />
  <strong>Thành Phố:<strong> $user_arr[city]</p>
<table border="0" cellspacing="0" cellpadding="0"> 
  $content
  <tr>
    <td></td>
    <td></td>
  </tr>  
  <tr>
    <td><strong>DISCOUNT:</strong></td>
    <td>-USD $user_arr[discount]</td>
  </tr>
  <tr>
    <td><strong>INITIAL TOTAL</strong><br />
      (After Discounts):</td>
    <td>USD $user_arr[total_price]</td>
  </tr>
</table>
<p><strong>Lưu ý rằng: &nbsp;</strong>Bạn chỉ có thể hủy bỏ đơn hàng trong vòng một ngày kể từ lúc đặt mua link thành công.<br />
 <br />
  Xin chân thành cảm ơn!<br />
  <br />
  <strong>Textlink.vn</strong><br />
  <u>support@textlink.vn</u> <br />
  <a href="http://www.textlink.vn">http://www.textlink.vn</a><u> </u><br />
  Tầng 15, Tòa nhà Chamvit Tower | 117 Trần Duy Hưng, Cầu Giấy, Hà Nội |&nbsp;04.62698999 |&nbsp;<a href="$_config[www]/" target="_blank">Textlink.vn</a> <br />
  &copy; 2012 Textlink.vn.  All rights reserved.</p>
  </body>
</html>
EOF;

if(is_array($email_pub_info)){
	foreach($email_pub_info as $pub_mail=>$text){
	$pub_user = $pub_info_arr[$pub_mail][username];	
	$pub_url = $pub_info_arr[$pub_mail][url];
	
$subject_pub = 'Đơn đặt hàng của Advertiser.';
if($adv[is_manual]=='Y')
$mes_to_publisher[$pub_mail] = 'Chúng tôi nhận được yêu cầu đặt link quảng cáo trên website của bạn từ Advertiser. Bởi vì bạn chọn đặt link bằng tay, nên hãy copy đoạn code html <br>
  <textarea rows="6" cols="50"><ul>'.$text.'</ul></textarea>  
  <br />
  to '.$pub_url.' (sites/blogs) và bắt đầu kiếm tiền từ chính website của bạn.<br />
  <br />Lưu ý rằng: Bạn phải duy trì link quảng cáo trên website của bạn đúng như đơn đặt hàng, TextLink chỉ đồng ý thanh toán cho Publisher khi mà order kết thúc thành công!>
  <br />';
 else $mes_to_publisher[$pub_mail] = 'Chúng tôi vừa nhận nhu cầu đặt link trên Website từ phía Advertiser.  Thông tin chi tiết về link: </p>
<p><br />
 '.$conten_to_publisher[$pub_mail].'
<p><br />
  <strong>Chú ý: </strong><br />
&nbsp; &nbsp; &bull; Bạn phải duy trì link quảng cáo trên website cho tới ngày đáo hạn.<br />
&nbsp; &nbsp; &bull; Doanh thu từ việc đặt link trên website sẽ được tự động chuyển vào tài khoản Publisher sau khi order kết thúc thành công.<br />
&nbsp; &nbsp; &bull; Nếu bạn tự ý gỡ bỏ link trên website khi chưa tới ngày đáo hạn mà không có sự đồng ý của Textlink, thì mọi doanh thu từ việc đặt link đó sẽ bị hủy bỏ. <br />
&nbsp; &nbsp;  &bull; Nếu bạn có bất kỳ câu hỏi, thắc mắc nào, xin vui lòng liên hệ với chúng tôi!<br />
</p>';
$message_pub = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
   <p><u>$_config[www]</u> <br />
  Xin chào <strong> $pub_user </strong>,<br />
  <br />
 $mes_to_publisher[$pub_mail]
  </p>
  Textlink.vn Publisher  Support<br />
  <u>support@textlink.vn</u> <br />
  <u>http://textlink.vn</u> <br />
  Tầng 15, Tòa nhà Charmvit Tower | &nbsp; 117 Trần Duy Hưng, Cầu Giấy, Hà Nội | &nbsp; (04).62698999 | &nbsp;&nbsp;<u><a href="$_config[www]">Textlink.vn</a></u> <br />
  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
$headers  = "From: TextLink.vn <noreply@textlink.vn>\r\n"; 
$headers .= 'Content-type: text/html; charset=utf-8' . '';
$headers .= '' . 'To: ' . $username_arr[$pub_mail] . '<' . $pub_mail . '>' . '';
//$headers .= '' . 'From: TextLink.vn <noreply@textlink.vn>' . '';
mail($pub_mail, $subject_pub, $message_pub, $headers);
		}
	}
}
/*$headers = 'MIME-Version: 1.0' . '';*/
$headers  = "From: TextLink.vn <noreply@textlink.vn>\r\n"; 
$headers .= 'Content-type: text/html; charset=utf-8' . '';
$headers .= '' . 'To: ' . $to_username . '<' . $to_email . '>' . '';
//$headers .= '' . 'From: TextLink.vn <noreply@textlink.vn>' . '';
mail($to_email, $subject, $message, $headers);

//sendMail($to,$subject,$message);
logFile($message);
return true;  
}
?>
