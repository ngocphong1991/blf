<?
include "include/config.php";
include_once("include/zip-files-functions.php");
$filename = 'ad_files/gamedaovang_net.php';
downloadZipFile($filename);

die();
	include "include/config.php";
	$return = get_web_page("http://pagerank.koeniglich.ch/json/dantri.com.vn");
	echo $return;
//include "include/domain-age-functions.php";
die();
include_once("include/domain-age-functions.php");


$url= $_GET[url];
$Rank = google_page_rank($url);


//@ function check VietNam Domain Age
//@ Return timestamp
$domain_age = getDomainAge($url,'xml');
echo timeAgo($domain_age);
echo "<br>";
function getPageRank($domain){
	$return = get_web_page("http://pagerank.koeniglich.ch/json/".trim($domain)."");
	$abc = json_decode($return);
	return trim($abc->rank);
	
}






$url = isset($_GET[url])?$_GET[url]:'dantri.com.vn';
	$ar = alexarank ($url);
	echo "Alexa: <b>".$ar."</b>";
	echo "<br>";
   // $gpr = google_page_rank ($url);
   
	echo "Pagerank: ".$Rank."</b>";
	echo "<br>";
	
	//echo "abc".$url."abc";
	
	
	//$domain_age = getDomainAge($url);
	//echo $domain_age;
	//echo timeAgo($domain_age);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Info</title>
</head>

<body>
<?php

?>
</body>
</html>


