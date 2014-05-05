<?php

if(!isset($_GET[cmd]) || ($_GET[cmd] != 'track')) exit();

include ("../include/config.php");

$req = $_SERVER['HTTP_REFERER'];
$url = parse_url($req);
$www = $url[host];
$res = mysql_query("select * from advertisersinfo where ad_url like '%$www%' and approved='Y' and is_paid='Y' and is_auth='Y' and 

				( 
					( (advertisersinfo.ad_type='txt_ad' or advertisersinfo.ad_type='img_ad' or advertisersinfo.ad_type='vdo_ad') and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type='ppc_txt_ad' or advertisersinfo.ad_type='ppc_img_ad' or advertisersinfo.ad_type='ppc_vdo_ad') and advertisersinfo.ppc_balance>0 )
				)");

while ($r = mysql_fetch_assoc($res))
	mysql_query("insert into hits set adv_id='$r[adv_id]', is_sale='1', pub_id='$r[pid]', date=curdate(), ad_id='$r[ad_id]' ");
exit();
?>