<?php

/// FOR EDIT > SEND edit, adv_id and order_product_id (ad_id)

include ("include/config.php");

if(!isset($_SESSION[uid]))
	header("location: account.php?red_url=".urlencode($_SERVER['HTTP_REFERER']));


$fname = '';
	if(!isset($_SESSION[ref])) {
		if(isset($_GET[ref])) $_SESSION[ref] = $_SERVER['HTTP_REFERER'];
		}

	if(!isset($_REQUEST[order_product_id]) && !isset($_GET[edit]) && !isset($_GET[cmp_id])) {	/////   order_product_id = ad_id = ad space id ....
		header ("location: browse.php");													////    adv_id = ad info id (ex. headline, desc, link, image..)
		exit();																			///
	}	

	
if(isset($_GET[cmp_id])) {
		$_GET[edit] = 1;
		$as = array();
		$as[ad_type] = $_GET[t];
		$as[allow_flash] = 'Y';
		$smarty->assign('ad_space', $as);
		
		$size_id = mysql_result(mysql_query("select size from adv_campaign where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' "),0,0);
		if($_GET[t] == 'img_ad')
			$size = mysql_fetch_assoc(mysql_query("select * from image_size where id='$size_id'"));
		elseif($_GET[t] == 'vdo_ad')
			$size = mysql_fetch_assoc(mysql_query("select * from video_size where id='$size_id'"));
			
			$sz[0] = $size[width];
			$sz[1] = $size[height];
			$smarty->assign('div_size', $sz);
		$existing_file = mysql_result(mysql_query("select ad_img from adv_campaign where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' "),0,0);
		if(file_exists($existing_file))
			$smarty->assign('has_file', 'Y');
		else $smarty->assign('has_file', 'N');			
		$tmp = explode('.', $existing_file);
		$ext = $tmp[count($tmp)-1];
			$smarty->assign('ext', $ext);
			
		$ad_file = array();	
		$ad_file = mysql_fetch_assoc(mysql_query("select * from adv_campaign where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' "));
		$smarty->assign('ainfo', $ad_file);
		
		if(isset($_POST[cmp_txt_ad])) {
			$sdate = $_POST[Date_Year].'-'.$_POST[Date_Month].'-'.$_POST[Date_Day];
			mysql_query("update adv_campaign set ad_hl='$_POST[ad_hl]', ad_des='$_POST[ad_des]', ad_url='$_POST[ad_url]', site_name='$_POST[site_name]', start_date='$sdate' where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' ");
			header("location: cart.php");
		}
		
		if(isset($_POST[cmp_media_ad])) {
		
			$sdate = $_POST[Date_Year].'-'.$_POST[Date_Month].'-'.$_POST[Date_Day];
			
			mysql_query("update adv_campaign set ad_hl='$_POST[ad_hl]', site_name='$_POST[site_name]', ad_url='$_POST[ad_url]',start_date='$sdate'  where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' ");
			$ins_id = '_cmp_'.$_GET[cmp_id];
			if(is_uploaded_file($_FILES['ad_file']['tmp_name'])) {
			$tmp = explode('.', $_FILES['ad_file']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);
			$tmp_fname = time().$_POST['ad_type'].$ins_id;
			$flv_fname = 'ad_files/'.$tmp_fname.'.flv';
			$flv_jpg = 'thumbs/'.$tmp_fname.'.jpg';
			$fname = 'ad_files/'.$tmp_fname.'.'.$ext;
				if(move_uploaded_file($_FILES['ad_file']['tmp_name'], $fname)) {
					
					if(($_POST['ad_type'] == 'vdo_ad' || $_POST['ad_type'] == 'ppc_vdo_ad') && $ext != 'flv') {
						
						$cnv = new convert($fname, $flv_fname);
						$mov = @new ffmpeg_movie($fname); // video file name, not flv!!
						$frame = "20";
						$ff_frame = @$mov->getFrame($frame);
						if ($ff_frame) {
							$gd_image = $ff_frame->toGDImage();
							if ($gd_image) {
								imagejpeg($gd_image, $flv_jpg, 20);
								imagedestroy($gd_image);
								}
							}
						
					//	$movietime = new ffmpeg_movie($flv_fname); // flv file name
					//	$mtime = $movietime->getDuration();

						mysql_query("update adv_campaign set ad_img='$flv_fname' where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' ");
						unlink ($fname);
					}
					
					else mysql_query("update adv_campaign set ad_img='$fname' where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' ");
					unlink($existing_file);
				}					
				
			}
			
			$existing_file = mysql_result(mysql_query("select ad_img from adv_campaign where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' "),0,0);
			if(file_exists($existing_file))
				$smarty->assign('has_file', 'Y');
			else $smarty->assign('has_file', 'N');
			$tmp = explode('.', $existing_file);
			$ext = $tmp[count($tmp)-1];
				$smarty->assign('ext', $ext);
			$ad_file = array();
			$ad_file = mysql_fetch_assoc(mysql_query("select * from adv_campaign where cmp_id='$_GET[cmp_id]' and uid='$_SESSION[uid]' "));
			$smarty->assign('ainfo', $ad_file);
		}	
		
}
	
