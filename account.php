<?php
include ("include/config.php");
include_once("global.php");
$msg = "";
$smarty->assign('cls_user', $cls_user);
require('classes/class_country.php'); $cls_country = new Country(); $smarty->assign('cls_country', $cls_country);

		$lightbox=$_GET[lightbox];
			if(isset($_GET[warning_msg]))
				$msg  = 'Your account will be activated upon admin approval.';
			if(isset($_GET[warning_msg_www]))
				$msg  = 'Your website will be live on this site upon admin approval.';
			
			if(isset($_POST[login])){
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$u_stat = login(trim($_POST[username]), $_POST[pass]);
					if ($u_stat == 'suspended') 
						$msg = 'Your account is suspended. Please contact with the admin.';
					elseif ($u_stat == 'ok') {
						if($_POST[red_url]!="")
							header("location: ".$_POST[red_url]);
						else header("location: ".$_config[www]."/marketplace");
						}
					else
						$msg = 'User name & Password does not match';
				}
			}
			
			if(isset($_GET[reset_password]) && !isset($_SESSION[uid])) {	
				require_once('classes/class_user.php');
				$cls_user = new User();		
				$pass = isset($_GET[tlatckt])?addslashes($_GET[tlatckt]):'';
				$uid = isset($_GET[uid])?intval($_GET[uid]):0;
				if($row = mysql_fetch_assoc(mysql_query("select * from users where uid='$uid' AND password='$pass'")) ) {
					if(isset($_POST[update_password])){
						$new_pass = isset($_POST[password])?addslashes($_POST[password]):'';
						$new_pass_confirm = isset($_POST[confirm_password])?addslashes($_POST[confirm_password]):'';
						
						if(strlen($new_pass)<6)
						$msg = "Your password must be at least 6 characters";					
						if((strlen($new_pass)>=6) && ($new_pass==$new_pass_confirm) && $uid>0){							
							$value = "password='".md5($new_pass)."'";							
							if($cls_user->updateOne($uid, $value)) {
								$_GET[reset_password]=1;
								$msg = "Mật khẩu của bạn đã được thay đổi, vui lòng đăng nhập với mật khẩu mới của bạn.";
								
							}							
						}else
							$msg = "The passwords you typed do not match";
					}				
				}
				//echo $msg;
				$smarty->assign('msg',$msg);
				$smarty->assign('reset_password',1);
			}
			
			if(isset($_POST[get_pass])) {
				if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST[email]))
				$to_email = strip_tags(trim($_POST[email]));	
				else exit(0);
				if($row = mysql_fetch_assoc(mysql_query("select * from users where email='" . $to_email . "'")) ) {
					// multiple recipients
					$to  = $row[email]; // note the comma
					//$to .= 'wez@example.com';
					// subject
					$subject = "Your $_config[website_name] Password Reminder";						
						
      $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
   <h1>Request for password reset for  Text Link Ads</h1>

Hello $row[fullname],<br><br>

Click the link below to confirm that you wish your password reset.<br><br>

<a target="_blank" href="$_config[www]/account.php?reset_password&amp;uid=$row[uid]&amp;tlatckt=$row[password]">$_config[www]/account.php?reset_password&amp;uid=$row[uid]&amp;tlatckt=$row[password]</a><br>
<br><br>

  Textlink Ads Support<br />
  <u>support@textlink.vn</u> <br />
  <u>http://textlink.vn</u> <br />
  117 Tran Duy Hung&nbsp; Street &nbsp; | &nbsp; 17th Floor Charmvit  Tower&nbsp; | &nbsp; Hanoi | &nbsp; (04).62698999 | &nbsp;&nbsp;<u><a href="$_config[www]">Textlink.vn</a></u> <br />
  &copy; 2012 Textlink.vn .  All rights reserved.</p>
  </body>
</html>
EOF;
        /*$headers = 'MIME-Version: 1.0' . '';*/
        $headers .= 'Content-type: text/html; charset=utf-8' . '';
        $headers .= '' . 'To: ' . $post['username'] . '<' . $post['email'] . '>' . '';
        $headers .= '' . 'From: ' . $_config['website_name'] . '<' . $_config['admin_email'] . '>' . '';
        mail($to, $subject, $message, $headers);
				$msg = "<span style='color:green'>Your password has been sent to the email that you originally registered with. Please check your spam folder if you are unable to find the email.</span>";
				$smarty->assign('display','1');
				}
				else{ $msg = "<span style='color:red'>Your email does not exist.</span>";
					$smarty->assign('display','0');
				}
			}			
			
			if(!isset($_SESSION[uid]) && !isset($_GET[fpass]) &&!isset($_GET[reset_password]) && !isset($_SESSION[ref]))
			{
				$_SESSION = array();
				$_GET = array();
				$_POST = array();
				unset($_SESSION, $_GET, $_POST);
			}
			
			if(isset($_GET[logout])){
				$_SESSION = array();
				if (isset($_COOKIE[session_name()])) {
					setcookie(session_name(), '', time()-42000, '/');
				}
				session_destroy();
				header("location: ".$_config[www]."/account.php");
			}

			if(isset($_GET[cancel_ad_id])) {  /// Aborted buy adv
				if(mysql_query("update advertisersinfo set is_paid = 'A' where uid='$_SESSION[uid]' and adv_id = '$_GET[cancel_ad_id]' and approved='N' and is_paid='Y' and is_auth='Y'  limit 1")) {
						$price = mysql_fetch_assoc(mysql_query("select price, ppc_balance from advertisersinfo where uid='$_SESSION[uid]' and adv_id = '$_GET[cancel_ad_id]' and is_paid = 'A' and is_auth='Y'  and approved='N'"),0,0);
						if($price[ppc_balance] == 0)
							$cost = $price[price];
						else $cost = $price[ppc_balance];
						
					if(mysql_query("update users set balance=balance+$cost where uid='$_SESSION[uid]' "))
						$msg = 'Ad Product Canceled.  <a href="account.php?detailed_ads&undo_cancel_ad_id='.$_GET[cancel_ad_id].'">Undo</a>';	
					}					
			}
			
			if(isset($_GET[undo_cancel_ad_id])) {  /// Undo Aborted buy adv
				if(mysql_query("update advertisersinfo set is_paid = 'Y' where uid='$_SESSION[uid]' and adv_id = '$_GET[undo_cancel_ad_id]' and approved='N' and is_paid='A' and is_auth='Y'  limit 1")) {
					$price = mysql_fetch_assoc(mysql_query("select price, ppc_balance from advertisersinfo where uid='$_SESSION[uid]' and adv_id = '$_GET[cancel_ad_id]' and is_paid = 'A' and is_auth='Y'  and approved='N'"),0,0);
						if($price[ppc_balance] == 0)
							$cost = $price[price];
						else $cost = $price[ppc_balance];						
					if(mysql_query("update users set balance=balance-$cost where uid='$_SESSION[uid]' "))
						mysql_query("update users set balance=0 where uid='$_SESSION[uid]' and balance<0");
						$msg = 'Ad Product Activated';	
					}	
			}
			
			
			
			if(isset($_GET[pause_cmp_id])) {
				mysql_query("update adv_campaign set approved = 'R' where cmp_id = '$_GET[pause_cmp_id]' limit 1 ");
				header("location: account.php?live_ads");
				exit();
			}
			if(isset($_GET[resume_cmp_id])) {
				mysql_query("update adv_campaign set approved = 'Y' where cmp_id = '$_GET[resume_cmp_id]' limit 1 ");
				header("location: account.php?live_ads");
				exit();
			}
			if(isset($_GET[delete_cmp_id])) {
				$cost = mysql_result(mysql_query("select remaining_budget from adv_campaign where cmp_id = '$_GET[delete_cmp_id]' and uid = '$_SESSION[uid]' "),0,0);
				mysql_query("delete from adv_campaign where cmp_id = '$_GET[delete_cmp_id]' and uid = '$_SESSION[uid]' limit 1 ");				
				mysql_query("update users set balance=balance+$cost where uid='$_SESSION[uid]' ");
				$smarty->assign('acdmsg', 1);
			}
			
			if(isset($_POST[update_ad])) {
				if(!isset($_POST[length]))
					$length = 0;
				else $length = 	$_POST[length];
				
				if(mysql_query("update publishers_adspaces set length='$length', cost = '$_POST[cost]' where ad_id = '$_POST[ad_id]'"))
					$msg = 'Ad Product Updated successfully.';
			}

			
			if(isset($_GET[delete_text_ad])) {
				mysql_query("delete from publishers_adspaces where (ad_type='txt_ad' or ad_type='ppc_txt_ad') and uid='$_SESSION[uid]' and ad_id='$_GET[delete_text_ad]' ");
				$loc = substr($_SERVER['HTTP_REFERER'], 0, -1);
				header("location: ".$loc."1");
			}
			
			if(isset($_GET[upgrade])  && $_SESSION[utype]=='adv'){
				if(mysql_query("update users set utype='pub+adv' where uid='$_SESSION[uid]'"))
				$_SESSION[utype]='pub+adv';
				$_SESSION[just_once]='yes';
				header("location: update.php");	
			}
			
			
			if(isset($_GET[toggle_stat]) && $_SESSION[utype]=='pub+adv'){
				if($_SESSION[show_pub_stat] == 'Y') $_SESSION[show_pub_stat]='N';
				elseif($_SESSION[show_pub_stat] == 'N') $_SESSION[show_pub_stat]='Y';
				header("location: account.php");
			}
			
			if(isset($_POST[Newsletter]) || isset($_GET[getNewsletter])){
				if(isset($_SESSION[uid])){
				if(mysql_query("update users set getnewsletter='$_REQUEST[getNewsletter]' where uid='$_SESSION[uid]'"))
				header("location: account.php");
				}
			}			
			
				if(isset($_POST[add_txt_ad])) {
					if(mysql_query("insert into publishers_adspaces set ad_type='txt_ad', uid='$_SESSION[uid]', pid='$_POST[pid]', size='', cost='$_POST[cost]', length='$_POST[length]', allow_flash='N', accept_offers='$_POST[accept_offers]' "))
						$msg="New Text Ad added successfully.";
				}		
			
				
				
			$acc = get_acc_details();
				
			// all for right panel
			$smarty->assign('balance', $acc[balance]);
			$smarty->assign('status', $acc[status]);
			$smarty->assign('getnewsletter', $acc[newsletter]);
			$smarty->assign('liveAds', $acc[liveAds]);
			$smarty->assign('pendingAds', $acc[pendingAds]);
			$smarty->assign('clicksToday', $acc[clicksToday]);
			$smarty->assign('endingToday', $acc[endingToday]);
			$smarty->assign('websiteListed', $acc[websiteListed]);
			$smarty->assign('totalAdProducts', $acc[totalAdProducts]);
			
			$_SESSION['liveAds'] = $acc[liveAds];
			$_SESSION['clicksToday'] = $acc[clicksToday];
			$_SESSION['endingToday'] = $acc[endingToday];
			// end of right panel		
			
			
			if(!isset($_SESSION[uid]))
				$smarty->assign('show_alexa_gpr','Y');
					
			
			$smarty->assign('current_acc_page','home');
			
			
			if(isset($_GET[current_ads])){
				$smarty->assign('current_acc_page','current_ads');
				$smarty->assign('adinfo', get_adv_details('current_ads',''));
				$smarty->assign('radinfo', get_adv_details('rejected_ads',''));
			}
			
			if(isset($_GET[live_ads])){
				$smarty->assign('current_acc_page','live_ads');
				$smarty->assign('ladinfo', get_adv_details('live_ads',''));
				$smarty->assign('tadinfo', get_adv_details('targeted_ads',''));
			}
			
			if(isset($_GET[detailed_ads])){
				$smarty->assign('current_acc_page','detailed_ads');
				if(!isset($_GET[show_from]))
				$smarty->assign('dadinfo', get_adv_details('detailed_ads',-1));
				else
				$smarty->assign('dadinfo', get_adv_details('detailed_ads',$_GET[show_from]));
			}
			
			if(isset($_GET[new_ads])){
				$smarty->assign('current_acc_page','new_ads');
				$smarty->assign('nadinfo', get_pub_details('new_ads',''));
			}
			
			if(isset($_GET['ad_codes'])) {
				$smarty->assign('colorpop_js', 'Y');
				$res = mysql_query("SELECT * FROM publishersinfo WHERE uid = '$_SESSION[uid]' ORDER BY pid DESC");
				
				if(!isset($_GET['pid'])) {
					if(mysql_num_rows($res)) {
						header("location: account.php?ad_codes&pid=".mysql_result($res,0,'pid'));
					} else {
						header('location: seller_mywebsites.php?no_www');
					}
				}
				
				while($r = @mysql_fetch_assoc($res)) {
                    $rr[] = array('pid'=>$r['pid'], 'web'=>$r['websitename']);
                }
				$smarty->assign('www',$rr);
				$smarty->assign('current_acc_page','ad_codes');
				$smarty->assign('right_panel','off');
				
				$smarty->assign('layout', get_list($_POST['code_type'].'_size', 'width'));
					
				if(isset($_POST['code_type']) && !isset($_POST['save'])) {		//* text, image, video
					$ac = mysql_query("SELECT * FROM pub_ad_code WHERE type='$_POST[code_type]' AND uid='$_SESSION[uid]' ");
					if(!mysql_num_rows($ac)) {
						$sid = mysql_result(mysql_query("SELECT id FROM `$_POST[code_type]_size` limit 1"),0,0);
						mysql_query("INSERT INTO pub_ad_code SET uid='$_SESSION[uid]', pid='$_GET[pid]', type='$_POST[code_type]',`txt_total_ads`='5' , `txt_hl_len`='25' , `txt_des_len`='70' , `txt_border_c`='0000FF' , `txt_bg_c`='FFFFFF' , `txt_hl_c`='0000FF' , `txt_des_c`='000000' , `txt_font`='Verdana' , `txt_hl_size`='11px' , `txt_des_size`='10px' , `txt_pow_by`='Y' , `your_ad`='Y' , `yourad_title`='' , `txt_hl_U`='Y' , `txt_hl_B`='Y' , `img_vdo_size_id`='$sid' ");
                    }
				}
			    
				if(isset($_POST['save'])) {
					mysql_query("update pub_ad_code set `txt_total_ads`='$_POST[txt_total_ads]' , `txt_hl_len`='$_POST[txt_hl_len]' , `txt_des_len`='$_POST[txt_des_len]' , `txt_border_c`='$_POST[txt_border_c]' , `txt_bg_c`='$_POST[txt_bg_c]' , `txt_hl_c`='$_POST[txt_hl_c]' , `txt_des_c`='$_POST[txt_des_c]' , `txt_font`='$_POST[txt_font]' , `txt_hl_size`='$_POST[txt_hl_size]' , `txt_des_size`='$_POST[txt_des_size]' , `txt_pow_by`='$_POST[txt_pow_by]' , `your_ad`='$_POST[your_ad]' , `yourad_title`='$_POST[yourad_title]' , `txt_hl_U`='$_POST[txt_hl_U]' , `txt_hl_B`='Y' , `img_vdo_size_id`='$_POST[img_vdo_size_id]', txt_hl_B = '$_POST[text_dir]' where `pid`='$_POST[pid]' and `uid`='$_SESSION[uid]' and `type`='$_POST[type]' ");
				}
			
                $ac2 = mysql_query("select * from pub_ad_code where type='$_POST[code_type]' and uid='$_SESSION[uid]' and pid=$_GET[pid] limit 1");
                $acr = mysql_fetch_assoc($ac2);
                $smarty->assign('ac', $acr);
                foreach($acr as $key => $val) {
                    $js[] = $val;
                }

                $smarty->assign('js', $js);
			}
			
			if(isset($_GET[my_earnings])) {
				$smarty->assign('current_acc_page', 'my_earnings');
				
				if(isset($_GET[all])){
					$smarty->assign('earning', get_pub_details('earning','all'));	
				}
				elseif(isset($_GET[uns])){
					$smarty->assign('earning', get_pub_details('earning','uns'));	
				}
				elseif(!isset($_POST[month])) {
				$param2 = date('n').'-'.date('Y');
				$smarty->assign('earning', get_pub_details('earning',$param2));	
				$smarty->assign('heading_date', time());
				}
				else {
				$smarty->assign('earning', get_pub_details('earning', $_POST[month]));
				$tmp = explode('-', $_POST[month]);
				$smarty->assign('heading_date', $tmp[1].'-'.$tmp[0].'-01');
				}
			
				
				$diff = mysql_result(mysql_query("select PERIOD_DIFF(date_format(NOW(),'%Y%m') , date_format(buying_date,'%Y%m')) from advertisersinfo where pub_uid='$_SESSION[uid]' and buying_date<>'0000-00-00' order by buying_date limit 1"),0,0);	
				$sm = mysql_result(mysql_query("select month(buying_date) from advertisersinfo where pub_uid='$_SESSION[uid]' and buying_date<>'0000-00-00' order by buying_date limit 1"),0,0);
				$sy = mysql_result(mysql_query("select year(buying_date) from advertisersinfo where pub_uid='$_SESSION[uid]' and buying_date<>'0000-00-00' order by buying_date limit 1"),0,0);
				
				$cm = $sm; $cy = $sy;
				$m = ''; $y = '';
				$index = 0;
				for($i=0; $i<=$diff; $i++) {
				
					$tmp = $cm % 12;
					if($tmp == 0)
					$tmp = 12;
			
					if($tmp<10) $m = '0'.$tmp;
					else $m = ''.$tmp;

					$y = ''.$cy;

					$cd = $y.'-'.$m.'-01';
					$cmn = mysql_result(mysql_query("select MONTHNAME('$cd')"),0,0);

					$m_array['m_names'][$index] = $cmn.' '.$cy;
					$m_array['m_values'][$index] = $tmp.'-'.$cy;

					$cm++;

					if(!($cm%13)) {
						$cy++;
						}
					$index++;
				}
				$smarty->assign('months', $m_array);
			}
			
			
			if(isset($_GET[pub_live_ads])){
				$res = mysql_query("select * from publishersinfo where uid = '$_SESSION[uid]' order by pid desc");
				
				if(!isset($_GET[pid])){		
					if(mysql_num_rows($res)) {		
						header("location: account.php?pub_live_ads&pid=".mysql_result($res,0,'pid'));
					}
					else {
						header('location: seller_mywebsites.php?no_www');
					}
				}
				
				while($r = @mysql_fetch_assoc($res)) {
						$rr[] = array('pid'=>$r[pid], 'web'=>$r[websitename]);
						}
				$smarty->assign('www',$rr);
			
				$smarty->assign('current_acc_page','pub_live_ads');
			
				$smarty->assign('pladinfo', get_pub_details('pub_live_ads',$_GET[pid]));
			}
			
			if(isset($_GET[set_adprices])){
				$res = mysql_query("select * from publishersinfo where uid = '$_SESSION[uid]' order by pid desc");
				
				if(!isset($_GET[pid])){		
					if(mysql_num_rows($res)) {		
						header("location: account.php?set_adprices&pid=".mysql_result($res,0,'pid')."&tab=1");
					}
					else {
						header('location: seller_mywebsites.php?no_www');
					}
				}
				
				while($r = @mysql_fetch_assoc($res)) {
						$rr[] = array('pid'=>$r[pid], 'web'=>$r[websitename]);
						}
				$smarty->assign('www',$rr);
				
				$smarty->assign('txt_ad_lengths', get_list('textad', 'length'));
				$smarty->assign('img_ad_lengths', get_list('imagead', 'length'));	
				$smarty->assign('vdo_ad_lengths', get_list('videoad', 'length'));
			
				$smarty->assign('img_ad_sizes', get_list('image_size', 'width'));
				$smarty->assign('vdo_ad_sizes', get_list('video_size', 'width'));	
						
				$smarty->assign('current_acc_page','set_adprices');
				
				$smarty->assign('tad_rates', get_pub_details('txt_ad',$_GET[pid]));
				$smarty->assign('ppc_tad_rates', get_pub_details('ppc_txt_ad',$_GET[pid]));
			
				$smarty->assign('iad_rates', get_pub_details('img_ad',$_GET[pid]));
				$smarty->assign('ppc_iad_rates', get_pub_details('ppc_img_ad',$_GET[pid]));
			
				$smarty->assign('vad_rates', get_pub_details('vdo_ad',$_GET[pid]));
				$smarty->assign('ppc_vad_rates', get_pub_details('ppc_vdo_ad',$_GET[pid]));
			
			}
			
			if(isset($_GET[network_ads])){
				$smarty->assign('current_acc_page','network_ads');
				$smarty->assign('cats', get_list('category', 'category'));
				
				if(isset($_POST[save_net_ads])) {
					$g = implode('#', $_POST[cats]);
					mysql_query("update users set filter_cat_ids='$g' , pub_show_net_ads='$_POST[sna]' where uid='$_SESSION[uid]'");
				}
				
				$r = mysql_result(mysql_query("select filter_cat_ids from users where uid = '$_SESSION[uid]'"),0,0);
				$tmp = explode('#', $r);
				$smarty->assign('cat_sel', $tmp);
				$s = mysql_result(mysql_query("select pub_show_net_ads from users where uid = '$_SESSION[uid]'"),0,0);
				$smarty->assign('net_show', $s);
				
			}
			
			/// update featured set start=curdate(), end=DATE_ADD(curdate(), INTERVAL 1 MONTH)	
			if(isset($_GET[promotion])) {
									$res = mysql_query("select pid, websitename from publishersinfo where uid = '$_SESSION[uid]' order by pid desc");
							while ($row = mysql_fetch_assoc($res))
								{
									foreach($row as $key => $val)
									$c2[$key][] = $val;
								}
						$smarty->assign('www',$c2);

				$smarty->assign('current_acc_page','promotion');
				if(isset($_GET[edit]) && isset($_GET[f_ad_id])) {
					$smarty->assign('f_data', mysql_fetch_assoc(mysql_query("select * from featured where uid='$_SESSION[uid]' and fid='$_GET[f_ad_id]' ")));	
				}

 			 if(isset($_POST[ad_to_f_bask])) {
			 
			 foreach ($_POST as $key => $value){
				$_POST[$key] = addslashes(htmlspecialchars(strip_tags(trim($value))));
				}
				
				$tef = mysql_result(mysql_query("select count(*) from featured where is_paid='Y' and is_auth ='Y'  and  status = 'Y' and start <= curdate() and end >= curdate() "),0,0);
				if($tef >= $_config[max_featured]) {
				$s = mysql_result(mysql_query("select DATE_ADD(min(end), INTERVAL 1 DAY) from featured"),0,0);
				$e = mysql_result(mysql_query("select DATE_ADD(DATE_ADD(min(end), INTERVAL $_POST[length] MONTH), INTERVAL 1 DAY) from featured"),0,0);
				
					if(isset($_GET[edit]) && isset($_GET[f_ad_id]))
						{
							if(mysql_query("update featured set wname='$_POST[wname]', pid='$_POST[pid]', logo_url='$_POST[logo_url]', length='$_POST[length]', des='$_POST[des]' where fid='$_GET[f_ad_id]' and uid='$_SESSION[uid]'"))
								header("location: cart.php");
						}
					elseif(mysql_query("insert into featured set uid='$_SESSION[uid]', pid='$_POST[pid]', wname='$_POST[wname]', logo_url='$_POST[logo_url]', length='$_POST[length]', des='$_POST[des]', start='$s' , end='$e'"))
						header("location: cart.php");
				  }
				  else {
				  					
								if(isset($_GET[edit]) && isset($_GET[f_ad_id]))
									{
										if(mysql_query("update featured set wname='$_POST[wname]', pid='$_POST[pid]', logo_url='$_POST[logo_url]', length='$_POST[length]', des='$_POST[des]' where fid='$_GET[f_ad_id]' and uid='$_SESSION[uid]'"))
											header("location: cart.php");
									}
								elseif(mysql_query("insert into featured set uid='$_SESSION[uid]', pid='$_POST[pid]', wname='$_POST[wname]', logo_url='$_POST[logo_url]', length='$_POST[length]', des='$_POST[des]', start=curdate() , end = DATE_ADD(curdate(), INTERVAL $_POST[length] MONTH) "))
									header("location: cart.php");

				  	}
				}
			}
			
		if(isset($_GET[denied_adv_id])) {
				$smarty->assign('current_acc_page', 'ad_rejection');
				$c = mysql_fetch_assoc(mysql_query("select * from advertisersinfo where adv_id = '$_GET[denied_adv_id]' and uid = '$_SESSION[uid]'"));
				$smarty->assign('ref',$c);							
		}
			
		if (isset($_GET['edit_text_ad']) || isset($_GET['edit_image_ad']) || isset($_GET['edit_video_ad'])) {
				$smarty->assign('current_acc_page', 'edit_ad');
				$x = array_values($HTTP_GET_VARS);
				$ad_space_id = $x[0];
				
				$smarty->assign('ad_space_id', $ad_space_id);
				
				if(isset($_GET[edit_text_ad])) $smarty->assign('tab', 1);
				if(isset($_GET[edit_image_ad])) $smarty->assign('tab', 2);
				if(isset($_GET[edit_video_ad])) $smarty->assign('tab', 3);
				
				$c = mysql_fetch_assoc(mysql_query("select * from publishers_adspaces where ad_id = '$ad_space_id' and uid = '$_SESSION[uid]'"));
				$smarty->assign('edit',$c);
			
				$smarty->assign('txt_ad_lengths', get_list('textad', 'length'));
				$smarty->assign('img_ad_lengths', get_list('imagead', 'length'));	
				$smarty->assign('vdo_ad_lengths', get_list('videoad', 'length'));

			}

			if(isset($_GET[smw]))
				$msg = "You have to upgrade to 'Publisher & Advertiser' for selling Ad";
				
			$smarty->assign('msg',$msg);
			
			if($lightbox==1){
				$content = $smarty->fetch('lightbox.tpl');
				$smarty->assign('content',$content);
				$smarty->display('master_page_login.tpl');
				}
			else{
				$content = $smarty->fetch('account.tpl');
				$smarty->assign('content',$content);
				$smarty->display('master_page.tpl');
			}
			
			
?>