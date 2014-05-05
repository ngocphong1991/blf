<?php
include ("include/config.php");
//require('classes/class_publishersinfo.php');
//$cls_Publishersinfo = new Publishersinfo();

header('Content-type: text/xml');
$_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if(isset($_GET['k'])){
	$url_root = mysql_real_escape_string(trim($_GET['url_root']));
	$uri = mysql_real_escape_string(trim(urldecode($_GET['uri'])));
	$script= mysql_real_escape_string(strip_tags(trim($_GET['k'])));
	
	$advertise_avaiable = false;
	if($script){		
		$sql_string = "select status, url from publishersinfo where script='".$script."' LIMIT 1 ";
				
		$sql_obj = mysql_query($sql_string);	
		if(mysql_num_rows($sql_obj)) {
			$domain = mysql_result($sql_obj, 0, 'url');	
			//$true_domain = getTrueDomain(getDomainName($domain,'domain'));
			//if($true_domain==getTrueDomain(getDomainName($url_root,'domain')))
			$status = mysql_result($sql_obj, 0, 'status');	
			updateStatus(2, 0, $script, $url_root);			
			$advertise_avaiable = true;
		}
	}	
} 
$_xml .= "<Links>\n";
//@$row2 = mysql_fetch_array($result2);
    //php loop to get information from properties table and parse into the feed
    //for ($i = 0; $i < mysql_num_rows($result1); $i++) {  
$_xml .= "<Link>\n";
if($advertise_avaiable){
	$sql_advertise = "select distinct advertisersinfo.adv_id, advertisersinfo.pid, advertisersinfo.ad_url, advertisersinfo.ad_des,advertisersinfo.ad_before,advertisersinfo.ad_after, advertisersinfo.end_date from publishersinfo, advertisersinfo where publishersinfo.script='".$script."' and publishersinfo.pid=advertisersinfo.pid and advertisersinfo.is_paid='Y' and advertisersinfo.start_date<=CURDATE() and advertisersinfo.end_date>=CURDATE() ";
	//echo $sql_advertise;
	//echo $sql_advertise;
	$sql_adv_obj = mysql_query($sql_advertise);		
	if(mysql_num_rows($sql_adv_obj)) {
		while ($row = mysql_fetch_assoc($sql_adv_obj)) {
			if($row[end_date] < date("Y-m-d")){
				mysql_query('' . 'UPDATE advertisersinfo SET is_paid = \'N\' WHERE adv_id=\'' . $row[adv_id] . '\' LIMIT 1');
				continue;
			}
			$_xml .= "<LinkID>".$row[pid]."</LinkID>\n";
			$_xml .= "<URL>".$row[ad_url]."</URL>\n";
			$_xml .= "<Text>".$row[ad_des]."</Text>\n";
			$_xml .= "<BeforeText>".$row[ad_before]."</BeforeText>\n";
			$_xml .= "<AfterText>".$row[ad_after]."</AfterText>\n"; 
			}
	}else{
		
	} 
}
	$_xml .= "</Link>\n";
   
//}
 // check today avaiable
 // if(this key not exit please notify to publisher);
 $_xml .= "</Links>\n";

print $_xml; 