else { ///*** rest of the code
		$as = mysql_fetch_assoc(mysql_query("select * from publishers_adspaces where ad_id='$_REQUEST[order_product_id]'"));
			$smarty->assign('ad_space', $as);
			
			$sz = explode('x', $as['size']);
				$smarty->assign('div_size', $sz);
		
		if($as[accept_offers]=='Y' && isset($_POST[offer_price]) && $_POST[offer_price]>0 && isset($_POST[offer]))
			{
			$smarty->assign('real_offer', 'Y');
			$smarty->assign('AD_PRICE', $_POST[offer_price]);
			}
			
		else {
			$smarty->assign('real_offer', 'fake_offer');
			$smarty->assign('AD_PRICE', $as[cost]);
			}
		
			
		$ac = mysql_fetch_assoc(mysql_query("select * from pub_ad_code where ad_id='$_REQUEST[order_product_id]'"));
			$smarty->assign('ad_code', $ac);
			
		$w = mysql_fetch_assoc(mysql_query("select * from publishersinfo where pid='$as[pid]'"));
			$smarty->assign('winfo', $w);

	
	
	

	if(isset($_POST['next']) || isset($_POST['upload'])) {  /// insert new entry in adv (not ad space... that's diff thing )
	
		$sdate = $_POST[Date_Year].'-'.$_POST[Date_Month].'-'.$_POST[Date_Day];
		$length = $_POST[ad_length];
		
		$insert = mysql_query("insert into advertisersinfo set uid='$_SESSION[uid]', pub_uid='$_POST[pub_uid]', pid='$_POST[pid]', ad_type='$_POST[ad_type]', 
		ad_id='$_POST[order_product_id]', site_name='".safe_entry($_POST['site_name'])."', ad_hl='".safe_entry($_POST['ad_hl'])."', ad_des='".safe_entry($_POST[ad_des])."', ad_url='".safe_entry($_POST[ad_url])."', price='".safe_entry($_POST[AD_PRICE])."',
		req_date=curdate(), start_date='$sdate', end_date = DATE_ADD('$sdate', INTERVAL $length DAY), approved='N', is_paid='N', is_auth='N' ");

			$ins_id = mysql_insert_id();

		if(is_uploaded_file($_FILES['ad_file']['tmp_name'])) {
			$tmp = explode('.', $_FILES['ad_file']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);
			$tmp_fname = time().$_POST['ad_type'].$ins_id;
			$flv_fname = 'ad_files/'.$tmp_fname.'.flv';
			$flv_jpg = 'thumbs/'.$tmp_fname.'.jpg';
			$fname = 'ad_files/'.$tmp_fname.'.'.$ext;
				if(move_uploaded_file($_FILES['ad_file']['tmp_name'], $fname)) {
					
					if(($_POST['ad_type'] == 'vdo_ad' || $_POST['ad_type'] == 'ppc_vdo_ad') && $ext != 'flv') {
						
						$cnv = new convert($fname, $flv_fname);
						$mov = @new ffmpeg_movie($fname); // video file name, not flv!!
						$frame = "20";
						$ff_frame = @$mov->getFrame($frame);
						if ($ff_frame) {
							$gd_image = $ff_frame->toGDImage();
							if ($gd_image) {
								imagejpeg($gd_image, $flv_jpg, 20);
								imagedestroy($gd_image);
								}
							}
						
					//	$movietime = new ffmpeg_movie($flv_fname); // flv file name
					//	$mtime = $movietime->getDuration();

						mysql_query("update advertisersinfo set ad_img='$flv_fname' where adv_id = '$ins_id' and uid='$_SESSION[uid]'");
						unlink ($fname);
					}
					
					else mysql_query("update advertisersinfo set ad_img='$fname' where adv_id = '$ins_id' and uid='$_SESSION[uid]'");
				}	
					
				$_REQUEST[adv_id] = $ins_id;
			}

		if($_POST[ad_type] == 'txt_ad') {
				header ("location: cart.php");
				exit();
			}
		elseif($_POST[ad_type] == 'ppc_txt_ad') {
				header ("location: buy_ads_ppc.php?adv_id=$ins_id&order_product_id=$_POST[order_product_id]");
				exit();
		}	
	}

	if(isset($_POST[update_file])) {
	$ins_id = $_POST[adv_id];  /// adv_id must be sent as post to edit / update
		
		if (isset($_REQUEST[advertisersinfo_edit])) {
			$existing_file = mysql_result(mysql_query("select ad_img from advertisersinfo_edit where adv_id='$ins_id' and uid='$_SESSION[uid]' "),0,0);
			@mysql_query("delete from advertisersinfo_edit where adv_id = '$_REQUEST[adv_id]' and uid='$_SESSION[uid]'");
			$insert = mysql_query("insert into advertisersinfo_edit set adv_id='$_POST[adv_id]', uid='$_SESSION[uid]' ");
			if(is_uploaded_file($_FILES['ad_file']['tmp_name'])) {
			$tmp = explode('.', $_FILES['ad_file']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);
			$tmp_fname = time().$_POST['ad_type'].$ins_id;
			$flv_fname = 'ad_files/'.$tmp_fname.'.flv';
			$flv_jpg = 'thumbs/'.$tmp_fname.'.jpg';
			$fname = 'ad_files/'.$tmp_fname.'.'.$ext;
				if(move_uploaded_file($_FILES['ad_file']['tmp_name'], $fname)) {
				
					if(($_POST['ad_type'] == 'vdo_ad' || $_POST['ad_type'] == 'ppc_vdo_ad') && $ext != 'flv') {
						
						$cnv = new convert($fname, $flv_fname);
						$mov = @new ffmpeg_movie($fname); // video file name, not flv!!
						$frame = "20";
						$ff_frame = @$mov->getFrame($frame);
						if ($ff_frame) {
							$gd_image = $ff_frame->toGDImage();
							if ($gd_image) {
								imagejpeg($gd_image, $flv_jpg, 20);
								imagedestroy($gd_image);
								}
							}
						
					//	$movietime = new ffmpeg_movie($flv_fname); // flv file name
					//	$mtime = $movietime->getDuration();

						mysql_query("update advertisersinfo set ad_img='$flv_fname' where adv_id = '$ins_id' and uid='$_SESSION[uid]'");
						unlink ($fname);
					}
					
					else mysql_query("update advertisersinfo_edit set ad_img = '$fname' where adv_id = '$ins_id' and uid = '$_SESSION[uid]' ");
						unlink($existing_file);
				}
			}
		
			mysql_query("update advertisersinfo_edit set site_name = '$_POST[site_name]', ad_url = '$_POST[ad_url]' where adv_id = '$ins_id' and uid='$_SESSION[uid]' ");
			
		}
		else {
		$existing_file = mysql_result(mysql_query("select ad_img from advertisersinfo where adv_id='$ins_id' and uid='$_SESSION[uid]' "),0,0);
		if(is_uploaded_file($_FILES['ad_file']['tmp_name'])) {
			$tmp = explode('.', $_FILES['ad_file']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);
			$tmp_fname = time().$_POST['ad_type'].$ins_id;
			$flv_fname = 'ad_files/'.$tmp_fname.'.flv';
			$flv_jpg = 'thumbs/'.$tmp_fname.'.jpg';
			$fname = 'ad_files/'.$tmp_fname.'.'.$ext;
				if(move_uploaded_file($_FILES['ad_file']['tmp_name'], $fname)) {
				
					if(($_POST['ad_type'] == 'vdo_ad' || $_POST['ad_type'] == 'ppc_vdo_ad') && $ext != 'flv') {
						
						$cnv = new convert($fname, $flv_fname);
						$mov = @new ffmpeg_movie($fname); // video file name, not flv!!
						$frame = "20";
						$ff_frame = @$mov->getFrame($frame);
						if ($ff_frame) {
							$gd_image = $ff_frame->toGDImage();
							if ($gd_image) {
								imagejpeg($gd_image, $flv_jpg, 20);
								imagedestroy($gd_image);
								}
							}
						
					//	$movietime = new ffmpeg_movie($flv_fname); // flv file name
					//	$mtime = $movietime->getDuration();

						mysql_query("update advertisersinfo set ad_img='$flv_fname' where adv_id = '$ins_id' and uid='$_SESSION[uid]'");
						unlink ($fname);
					}
					
					else mysql_query("update advertisersinfo set ad_img = '$fname' where adv_id = '$ins_id' and uid = '$_SESSION[uid]' ");
						unlink($existing_file);
				}
			}

		$sdate = $_POST[Date_Year].'-'.$_POST[Date_Month].'-'.$_POST[Date_Day];
		$length = $_POST[ad_length];

		mysql_query("update advertisersinfo set site_name = '$_POST[site_name]', ad_url = '$_POST[ad_url]', start_date='$sdate', end_date = DATE_ADD('$sdate', INTERVAL $length DAY) where adv_id = '$ins_id' and uid='$_SESSION[uid]' ");
			
			$_REQUEST[adv_id] = $ins_id;
		}
		
		if(isset($_SESSION[ref])) {
		$l = $_SESSION[ref];
		unset($_SESSION[ref]);
		header("location: $l");
		exit();
		}
	}



	if(isset($_POST[update])) {  // only for text ad??	
		
		$sdate = $_POST[Date_Year].'-'.$_POST[Date_Month].'-'.$_POST[Date_Day];
		$length = $_POST[ad_length];
		
	if (isset($_REQUEST[advertisersinfo_edit])) {
		@mysql_query("delete from advertisersinfo_edit where adv_id = '$_REQUEST[adv_id]' and uid='$_SESSION[uid]'");
		
		$insert = mysql_query("insert into advertisersinfo_edit set adv_id='$_POST[adv_id]', uid='$_SESSION[uid]',
		ad_id='$_POST[order_product_id]', site_name='".safe_entry($_POST['site_name'])."', ad_hl='".safe_entry($_POST['ad_hl'])."', ad_des='".safe_entry($_POST[ad_des])."', ad_url='".safe_entry($_POST[ad_url])."', 
		req_date=curdate(), approved='N'");
	}
	
	else {
		$update_res = mysql_query("update advertisersinfo set 
		site_name='".safe_entry($_POST['site_name'])."', ad_hl='".safe_entry($_POST['ad_hl'])."', ad_des='".safe_entry($_POST[ad_des])."', ad_url='".safe_entry($_POST[ad_url])."', price='".safe_entry($_POST[AD_PRICE])."',
		req_date=curdate(), start_date='$sdate', end_date = DATE_ADD('$sdate', INTERVAL $length DAY), approved='N', is_paid='N', is_auth='N' 
		where uid='$_SESSION[uid]' and adv_id = '$_POST[adv_id]' ");
		}
		
		
		$l = $_SESSION[ref];
		unset($_SESSION[ref]);
		header("location: $l");
		exit();
	}
	
	
	if(isset($_REQUEST[adv_id]) && isset($_GET[edit])) { // check session uid for security
		$getit = mysql_fetch_assoc(mysql_query("select * from advertisersinfo where uid='$_SESSION[uid]' and adv_id='$_REQUEST[adv_id]'"));
			$smarty->assign('ainfo', $getit);
			
			if (file_exists($getit['ad_img'])) {
				$smarty->assign('has_file', 'Y');
				
					$tmp = explode('.', $getit['ad_img']);
					$ext = $tmp[count($tmp)-1];
						$smarty->assign('ext', $ext);
				}
			else $smarty->assign('has_file', 'N');
	}
}

$smarty->assign('right_panel', 'off');
$smarty->register_modifier("sslash", "stripslashes");
$smarty->assign('swf_object', 'Y');

$content = $smarty->fetch('buy_ads.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

?>