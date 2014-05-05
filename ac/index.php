<?
if(!isset($_GET[ci])) exit();

include ("../include/config.php");

$code_id = $_GET[ci];
$res = mysql_fetch_assoc(mysql_query("select * from pub_ad_code where code_id = '$code_id' "));

$no_ad = false;

	$size_id = $res[img_vdo_size_id];

	$AdCode = '';
	$AdCodeVars = '';
	$def_ad_txt = $_lang['def_ad_txt'];

if($res[type] == 'text') {

	$size = mysql_fetch_assoc(mysql_query("select * from text_size where id = '$size_id' "));

	$pub_uid = $res[uid];
	$pid = $res[pid];

			
	$total_ads = $res[txt_total_ads];
	$border_c = $res[txt_border_c];
	$bg_c = $res[txt_bg_c];
	$hl_c = $res[txt_hl_c];
	$des_c = $res[txt_des_c];
	$font = $res[txt_font];
	$hl_s = $res[txt_hl_size];
	$hl_u = ($res[txt_hl_U] == 'Y')?'underline':'none';
	$des_s = $res[txt_des_size];
	$pow = $res[txt_pow_by];
	$ur_ad = $res[your_ad];
	$ur_ttl = $res[yourad_title];
	$text_dir = $res[txt_hl_B];
	$width = $size[width];
	$height = $size[height];
	


	if($pow == 'Y')
		$AdCode .= '<div style="cursor: pointer; z-index: 100001; margin: 0px; overflow: hidden; text-align: center; padding-left: 0px; display: block; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center"   onclick="javascript: window.open(\''.$_config[www].'/browse.php\',\'_blank\',\'\');">Powered by '.$_config[website_name].'</div>';

		$AdCode .= '<div style="z-index: 100000; display: block; border: 1px solid #'.$border_c.'; margin: 0px; overflow: hidden; padding-left: 2px; width: '.$width.'px; height: '.$height.'px; background-color: #'.$bg_c.';">
						<table cellpadding="0" cellspacing="0" width="100%"><tbody>';
				
	$ad_row = array();
	$ads = mysql_query("select distinct * from advertisersinfo where pid='$pid' and ((ad_type='txt_ad' and end_date >= curdate()) or (ad_type='ppc_txt_ad' and ppc_balance>0)) and start_date <= curdate() and approved='Y' and is_paid='Y' and is_auth='Y' order by rand() limit $total_ads");
	while($row = mysql_fetch_assoc($ads)) {
		$ad_row[] = array('adv_id' => $row[adv_id], 'url' => $row[ad_url], 'pid' => $row[pid], 'ad_id' => $row[ad_id], 'ad_hl' => $row[ad_hl], 'ad_des' => $row[ad_des], 'is_net' => 'N', 'cmp_id' => 0);
	}
	
	if(count($ad_row) < $total_ads) {
		$limit = $total_ads - count($ad_row);
//		$mq = mysql_query("select ad_id, cost from publishers_adspaces where cost=(select min(cost) from publishers_adspaces where pid='$pid' and ad_type='ppc_txt_ad') and pid='$pid' and ad_type='ppc_txt_ad' limit 1");
		//$mcost = mysql_result($mq,0,'cost');
//		$mcost = mysql_result(mysql_query(""),0,0);
		$ad_space_id = 0;
		$res_user = mysql_query("select pub_show_net_ads, filter_cat_ids from users where uid='$pub_uid'");
	//	$show_net = mysql_result($res_user,0,0);
		$filter_cat_user = mysql_result($res_user,0,1);
		$keyword_pinfo = mysql_result(mysql_query("select keywords from publishersinfo where pid='$pid'"),0,0);
		$mcost = mysql_result(mysql_query("select clickrate from publishersinfo where pid='$pid'"),0,0);
		$show_net = mysql_result(mysql_query("select targetedad from publishersinfo where pid='$pid'"),0,0);
		$res_gids = mysql_query("select gid from pub_geo where pid = '$pid'");
		
		if($show_net == 'Y') {
			
			//pid = website ID
			//pub_uid = user ID
			$filter_cats = explode("#",trim($filter_cat_user,"#"));
			$filter_keywords = explode(",",trim($keyword_pinfo));
			foreach($filter_keywords as $key=>$val){
				$filter_keywords[$key] = trim($val);
			} 
			$filter_geos = array();
			while($rg = mysql_fetch_assoc($res_gids)){
				$filter_geos[] = $rg['gid'];
			}
			
			
			$qry = "select * from adv_campaign where (geo_target is null ";
			foreach($filter_geos as $key=>$val){
				$qry .= " or geo_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and (cat_target is null ";
			
			foreach($filter_cats as $key=>$val){
				$qry .= " or cat_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and (key_target is null ";
			
			foreach($filter_keywords as $key=>$val){
				$qry .= " or key_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and expense_today < daily_budget and ad_type='txt' and start_date <= curdate() and remaining_budget>0 and max_cpc >= '$mcost' and approved='Y' and is_paid='Y' and is_auth='Y' order by rand() limit $limit";

			$net_ads = mysql_query($qry);
			while ($nrow = mysql_fetch_assoc($net_ads)) {
				$ad_row[] = array('adv_id' => $nrow[cmp_id], 'url' => $nrow[ad_url], 'pid' => $pid, 'ad_id' => $ad_space_id, 'ad_hl' => $nrow[ad_hl], 'ad_des' => $nrow[ad_des], 'is_net' => 'Y', 'cmp_id' => $nrow[cmp_id]);
			}
		}
	}

	if(count($ad_row)) { /// div by zero err
//		$td_w = 100.0 /(1.0*count($ad_row));
	 	
	if($text_dir == 'Y') // horizontal
		$AdCode .= '<tr>'; // ***
	for ($i=0; $i<count($ad_row); $i++) {
		$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$ip=gethostbyname($host_name);
		mysql_query("insert into hits set adv_id = '".$ad_row[$i][adv_id]."', pub_id = '".$ad_row[$i][pid]."', ad_id='".$ad_row[$i][ad_id]."', cmp_id = '".$ad_row[$i][cmp_id]."', date=curdate(), ip='$ip', ip_details='$host_name' ");

	if($text_dir == 'N') // vertical 
		$AdCode .= '<tr>'; // *** 
		$AdCode .= '<td style="vertical-align: top; text-align: left; width: '.$td_w.'%;">
					<a href="'.$ad_row[$i]['url'].'" target="_blank" onclick="return false;">
						<div style="cursor: pointer; display: block; margin: 0pt auto; color: #'.$hl_c.'; font-weight: bold; text-decoration: '.$hl_u.'; font-size: '.$hl_s.'; font-family: '.$font.'; padding-top: 2px; cursor: pointer;" onclick="javascript: window.open(\''.$_config[www].'/popad/?pid='.$ad_row[$i][pid].'&ad_id='.$ad_row[$i][ad_id].'&network='.$ad_row[$i][is_net].'&advertise='.$ad_row[$i][adv_id].'\',\'_blank\',\'\');">
							'.$ad_row[$i]['ad_hl'].'
						</div>
						
						<div style="display: block; margin: 0pt auto; color: #'.$des_c.'; font-weight: normal; text-decoration: none; font-size: '.$des_s.'; font-family: '.$font.'; cursor: pointer;" onclick="javascript: window.open(\''.$_config[www].'/popad/?pid='.$ad_row[$i][pid].'&ad_id='.$ad_row[$i][ad_id].'&network='.$ad_row[$i][is_net].'&advertise='.$ad_row[$i][adv_id].'\',\'_blank\',\'\');">
							' . $ad_row[$i][ad_des] . '
						</div>
					</a>
					</td>';
					
		if($text_dir == 'N') // vertical 
		$AdCode .= '</tr>'; // ***		
		}

	if($text_dir == 'Y') // horizontal
		$AdCode .= '</tr>';

	} else {
		$no_ad = true;
		$AdCode .= '<tr><td align="center" valign="middle" style="height: '.$height.'px; color: #'.$hl_c.'; font-weight: bold; text-decoration: '.$hl_u.'; font-size: '.$hl_s.'; font-family: '.$font.';">'.$def_ad_txt.'</td></tr>';
		}
		$AdCode .= '</tbody></table></div>';

	if($ur_ad == 'Y')
		$AdCode .= '<div style="cursor: pointer; z-index: 100002; display: block; margin: 0px; overflow: hidden; padding-left: 0px; text-align: center; text-decoration: underline; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center" onclick="javascript: window.open(\''.$_config[www].'/website_page.php?pid='.$pid.'\',\'_blank\',\'\');">Your Ad Here</div>';
	elseif($ur_ad == 'C')
		$AdCode .= '<div style="cursor: pointer; z-index: 100002; display: block; margin: 0px; overflow: hidden; padding-left: 0px; text-align: center; text-decoration: underline; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center"  onclick="javascript: window.open(\''.$_config[www].'/website_page.php?pid='.$pid.'\',\'_blank\',\'\');">'.$ur_ttl.'</div>';

}


elseif($res[type] == 'image') {
	$size = mysql_fetch_assoc(mysql_query("select * from image_size where id = '$size_id' "));
	
	$pow = $res[txt_pow_by];
	$ur_ad = $res[your_ad];
	$ur_ttl = $res[yourad_title];
	$pid = $res[pid];
	$width = $size[width];
	$height = $size[height];
	

	if($pow == 'Y')
		$AdCode .= '<div style="cursor: pointer; z-index: 100001; margin: 0px; overflow: hidden; text-align: center; padding-left: 0px; display: block; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center"   onclick="javascript: window.open(\''.$_config[www].'/browse.php\',\'_blank\',\'\');">Powered by '.$_config[website_name].'</div>';

		$AdCode .= '<div style="z-index: 85; display: block; border: 0; margin: 0px; overflow: hidden; padding-left: 2px; width: '.$width.'px; height: '.$height.'px;">
						<table cellpadding="0" cellspacing="0" width="100%"><tbody>
							<tr><td style="vertical-align: top; text-align: left;">';


	$qqq = mysql_query("select * from advertisersinfo where pid='$pid' and ((ad_type='img_ad' and end_date >= curdate()) or (ad_type='ppc_img_ad' and ppc_balance>0)) and start_date <= curdate() and approved='Y' and is_paid='Y' and is_auth='Y' order by rand() limit 1");
	if(mysql_num_rows($qqq)) {
			$ads = mysql_fetch_assoc($qqq);	
			$network='N';
			$ad_id = $ads[ad_id];
			$url = $ads[ad_url];
		}
	else {
		$limit = 1;
//		$mq = mysql_query("select ad_id, cost, allow_flash from publishers_adspaces where cost=(select min(cost) from publishers_adspaces where pid='$pid' and ad_type='ppc_img_ad') and pid='$pid' and ad_type='ppc_img_ad' limit 1");
//		$mcost = mysql_result($mq,0,'cost');
		$ad_space_id = 0;
		$a_flash = mysql_result($mq,0,'allow_flash');
		$flash_qry = '';
		$res_user = mysql_query("select pub_show_net_ads, filter_cat_ids from users where uid='$pub_uid'");
//		$show_net = mysql_result($res_user,0,0);
		$mcost = mysql_result(mysql_query("select clickrate from publishersinfo where pid='$pid'"),0,0);
		$show_net = mysql_result(mysql_query("select targetedad from publishersinfo where pid='$pid'"),0,0);
		$filter_cat_user = mysql_result($res_user,0,1);
		$keyword_pinfo = mysql_result(mysql_query("select keywords from publishersinfo where pid='$pid'"),0,0);
		$res_gids = mysql_query("select gid from pub_geo where pid = '$pid'");
		
		if($show_net == 'Y') {
			
			//pid = website ID
			//pub_uid = user ID
			$filter_cats = explode("#",trim($filter_cat_user,"#"));
			$filter_keywords = explode(",",trim($keyword_pinfo));
			foreach($filter_keywords as $key=>$val){
				$filter_keywords[$key] = trim($val);
			} 
			$filter_geos = array();
			while($rg = mysql_fetch_assoc($res_gids)){
				$filter_geos[] = $rg['gid'];
			}
			
			if($a_flash == 'N') 
				$flash_qry = " and ad_img not like '%.swf' ";
			
			$qry = "select * from adv_campaign where (geo_target is null ";
			foreach($filter_geos as $key=>$val){
				$qry .= " or geo_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and (cat_target is null ";
			
			foreach($filter_cats as $key=>$val){
				$qry .= " or cat_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and (key_target is null ";
			
			foreach($filter_keywords as $key=>$val){
				$qry .= " or key_target like '%#" . $val . "#%' ";
			}
			$qry .= ")  and expense_today < daily_budget $flash_qry and size='$size_id' and ad_type='img' and start_date <= curdate() and remaining_budget>0 and max_cpc >= '$mcost' and approved='Y' and is_paid='Y' and is_auth='Y' order by rand() limit $limit";
			
			$ads = mysql_fetch_assoc(mysql_query($qry));
			$network='Y';
			$ad_id = $ad_space_id;
			$ads[adv_id] = $ads[cmp_id];
			$url = $ads[ad_url];
		}
	}
		$ad_row = $ads;

	if(strlen($ads[ad_img]) > 2) {
		$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$ip=gethostbyname($host_name);
		mysql_query("insert into hits set adv_id = '$ad_row[adv_id]', pub_id = '$ad_row[pid]', ad_id='$ad_row[ad_id]', cmp_id = '0', date=curdate(), ip='$ip', ip_details='$host_name' ");

	$tmp = explode('.', $ads[ad_img]);
	$ext = strtolower($tmp[count($tmp)-1]);
	if($ext == 'swf') { ////****** Flash Ad	
	$div_id = mt_rand(5000, 99999);
		$AdCode .= '<div style="display: block; position: relative; width: '.$width.'; height: '.$height.';">
							<div style="position: absolute; z-index: 10091; width: '.$width.'; height: '.$height.';"><a href="'.$url.'" target="_blank" onclick="return false;"><img src="'.$_config[www].'/js/blank.gif" style="border:0; width: '.$width.'; height: '.$height.';" onclick="javascript: window.open(\''.$_config[www].'/popad/?pid='.$pid.'&ad_id='.$ad_id.'&network='.$network.'&advertise='.$ads[adv_id].'\',\'_blank\',\'\');" /></a></div>
							<div style="z-index: 956; display: block; position: absolute; width: '.$width.'; height: '.$height.';" id="ad_div'.$div_id.'"></div>';
					
		$AdCodeVars = 'var so = new SWFObject("'.$_config[www].'/'.$ads[ad_img].'", "'.$div_id.'", "'.$width.'", "'.$height.'", "8", "#ffffff");
					so.addParam("wmode", "transparent");
					so.write("ad_div'.$div_id.'");';
		
		$AdCode .= '</div>';
	} ///////////////////////////////////////
	
	else {  /////*** Image Ad
		$AdCode .= '<a href="'.$url.'" target="_blank" onclick="return false;"><img src="'.$_config[www].'/'.$ads[ad_img].'" style="border:0; width: '.$width.'; height: '.$height.';" onclick="javascript: window.open(\''.$_config[www].'/popad/?pid='.$pid.'&ad_id='.$ad_id.'&network='.$network.'&advertise='.$ads[adv_id].'\',\'_blank\',\'\');" /></a>';
	}	/////////////////	
		
		
		} else {
		$no_ad = true;
		$AdCode .= '<tr><td align="center" valign="middle" height="'.$height.'"><strong>'.$def_ad_txt.'</strong></td></tr>';
		}
		$AdCode .= '</td></tr></tbody></table></div>';

	if($ur_ad == 'Y')
		$AdCode .= '<div style="cursor: pointer; z-index: 100002; display: block; margin: 0px; overflow: hidden; padding-left: 0px; text-align: center; text-decoration: underline; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center" onclick="javascript: window.open(\''.$_config[www].'/website_page.php?pid='.$pid.'\',\'_blank\',\'\');">Your Ad Here</div>';
	elseif($ur_ad == 'C')
		$AdCode .= '<div style="cursor: pointer; z-index: 100002; display: block; margin: 0px; overflow: hidden; padding-left: 0px; text-align: center; text-decoration: underline; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center"  onclick="javascript: window.open(\''.$_config[www].'/website_page.php?pid='.$pid.'\',\'_blank\',\'\');">'.$ur_ttl.'</div>';

include ("../js/container.js");
}

elseif($res[type] == 'video') {
	$size = mysql_fetch_assoc(mysql_query("select * from video_size where id = '$size_id' "));
	
	$pow = $res[txt_pow_by];
	$ur_ad = $res[your_ad];
	$ur_ttl = $res[yourad_title];
	$pid = $res[pid];
	$width = $size[width];
	$height = $size[height];
	

	if($pow == 'Y')
		$AdCode .= '<div style="cursor: pointer; z-index: 100001; margin: 0px; overflow: hidden; text-align: center; padding-left: 0px; display: block; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center"   onclick="javascript: window.open(\''.$_config[www].'/browse.php\',\'_blank\',\'\');">Powered by '.$_config[website_name].'</div>';

		$AdCode .= '<div style="z-index: 85; display: block; border: 0; margin: 0px; overflow: hidden; padding-left: 2px; width: '.$width.'px; height: '.$height.'px;">
						<table cellpadding="0" cellspacing="0" width="100%"><tbody>
							<tr><td style="vertical-align: top; text-align: left;">';
							
	$qqq = mysql_query("select * from advertisersinfo where pid='$pid' and ((ad_type='vdo_ad' and end_date >= curdate()) or (ad_type='ppc_vdo_ad' and ppc_balance>0)) and start_date <= curdate() and approved='Y' and is_paid='Y' and is_auth='Y' order by rand() limit 1");
	if(mysql_num_rows($qqq)) {
			$ads = mysql_fetch_assoc($qqq);
			$network='N';
			$ad_id = $ads[ad_id];
			$url = $ads[ad_url];
		}
	else {
		$limit = 1;
//		$mq = mysql_query("select ad_id, cost, allow_flash from publishers_adspaces where cost=(select min(cost) from publishers_adspaces where pid='$pid' and ad_type='ppc_vdo_ad') and pid='$pid' and ad_type='ppc_vdo_ad' limit 1");
//		$mcost = mysql_result($mq,0,'cost');
		$ad_space_id = 0;
		$a_flash = mysql_result($mq,0,'allow_flash');
		$flash_qry = '';
		$res_user = mysql_query("select pub_show_net_ads, filter_cat_ids from users where uid='$pub_uid'");
//		$show_net = mysql_result($res_user,0,0);
		$filter_cat_user = mysql_result($res_user,0,1);
		$mcost = mysql_result(mysql_query("select clickrate from publishersinfo where pid='$pid'"),0,0);
		$show_net = mysql_result(mysql_query("select targetedad from publishersinfo where pid='$pid'"),0,0);
		$keyword_pinfo = mysql_result(mysql_query("select keywords from publishersinfo where pid='$pid'"),0,0);
		$res_gids = mysql_query("select gid from pub_geo where pid = '$pid'");
		
		if($show_net == 'Y') {
			
			//pid = website ID
			//pub_uid = user ID
			$filter_cats = explode("#",trim($filter_cat_user,"#"));
			$filter_keywords = explode(",",trim($keyword_pinfo));
			foreach($filter_keywords as $key=>$val){
				$filter_keywords[$key] = trim($val);
			} 
			$filter_geos = array();
			while($rg = mysql_fetch_assoc($res_gids)){
				$filter_geos[] = $rg['gid'];
			}
			
			
			$qry = "select * from adv_campaign where (geo_target is null ";
			foreach($filter_geos as $key=>$val){
				$qry .= " or geo_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and (cat_target is null ";
			
			foreach($filter_cats as $key=>$val){
				$qry .= " or cat_target like '%#" . $val . "#%' ";
			}
			$qry .= ") and (key_target is null ";
			
			foreach($filter_keywords as $key=>$val){
				$qry .= " or key_target like '%#" . $val . "#%' ";
			}
			$qry .= ")   and expense_today < daily_budget  and size='$size_id' and ad_type='vdo' and start_date <= curdate() and remaining_budget>0 and max_cpc >= '$mcost' and approved='Y' and is_paid='Y' and is_auth='Y' order by rand() limit $limit";
			
			$ads = mysql_fetch_assoc(mysql_query($qry));
			$network='Y';
			$ad_id = $ad_space_id;
			$ads[adv_id] = $ads[cmp_id];
			$url = $ads[ad_url];
		}
	}


		$ad_row = $ads;
	if(strlen($ads[ad_img]) > 2) {
		$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$ip=gethostbyname($host_name);
		mysql_query("insert into hits set adv_id = '$ad_row[adv_id]', pub_id = '$ad_row[pid]', ad_id='$ad_row[ad_id]', cmp_id = '0', date=curdate(), ip='$ip', ip_details='$host_name' ");
	
	$div_id = mt_rand(5000, 99999);
		$AdCode .= '<div style="background-color: #000000; display: block; position: relative; width: '.$width.'; height: '.$height.';">

						<a href="'.$url.'" target="_blank" onclick="return false;">
							<div style="z-index: 956; display: block; position: absolute; width: '.$width.'; height: '.$height.';" id="ad_div'.$div_id.'"></div>
						</a>';
					
		$AdCodeVars = 'var so = new SWFObject("'.$_config[www].'/adPlayer.swf", "'.$div_id.'", "'.$width.'", "'.$height.'", "8", "#000000");
					so.addParam("wmode", "opaque");
					so.addVariable("file", "'.$_config[www].'/'.$ads[ad_img].'");
					so.addVariable("ad_url", "'.$_config[www].'/popad/?pid='.$pid.'");
					so.addVariable("ad_id", "'.$ad_id.'");
					so.addVariable("network", "'.$network.'");
					so.addVariable("advertise", "'.$ads[adv_id].'");
					so.write("ad_div'.$div_id.'");';
		
		$AdCode .= '</div>';
		
	} else {
		$no_ad = true;
		$AdCode .= '<tr><td align="center" valign="middle" height="'.$height.'"><strong>'.$def_ad_txt.'</strong></td></tr>';
		}
		$AdCode .= '</td></tr></tbody></table></div>';

	if($ur_ad == 'Y')
		$AdCode .= '<div style="cursor: pointer; z-index: 100002; display: block; margin: 0px; overflow: hidden; padding-left: 0px; text-align: center; text-decoration: underline; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center" onclick="javascript: window.open(\''.$_config[www].'/website_page.php?pid='.$pid.'\',\'_blank\',\'\');">Your Ad Here</div>';
	elseif($ur_ad == 'C')
		$AdCode .= '<div style="cursor: pointer; z-index: 100002; display: block; margin: 0px; overflow: hidden; padding-left: 0px; text-align: center; text-decoration: underline; width: '.$width.'px; font-family: '.$font.'; font-size: 10px;" align="center"  onclick="javascript: window.open(\''.$_config[www].'/website_page.php?pid='.$pid.'\',\'_blank\',\'\');">'.$ur_ttl.'</div>';

include ("../js/container.js");
}

$AdCode = preg_replace('!\s+!', ' ', $AdCode);

?>

document.write('<?=addslashes($AdCode)?>');
<?=$AdCodeVars?>
<?
	if ($no_ad) {
		$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$ip=gethostbyname($host_name);
		mysql_query("insert into hits set pub_id = '".$res[pid]."', date=curdate(), ip='$ip', ip_details='$host_name' ");
	}
?>