<?php
date_default_timezone_set('Asia/Bangkok');
require_once("../include/db_connection.php");
checkupdate_publisher();
function checkupdate_publisher(){
    	$res_date = "SELECT pid, update_date FROM publishersinfo WHERE update_date <> '".date('Y-m-d')."' ORDER BY pid DESC LIMIT 100";
		
		$sql_adv_obj = mysql_query($res_date);		
		while ($row = mysql_fetch_assoc($sql_adv_obj)) {
			print_r($row);			
		
			echo 'update<br>';
			echo '' . 'update `publishersinfo` set  `status`=\'1\'  where pid=\'' . intval($row[pid]) . '\'';
			mysql_query('' . 'update `publishersinfo` set  `status`=\'1\'  where pid=\'' . intval($row[pid]) . '\'');
		
	}
	return false;
}	
?>
