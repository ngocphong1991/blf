<?php
//read rss
include ("include/config.php");
$script= mysql_real_escape_string(strip_tags(trim($_GET['k'])));
if(!$script) exit();

	$sql_advertise = "select distinct advertisersinfo.pid, advertisersinfo.ad_url, advertisersinfo.ad_des,advertisersinfo.ad_before,advertisersinfo.ad_after from publishersinfo, advertisersinfo where publishersinfo.script='".$script."' and publishersinfo.pid=advertisersinfo.pid";

$now = date("D, d M Y H:i:s T");
/*
$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <rss version=\"2.0\">
                <channel>
                    <title>Textlink Ads</title>
                    <link>http://textlink.vn/RSS.php</link>
                    <description>Textlink ad market</description>
                    <language>en-us</language>
                    <pubDate>$now</pubDate>
                    <lastBuildDate>$now</lastBuildDate>
                    <docs>http://textlink.vn</docs>
                    <managingEditor>admin@textlink.vn</managingEditor>
                    <webMaster>admin@textlink.vn</webMaster>
            ";
            
*/

$output .= "</channel></rss>";
header("Content-Type: application/rss+xml");
echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>Textlink ads</title>
    <description>Textlink ads network</description>
    <link>http://textlink.vn/</link>
    <copyright>textlink.vn</copyright>
    <generator>textlink.vn</generator>
	<pubDate>'.$now.'</pubDate>
    <lastBuildDate>'.$now.'</lastBuildDate>';
	$sql_adv_obj = mysql_query($sql_advertise);		
if(mysql_num_rows($sql_adv_obj)) {
	while ($row = mysql_fetch_assoc($sql_adv_obj)) {	
		echo '<item>
			<title><![CDATA[ '.$row[ad_before].' '.$row["ad_des"].' '.$row[ad_after].' ]]></title>
			<description><![CDATA['.$row["ad_des"].'. ]]></description>
			<link>'.htmlentities($row[ad_url]).'</link>
			<pubDate>'.$now.'</pubDate>
		</item>';	
		 //$output .= "<item><title>".htmlentities($row[ad_before])." ".htmlentities($row[ad_des])." ".htmlentities($row[ad_after])."</title><link>".htmlentities($row[ad_url])."</link><description>".htmlentities(strip_tags($row['ad_des']))."</description></item>";				
		}
}		

 echo ' </channel>

</rss>';
?>