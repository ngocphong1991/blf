<?php
include ("../include/config.php");
if($_SESSION[uid]<=0){
	$arr = array("result"=>"failure","output"=> "");
	echo json_encode($arr);
}

if($_POST[action]=="get_domainage"){
	$url = $_POST[url];
	$pid = $_POST[pid];
	if(isset($url) && $pid>0){
		$domain_age = getDomainAge($url);
		if($domain_age>0)
		updateDomainAge($domain_age,$pid);
		$arr = array("result"=>"success","output"=> "This website has been updated.");
	}
	echo json_encode($arr);
}

?>
