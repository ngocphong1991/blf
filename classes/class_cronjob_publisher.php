<?php 
class Cronjob_publisher extends dbBasic{
	function Cronjob_publisher(){
		$this->pkey = "id";
		$this->tbl = "cronjob_publisher";
	}
	
	function getMissing($pid=0){
		$pid = intval($pid);
		if($pid<=0) return 0;
		
		$res = mysql_query('' . 'SELECT pid FROM cronjob_publisher WHERE pid=\'' . $pid . '\' and cron_time = CURDATE() LIMIT 1');
		if (mysql_num_rows($res)) {             
			return 1;
		}
		else return 0;
		
	}
}
?>