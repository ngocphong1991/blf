<?php
include ("../include/config.php");

$pid = isset($_GET[pid])?intval($_GET[pid]):0;

if($pid>0)
  update_domain_age_manual($pid);
  else update_all_domain_age_manual();

function update_all_domain_age_manual(){
		$slq = mysql_query('SELECT pid, url,domain_age FROM publishersinfo WHERE status=2 and domain_age<=0 ORDER BY pid DESC limit 50');

    	while ($row = mysql_fetch_assoc($slq)) {
			$domain  = $row['url'];

			$domain_age = getDomainAge($domain);
			if($domain_age) {
				mysql_query('' . 'UPDATE publishersinfo SET domain_age = \''.$domain_age.'\' WHERE pid=\'' . $row[pid] . '\' LIMIT 1');
				echo 'Update domain age successfuly!';
				echo "<br>";
				echo 'Your domain age: <b>'.timeAgo($domain_age).'</b>';
			}           
			 
		}
		
		
	}
function update_domain_age_manual($pid=0, $domain=''){	
    if($pid<=0) return false;

    $res = mysql_query('' . 'SELECT url FROM publishersinfo WHERE pid=\'' . $pid . '\' LIMIT 1');
    
    if (mysql_num_rows($res)) {
        $domain  = mysql_result($res, 0, 'url');

        $domain_age = getDomainAge($domain);

        if($domain_age) {
            mysql_query('' . 'UPDATE publishersinfo SET domain_age = \''.$domain_age.'\' WHERE pid=\'' . $row[pid] . '\' LIMIT 1');
            echo 'Update domain age successfuly!';
            echo "<br>";
            echo 'Your domain age: <b>'.timeAgo($domain_age).'</b>';
        }
    } 
}
?>