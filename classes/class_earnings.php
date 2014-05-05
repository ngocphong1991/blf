<?php 
class Earnings extends dbBasic{
	function Earnings(){
		$this->pkey = "earn_id";
		$this->tbl = "earnings";
	}

function getSiteEarning($pid, $adv_id){
	$pid = intval($pid);
	$adv_id = intval($adv_id);
	if($pid<=0 || $adv_id<=0) return 0;
	$total_money = 0;
	$res_adv = mysql_query('' . 'SELECT sum(earnings) as total FROM earnings WHERE pid=\'' . $pid . '\' and adv_id =\'' . $adv_id . '\' LIMIT 1');
	if (mysql_num_rows($res_adv)) {             
		$total_money      = mysql_result($res_adv, 0, 'total');	
		return $total_money;
	}
	return 0;
	}
}	
?>