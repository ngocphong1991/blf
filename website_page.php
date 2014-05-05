<?php
include ("include/config.php");
	
	function get_website_details($param, $pid){
				$c = array();
				$res = mysql_query("select * from publishers_adspaces where pid='$pid' and ad_type='$param' order by ad_id desc");
				$index=0;
				while ($row = mysql_fetch_assoc($res)){

						$c[$index]['cost'] = $row[cost];
						$c[$index]['size'] = $row[size];
						$c[$index]['length'] = $row[length];
						$c[$index]['ad_id'] = $row[ad_id];
						$c[$index]['pid'] = $row[pid];
						$c[$index]['title'] = $row[title];
									
						$c[$index]['allow_flash'] = $row[allow_flash];
						$c[$index]['accept_offers'] = $row[accept_offers];
						
						if($c[$index]['length'] == 0)
							$c[$index]['accept_offers'] = 'N';
						
						if($param == 'txt_ad' || $param == 'ppc_txt_ad') {
							$total_txt_ads = mysql_result(mysql_query("select txt_total_ads from pub_ad_code where pid='$pid' and type='text' "),0,0);
							$ppc_txt_total = mysql_result(mysql_query("select count(*) from advertisersinfo where pid='$pid' and ad_type='ppc_txt_ad' and start_date <= curdate() and ppc_balance > 0 and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
							if($ppc_txt_total < $total_txt_ads) {
								$txt_total = mysql_result(mysql_query("select count(*) from advertisersinfo where pid='$pid' and ad_type='txt_ad' and start_date <= curdate() and end_date >= curdate() and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
								if(($ppc_txt_total+$txt_total) < $total_txt_ads)
								{
									$c[$index]['next_ad_date'] = date("Y-m-d");
								}
								else {
									
									$c[$index]['next_ad_date'] = mysql_result(mysql_query("select ADDDATE(min(end_date), 1) from advertisersinfo where pid='$pid' and ad_type='txt_ad' and start_date <= curdate() and end_date >= curdate() and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
								}
							}
							else $c[$index]['next_ad_date'] = 'NA';
						}	
						
/*						$c[$index]['next_ad_date'] = mysql_result(mysql_query("select max(end_date) from advertisersinfo where ad_id='$row[ad_id]' and end_date>=curdate() limit 1"),0,0);
						
						
						if($c[$index]['next_ad_date'] == NULL)
							$c[$index]['next_ad_date'] = date("Y-m-d");
*/							
						
						elseif($param == 'img_ad' || $param == 'ppc_img_ad') {
							$total_txt_ads = 1; //mysql_result(mysql_query("select txt_total_ads from pub_ad_code where pid='$pid' and type='text' "),0,0);
							$ppc_txt_total = mysql_result(mysql_query("select count(*) from advertisersinfo where pid='$pid' and ad_type='ppc_img_ad' and start_date <= curdate() and ppc_balance > 0 and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
							if($ppc_txt_total < $total_txt_ads) {
								$txt_total = mysql_result(mysql_query("select count(*) from advertisersinfo where pid='$pid' and ad_type='img_ad' and start_date <= curdate() and end_date >= curdate() and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
								if(($ppc_txt_total+$txt_total) < $total_txt_ads)
								{
									$c[$index]['next_ad_date'] = date("Y-m-d");
								}
								else {
									
									$c[$index]['next_ad_date'] = mysql_result(mysql_query("select ADDDATE(min(end_date), 1) from advertisersinfo where pid='$pid' and ad_type='img_ad' and start_date <= curdate() and end_date >= curdate() and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
								}
							}
							else $c[$index]['next_ad_date'] = 'NA';
						}
						
						elseif($param == 'vdo_ad' || $param == 'ppc_vdo_ad') {
							$total_txt_ads = 1; //mysql_result(mysql_query("select txt_total_ads from pub_ad_code where pid='$pid' and type='text' "),0,0);
							$ppc_txt_total = mysql_result(mysql_query("select count(*) from advertisersinfo where pid='$pid' and ad_type='ppc_vdo_ad' and start_date <= curdate() and ppc_balance > 0 and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
							if($ppc_txt_total < $total_txt_ads) {
								$txt_total = mysql_result(mysql_query("select count(*) from advertisersinfo where pid='$pid' and ad_type='vdo_ad' and start_date <= curdate() and end_date >= curdate() and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
								if(($ppc_txt_total+$txt_total) < $total_txt_ads)
								{
									$c[$index]['next_ad_date'] = date("Y-m-d");
								}
								else {
									
									$c[$index]['next_ad_date'] = mysql_result(mysql_query("select ADDDATE(min(end_date), 1) from advertisersinfo where pid='$pid' and ad_type='vdo_ad' and start_date <= curdate() and end_date >= curdate() and is_paid='Y' and is_auth = 'Y' and approved='Y' "),0,0);
								}
							}
							else $c[$index]['next_ad_date'] = 'NA';
						}
						
						$max_one_day_clicks = mysql_result(mysql_query("SELECT count(hit_id) as total from hits where is_click=1 and ad_id='$row[ad_id]' group by date order by total desc limit 1"),0,0);
						$c[$index]['avg_day_clicks'] = $max_one_day_clicks;
							
						$index++;
					}
				return $c;
				}

				$arr_merge = array_merge(get_website_details('txt_ad',$_GET[pid]), get_website_details('ppc_txt_ad',$_GET[pid]) );
				$smarty->assign('tad_rates', $arr_merge);
			//	$smarty->assign('ppc_tad_rates', get_website_details('ppc_txt_ad',$_GET[pid]));
			
				$arr_merge2 = array_merge(get_website_details('img_ad',$_GET[pid]), get_website_details('ppc_img_ad',$_GET[pid]) );
				$smarty->assign('iad_rates', $arr_merge2);
				//print_r($arr_merge2);
				//$smarty->assign('ppc_iad_rates', get_website_details('ppc_img_ad',$_GET[pid]));			
				
				$arr_merge3 = array_merge(get_website_details('vdo_ad',$_GET[pid]), get_website_details('ppc_vdo_ad',$_GET[pid]));
				$smarty->assign('vad_rates', $arr_merge3);
			//	$smarty->assign('ppc_vad_rates', get_website_details('ppc_vdo_ad',$_GET[pid]));



$xrow = mysql_fetch_assoc(mysql_query("select * from publishersinfo where pid='$_GET[pid]' and status = '1' "));
$get_suspended_uid = mysql_result(mysql_query("select status from users where uid = '$xrow[uid]' limit 1 "),0,0);
	if($get_suspended_uid == 0) {
		header("location: browse.php");
		exit();
		}
$ad_spaces = mysql_result(mysql_query("select count(*) from publishers_adspaces where pid = '$_GET[pid]' "),0,0);
	if ($ad_spaces == 0) {
		header("location: browse.php");
		exit();
	}
/* auto update of alexa and gpr 
$xrow[alexa_rank] = alexaRank($xrow[url]);
$xrow[google_page_rank] = google_page_rank($xrow[url]);
$at = alexaThumb($xrow[url]);
		$rf = 'wwwThumb/thumb_'.$_GET[pid].'_pic.jpg';
		@unlink($rf);
		copy_remote_file($at, $rf);
	mysql_query("update publishersinfo set alexa_rank='$xrow[alexa_rank]', google_page_rank='$xrow[google_page_rank]' where pid='$_GET[pid]'");
*/	
$smarty->assign('winfo', $xrow);

	$mu_pd = mysql_result(mysql_query("SELECT count(ip) as total, date from hits where pub_id='$_GET[pid]' group by date order by total desc limit 1"),0,0);
	$smarty->assign('pvpd', $mu_pd);
	
	$mqry = mysql_query("select count(hit_id) as total, date, adv_id
							from hits
							where pub_id='$_GET[pid]' and adv_id <> '0' and is_click='1' 
							group by date, adv_id
							order by total desc, date desc
							limit 0,1");

	$max_u = mysql_result(($mqry),0,0);
	$max_u_date = mysql_result(($mqry),0,1);
	$smarty->assign('max_u', $max_u);
	$smarty->assign('max_u_date', $max_u_date);

	$max_u_u = mysql_result(mysql_query("SELECT count(distinct ip) as total from hits where pub_id='$_GET[pid]' group by date order by total desc limit 1"),0,0);
	$smarty->assign('max_u_u', $max_u_u);
	

	$a_cpc = mysql_result(mysql_query("select round(avg(cost),2) from publishers_adspaces where pid='$_GET[pid]' and length=0"),0,0);
	$smarty->assign('avg_cpc', $a_cpc);
	
$keywords = explode(',', $xrow[keywords]);
$smarty->assign('keywords', $keywords);


if($xrow[langid] == 0)
	$lang = 'English';

else{
		$lr = mysql_query("SELECT language FROM `language`, publishersinfo where publishersinfo.pid='$_GET[pid]' and publishersinfo.langid = language.lid");
		$lang = mysql_result($lr,0,0);	
	}
	
$smarty->assign('lang', $lang);


	$T = ''; $I = ''; $V = '';
	$txt = mysql_result(mysql_query("select count(*) from publishers_adspaces where (ad_type='txt_ad' or ad_type='ppc_txt_ad') and pid='$_GET[pid]' "),0,0);
	if ($txt) $T = 'Text';
		
	$img = mysql_result(mysql_query("select count(*) from publishers_adspaces where (ad_type='img_ad' or ad_type='ppc_img_ad') and pid='$_GET[pid]' "),0,0);
	if ($img) $I = 'Image';

	$vdo = mysql_result(mysql_query("select count(*) from publishers_adspaces where (ad_type='vdo_ad' or ad_type='ppc_vdo_ad') and pid='$_GET[pid]' "),0,0);
	if ($vdo) $V = 'Video';

$smarty->assign('T', $T);
$smarty->assign('I', $I);
$smarty->assign('V', $V);


$m1 = mysql_result(mysql_query("select max(length) from textad"),0,0);
$m2 = mysql_result(mysql_query("select max(length) from imagead"),0,0);
$m3 = mysql_result(mysql_query("select max(length) from videoad"),0,0);

$max_length = max($m1,$m2,$m3);
for ($i=1; $i<=$max_length; $i++)
	$lens[$i] = $i.' Day Ads';
$smarty->assign('len_menu', $lens);



$smarty->assign('right_panel','off');
$smarty->assign('tabcontent','Y');
$content = $smarty->fetch('website_page.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>