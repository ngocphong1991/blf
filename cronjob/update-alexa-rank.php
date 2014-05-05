<?php
include ("../include/config.php");
updateAlexaRank();
function updateAlexaRank(){	
	$slq ="select pid, update_rank, url from publishersinfo where update_status > ".(time() - 24*3600)." and status = 2 ";
	
	$order_by = " order by update_rank ASC limit 10";
	$money_earn_obj = mysql_query($slq.$order_by);
	$arr = array();
    while ($row = mysql_fetch_assoc($money_earn_obj)) {
		$page_rank = google_page_rank($row[url]);		
		$alexa_rank = alexarank($row[url]);
		$arr[] = array('pid'=>$row[pid], 'google_page_rank'=>$page_rank, 'alexa_rank'=>$alexa_rank);
		//$arr[alexa_rank] = $alexa_rank;		
		sleep(1);
	}
	if($arr && is_array($arr)){
		foreach($arr as $key=>$rank_arr){
			if(intval($rank_arr['google_page_rank'])>0 && intval($rank_arr['alexa_rank'])>0){
				mysql_query('' . 'update `publishersinfo` set  `google_page_rank`=\'' . intval($rank_arr['google_page_rank']) . '\' , `alexa_rank`=\'' . intval($rank_arr['alexa_rank']) . '\', `update_rank`=\'' . time() . '\' where pid=\'' . $rank_arr['pid'] . '\'');
			}elseif(intval($rank_arr['google_page_rank'])>0){
				mysql_query('' . 'update `publishersinfo` set  `google_page_rank`=\'' . intval($rank_arr['google_page_rank']) . '\' `update_rank`=\'' . time() . '\' where pid=\'' . $rank_arr['pid'] . '\'');
			}elseif(intval($rank_arr['alexa_rank'])>0){
				mysql_query('' . 'update `publishersinfo` set `alexa_rank`=\'' . intval($rank_arr['alexa_rank']) . '\', `update_rank`=\'' . time() . '\' where pid=\'' . $rank_arr['pid'] . '\'');
			}
			else continue;
		}	
	}
}
?>