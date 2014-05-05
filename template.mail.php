<?php
function mailTemplates($to_email='', $to_username='', $type='', $utype='', $publisher_arr = array(), $adv_arr=array(), $user_arr=array() ){
global $_config;
	  if($type=='register'){
	  if($utype=='pub'){
	  $subject = 'New Account Registration';
      $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
   <p><u>$_config[www]</u> <br />
  Dear <strong> $to_username </strong>, thanks for  signing up to be a Textlink.vn publisher. You are on the fast track to making  more money with your website! To get started you need to submit your website  and get our ad code installed. You can do that&nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">here</a>. ( <strong>publisher  new site &ndash; info of publisher&rsquo;s site</strong>)<br />
  You can find our  publisher FAQs&nbsp;<a href="$_config[www]/faq/" target="_blank">here.</a> ( <strong>link to FAQs of Publisher</strong>) <br />
  So get started by&nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">installing our ad code  now</a>&nbsp;and we look forward to  servicing you as a Textlink.vn publisher!<br />
  Textlink.vn Publisher  Support<br />
  <u>support@textlink.vn</u> <br />
  <u>http://textlink.vn</u> <br />
  117 Tran Duy Hung&nbsp; Street &nbsp; | &nbsp; 17th Floor Charmvit  Tower&nbsp; | &nbsp; Hanoi | &nbsp; (04).62698999 | &nbsp;&nbsp;<u><a href="$_config[www]">Textlink.vn</a></u> <br />
  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($utype=='adv'){
 $subject = 'New Account Registration';
$message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">Dear <strong> $to_username </strong>,  thank you for signing up with Textlink.vn. Our marketplace allows you to  purchase relevant links that are designed to increase your website's link  popularity and ultimately your organic search engine rankings. Here is our core  product:&nbsp;<br />
<br />
Standard Text link ads - these advertisements generally typically appear in the  left or right margins of a webpage.&nbsp;<br />
<br />
<strong>Timeline for success.</strong>&nbsp;After purchasing your text  link ads please note that it can take up for three months to see results. Many  times results come much quicker but the reason it can take time is because the  search engines need to find the newly placed links and then recalculate  rankings based on the new data. In addition search engines value links that  have been &quot;aged&quot; or been in place for a longer period of time, more  than very recently placed links. So please note that we have many clients that  don't see the natural search engine rankings boost they were looking for until  three months into the program but we hope you will see a bump much sooner.&nbsp;<br />
<br />
Thanks again and we look forward to serving you as a successful Textlink.vn  client soon! Please feel free to reach out to me with any questions you may  have.&nbsp;<br />
 Textlink.vn Publisher  Support<br />
  <u>support@textlink.vn</u> <br />
  <u>http://textlink.vn</u> <br />
  117 Tran Duy Hung&nbsp; Street &nbsp; | &nbsp; 17th Floor Charmvit  Tower&nbsp; | &nbsp; Hanoi | &nbsp; (04).62698999 | &nbsp;&nbsp;<u><a href="$_config[www]">Textlink.vn</a></u> <br />
  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($utype=='pub+adv'){
}
}elseif($type=='publisher_add_site'){// add more site action
	  $subject = 'Your inventory was accepted!';
      $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
  <p><strong>Your inventory was accepted!</strong><br>
		  Hello <strong>$to_username</strong>,<br>
		  <br>
		  Your site&nbsp;<a href="$publisher_arr[url]" target="_blank">$publisher_arr[url]</a> has been accepted.<br>
		  <br>
		  The implementation instructions can be found by logging into the&nbsp;<a href="http://textlink.vn/publishers.php?pid=$publisher_arr[pid]&do=edit" target="_blank">Install Ad Code</a>&nbsp;page. Once there, simply click on the  &quot;Get Ad Code&quot; link next to your url and you will be walked through a  simple ad code wizard.&nbsp;<strong>Please note:</strong> </p>
		<ul>
		  <li>You must keep our  script installed for your site to remain in our marketplace.</li>
		  <li>To make any changes to  your listing you can edit their listing at&nbsp;<a href="http://textlink.vn/publishers.php?step=1" target="_blank">$_config[www]/r/publisher/list_sites</a> </li>
		</ul>
		<p><br>
		  Please&nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">install the ad script</a>&nbsp;now to start making money. Remember placing  our ad in a prominent space on your website will result in more sales and a  better renewal rate from our advertisers!&nbsp; <br>
		  Please note the price  we will be selling advertisements off this page <a href="$publisher_arr[url]" target="_blank">$post[url]</a>,&nbsp;is what we feel is market value. What that  being said, if you are unhappy with this price you can email us or change it  within your account. Inventory is priced AFTER you install the ad code/script.<br>
		  Your payment will be  sent to you the 1st of every month. You can&nbsp;<a href="$_config[www]/publishers.php?step=1" target="_blank">login to your account</a>&nbsp;at any time to monitor earnings.<br>
		  <br>
		  <br>
		  <strong>$_config[www]</strong><br>
		  <u>support@textlink.vn</u> <br>
		  <u>http://www.textlink.vn</u> <br>
		  177 Tran Duy Hung  Street | &nbsp; 15th Floor CharmVit Tower &nbsp; | &nbsp; Hanoi&nbsp; | &nbsp; &lt;SDT&gt; | &nbsp;<a href="$_config[www]/" target="_blank">Tetlink.vn</a> <br>
		  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($type=='cancel'){//cancel action
	if($utype=='pub'){
		 $subject = 'Cancel our service of advertiser';
	}elseif($utype=='adv'){
		$subject = 'Cancel our service of publisher';
	}
$message = <<<EOF
<html>
  <body bgcolor="#DCEEFC"><p>Hello <strong>$to_username</strong><br />
    <br />
  we are sending you this e-mail to announce that you just request the  cancellation of our service on Textlink.vn with &lt;&lt; <strong>$publisher_arr[pid]</strong>&gt;&gt;&gt;<br />
  If this is error, please click <a href="$_config[www]/marketplace/">here</a> to repurchase our service. We  are always ready to serve you.<br />
  If you don&rsquo;t satisfy with anything, please don&rsquo;t hesitate to contact us in  order to have an appreciate solution. There are various other choices for you <a href="$_config[www]/marketplace">here</a><br />
  Thank you for your prompt attention to our services!<br />
  <br />
  <strong>Textlink.vn</strong><br />
  <u>support@textlink.vn</u> <br />
  <a href="$_config[www]">$_config[www]</a><u> </u><br />
  117 Tran Duy Hung  Street | &nbsp; 15th Floor CharmVit Tower | Hanoi |&nbsp;04.62698999 |&nbsp;<a href="$_config[www]" target="_blank">Tetlink.vn</a> <br />
  &copy; 2012 Textlink.vn.  All rights reserved.</p>
  </body>
</html>
EOF;
}elseif($type=='order'){
	$subject = $_config[www].' Order confirmation';
	$content = '';
	foreach($adv_arr as $key=>$val){
	$content ='<tr>
    <td><strong>Website URL:</strong></td>
    <td><a href="'.$val[pub_url].'" target="_blank">'.$val[pub_url].'</a></td>
  </tr>
  <tr>
    <td><strong>Link Text:</strong></td>
    <td>'.$val[ad_des].'</td>
  </tr>
  <tr>
    <td><strong>Link URL:</strong> </td>
    <td><a href="'.$val[url].'" target="_blank">'.$val[url].'</a></td>
  </tr>
  <tr>
    <td><strong>Status:</strong> </td>
    <td>Placed</td>
  </tr>
  <tr>
    <td><strong>Price:</strong></td>
    <td>$'.$val[price].'/mo</td>
  </tr>';
  }
$message = <<<EOF
<html>
  <body bgcolor="#DCEEFC"><p>Hi,<br />
  Thank you for your recent order!  Please feel free to <a href="mailto:$_config[admin_email]">contact</a> us regarding your order with any  questions you may have. We look forward to working with you and helping you  achieve your online goals!<br />
  <strong>Order $user_arr[order_id]</strong><br />
  $to_username<br />
  $user_arr[address]<br />
  $user_arr[city]</p>
<table border="1" cellspacing="0" cellpadding="0"> 
  $content
  <tr>
    <td></td>
    <td></td>
  </tr>  
  <tr>
    <td><strong>DISCOUNT:</strong></td>
    <td>-$$user_arr[discount]</td>
  </tr>
  <tr>
    <td><strong>INITIAL TOTAL</strong><br />
      (After Discounts):</td>
    <td>$$user_arr[total_price]</td>
  </tr>
</table>
<p><strong>Please note: &nbsp;</strong>you can only cancel your order within one  working day from when the order is successful.<br />
  Thank you!<br />
  <strong>Textlink.vn</strong><br />
  <u>support@textlink.vn</u> <br />
  <a href="http://www.textlink.vn">http://www.textlink.vn</a><u> </u><br />
  117 Tran Duy Hung Street  | &nbsp; 15th Floor CharmVit Tower | Hanoi |&nbsp;04.62698999 |&nbsp;<a href="http://www.text-link-ads.com/" target="_blank">Tetlink.vn</a> <br />
  &copy; 2012 Textlink.vn.  All rights reserved.</p>
  </body>
</html>
EOF;
}
/*$headers = 'MIME-Version: 1.0' . '';*/
$headers .= 'Content-type: text/html; charset=utf-8' . '';
$headers .= '' . 'To: ' . $to_username . '<' . $to_email . '>' . '';
$headers .= '' . 'From: ' . $_config['website_name'] . '<' . $_config['admin_email'] . '>' . '';
mail($to_email, $subject, $message, $headers);

//sendMail($to,$subject,$message);
logFile($message);
return true;  
}
?>
