<?php
include ("../include/config.php");
header('Content-type: text/xml');
$_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if(isset($_GET['k'])){
	$script= mysql_real_escape_string(strip_tags(trim($_GET['k'])));
	$ws_qry = "select distinct advertisersinfo.* from publishersinfo, advertisersinfo where publishersinfo.script=".$script." and publishersinfo.uid= " . $_SESSION['uid'] . " and publishersinfo.pid=advertisersinfo.pid";
	
	$ws = mysql_query("$ws_qry");
	while ($row = @mysql_fetch_assoc($ws)) {
		
	}
}
 
$_xml .= "<Links>\n";
//@$row2 = mysql_fetch_array($result2);
    //php loop to get information from properties table and parse into the feed
    //for ($i = 0; $i < mysql_num_rows($result1); $i++) {  
    $_xml .= "<Link>\n";
    $_xml .= "<LinkID>OI698248</LinkID>\n";
    $_xml .= "<URL>http://netlink.vn</URL>\n";
    $_xml .= "<Text>NetLink</Text>\n";
    $_xml .= "<BeforeText>Truy cập </BeforeText>\n";
    $_xml .= "<AfterText>Để biết thêm thông tin</AfterText>\n";  
    $_xml .= "</Link>\n";
   
//}
 // check today avaiable
 // if(this key not exit please notify to publisher);
 $_xml .= "</Links>\n";

print $_xml; 
