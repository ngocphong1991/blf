<?php
class convert {
    function convert($source, $destination) {
        $cmd     = 'which mencoder';
        $ok_fail = $ok;
        $font    = $green;
        exec('' . $cmd . ' 2>&1', $output);
        foreach ($output as $outputline) {
			
        }
        exec('' . $outputline . ('' . ' ' . $source . ' -o ' . $destination . ' -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=500:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames -srate 22050'));
    }
}

function load_config() {
    $res = mysql_query('SELECT * FROM configurations');
    $_config = array();
    while ($row = mysql_fetch_assoc($res)) {
        $n   = $row['name'];
        $v   = $row['value'];
        $str = '$_config[\'' . $n . '\'] = "' . stripslashes($v) . '";';
        eval($str);
    }
    
    return $_config;
}

function strtonum($Str, $Check, $Magic) {
    $Int32Unit = 4294967296;
    $length    = strlen($Str);
    $i         = 0;
    while ($i < $length) {
        $Check *= $Magic;
        if ($Int32Unit <= $Check) {
            $Check = $Check - $Int32Unit * (int) $Check / $Int32Unit;
            $Check = ($Check < 0 - 2147483648 ? $Check + $Int32Unit : $Check);
        }
        
        $Check += ord($Str[$i]);
        ++$i;
    }
    
    return $Check;
}

function hashurl($String) {
    $Check1 = strtonum($String, 5381, 33);
    $Check2 = strtonum($String, 0, 65599);
    $Check1 >>= 2;
    $Check1 = $Check1 >> 4 & 67108800 | $Check1 & 63;
    $Check1 = $Check1 >> 4 & 4193280 | $Check1 & 1023;
    $Check1 = $Check1 >> 4 & 245760 | $Check1 & 16383;
    $T1     = (($Check1 & 960) << 4 | $Check1 & 60) << 2 | $Check2 & 3855;
    $T2     = (($Check1 & 4294950912) << 4 | $Check1 & 15360) << 10 | $Check2 & 252641280;
    return $T1 | $T2;
}

function checkhash($Hashnum) {
    $CheckByte = 0;
    $Flag      = 0;
    $HashStr   = sprintf('%u', $Hashnum);
    $length    = strlen($HashStr);
    $i         = $length - 1;
    while (0 <= $i) {
        $Re = $HashStr[$i];
        if (1 === $Flag % 2) {
            $Re += $Re;
            $Re = (int) $Re / 10 + $Re % 10;
        }
        
        $CheckByte += $Re;
        ++$Flag;
        --$i;
    }
    
    $CheckByte %= 10;
    if (0 !== $CheckByte) {
        $CheckByte = 10 - $CheckByte;
        if (1 === $Flag % 2) {
            if (1 === $CheckByte % 2) {
                $CheckByte += 9;
            }
            
            $CheckByte >>= 1;
        }
    }
    
    return '7' . $CheckByte . $HashStr;
}

function get_pagerank($url) {
    $pagerank = 0;
    $fp = fsockopen('toolbarqueries.google.com', 80, $errno, $errstr, 30);
    if (!$fp) {
        echo '' . $errstr . ' (' . $errno . ')<br />';
        return null;
    }
    
    $out = 'GET /search?client=navclient-auto&ch=' . checkhash(hashurl($url)) . '&features=Rank&q=info:' . $url . '&num=100&filter=0 HTTP/1.1';
    $out .= 'Host: toolbarqueries.google.com';
    $out .= 'User-Agent: Mozilla/4.0 (compatible; GoogleToolbar 2.0.114-big; Windows XP 5.1)';
    $out .= 'Connection: Close';
    fwrite($fp, $out);
    while (!feof($fp)) {
        $data = fgets($fp, 128);
        $pos  = strpos($data, 'Rank_');
        if ($pos === false) {
            continue;
        } else {
            $pagerank = substr($data, $pos + 9);
            continue;
        }
    }
    
    fclose($fp);
    return $pagerank;
}

function safe_entry($value) {
    return trim($value);
}

function login($user, $pass) {
    $res = mysql_query('' . 'SELECT * FROM users WHERE password=\'' . md5(mysql_real_escape_string(strip_tags(trim($pass)))) . '\' AND username=\'' . mysql_real_escape_string(strip_tags(trim($user))) . '\' LIMIT 1');
    if (mysql_num_rows($res)) {
        if (!mysql_result($res, 0, 'status')) {
            return 'suspended';
        }        
        $_SESSION['uid']      = mysql_result($res, 0, 'uid');
        $_SESSION['username'] = mysql_result($res, 0, 'username');
		$_SESSION['fullname'] = mysql_result($res, 0, 'fullname');
		$_SESSION['adv_money'] = mysql_result($res, 0, 'adv_money');
		$_SESSION['pub_money'] = mysql_result($res, 0, 'pub_money');
        $_SESSION['utype']    = mysql_result($res, 0, 'utype');
        $_SESSION['email']    = mysql_result($res, 0, 'email');
        if ($_SESSION['utype'] == 'pub+adv') {
            $_SESSION['show_pub_stat'] = 'Y';
        } else {
            $_SESSION['show_pub_stat'] = 'N';
        }
        
        mysql_query('' . 'UPDATE users SET last_login=curdate() WHERE password=\'' . $pass . '\' AND username=\'' . $user . '\' LIMIT 1');
        return 'ok';
    }
    
    return false;
}

function admin_login($user, $pass) {
    $res = mysql_query('' . 'SELECT * FROM admin WHERE pass=\'' . md5($pass) . '\' AND user=\'' . $user . '\' LIMIT 1');
    if (mysql_num_rows($res)) {
        $_SESSION['admin_uid']      = mysql_result($res, 0, 'uid');;
        $_SESSION['admin_username'] = mysql_result($res, 0, 'user');
        $_SESSION['admin_utype']    = mysql_result($res, 0, 'utype');
        $_SESSION['email']          = mysql_result($res, 0, 'email');
        $_SESSION['last_login']     = mysql_result($res, 0, 'last_login');
        return true;
    }
    
    return false;
}

function alexathumb($domain) {
    $domain = trim($domain);
    $tmp    = explode('http://', $domain);
    $domain = $tmp[1];
    if (eregi('www.', $domain)) {
        $tm     = explode('www.', $domain);
        $domain = $tm[1];
    }
    
    $remote_url = 'http://alexa.com/data/details/traffic_details/' . $domain;
    $part       = '';
    $search_for = 'Visit http://aws.amazon.com/awis for more information about the Alexa Web Information Service.-->';
    if ($handle = @fopen($remote_url, 'r')) {
        if (!feof($handle)) {
            $part .= fread($handle, 100);
            $pos = strpos($part, $search_for);
            if ($pos === false) {
                continue;
            }
            
            break;
        }
        
        $part .= fread($handle, 100);
        fclose($handle);
    }
    
    $tmp       = 'http://ast.amazonaws.com/Xino/?Action=Redirect&Service=AlexaSiteThumbnail&Url=';
    $thumb     = explode($tmp, $part);
    $_thumb    = array_shift(explode('"', $thumb[1]));
    $thumb_src = $tmp . $_thumb;
    return $thumb_src;
}

function alexarank($domain) {
    $url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;

    //Initialize the Curl
    $ch = curl_init();
    //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

    //Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    //Execute the fetch
    $data = curl_exec($ch);

    //Close the connection
    curl_close($ch);

    $xml = new SimpleXMLElement($data);

    //Get popularity node
    $popularity = $xml->xpath("//POPULARITY");

    //Get the Rank attribute
    $rank = (string)$popularity[0]['TEXT'];

    return $rank;
}

function google_page_rank($url) {
    if (0 < strlen(trim($url))) {
        $_url     = getTrueDomain($url);
		$return = get_web_page("http://pagerank.koeniglich.ch/json/".trim($_url));

		if(function_exists('json_decode')){
			 $page_rank = json_decode($return);
			 $pagerank = trim($page_rank->rank);
		}else $pagerank=0;

		/*
        $pagerank = trim(get_pagerank($_url));
		*/
        if (empty($pagerank)) {
            $pagerank = 0;
        }
        return (int) $pagerank;
    }
    
    return 0;
}

function copy_remote_file($url, $dest_file_name) {
    if (file_exists($dest_file_name)) {
        unlink($dest_file_name);
    }
    
    $content = file_get_contents($url);
    $dir     = dirname($_SERVER['SCRIPT_FILENAME']);
    $fp      = fopen($dir . '/' . $dest_file_name, 'w');
    fwrite($fp, $content);
    fclose($fp);
}

function get_list($tbl, $ord, $where='') {

    $res = mysql_query('' . 'select * from ' . $tbl . $where .' order by ' . $ord);
    while ($row = mysql_fetch_assoc($res)) {
        foreach ($row as $key => $val) {
            $c[$key][] = stripslashes($val);
        }
    }
    
    return $c;
}

function getLangName($langid) {
	if($langid>0){

		$res = mysql_query('' . 'SELECT * FROM language WHERE lid=' . $langid . '  LIMIT 1');
    if (mysql_num_rows($res)) {      
       $lang_name = mysql_result($res, 0, 'language');
        return $lang_name;
    }else
		return 'English';
	}
	return 'English';
}

function get_payment_methods() {
    $res = mysql_query('select * from payment_methods order by name');
    while ($row = mysql_fetch_assoc($res)) {
        $info[] = $row;
    }
    
    return $info;
}

function update_user($post_vars) {
    foreach ($post_vars as $key => $value) {
        if ($key == 'text_ad_pass') {
            $post[$key] = $value;
            continue;
        }
        
        $post[$key] = mysql_real_escape_string(strip_tags(trim($value)));
    }
    
    if ((($post[company] != '' AND $post[pinfo] != '') AND $post[pm_id] != '')) {
        $utype = 'pub+adv';
    } else {
        $utype = 'adv';
    }
    
    $p = '';
    if ($post[text_ad_pass] != '') {
        $p = '' . 'password=\'' . $post['text_ad_pass'] . '\',';
    }
    
    $res = mysql_query('' . 'update `users` set ' . $p . ' `utype`=\'' . $utype . '\' , `fullname`=\'' . $post['fname'] . '\' , `email`=\'' . $post['email'] . '\' , `address`=\'' . $post['address'] . '\' , `city`=\'' . $post['city'] . '\' , `state`=\'' . $post['state'] . '\' , `country`=\'' . $post['country'] . '\' , `zip`=\'' . $post['zip'] . '\' , `phone`=\'' . $post['phone'] . '\' , `company`=\'' . $post['company'] . '\' , `paymethod_id`=\'' . $post['pm_id'] . '\' , `paymethod_info`=\'' . $post['pinfo'] . '\' where uid=\'' . $_SESSION['uid'] . '\' ');
    if ($res) {
        return true;
    }
    
    return false;
}

function quick_register_new_user($post_vars) {
    global $_config;
    if (!isset($_config)) {
        $_config = load_config();
    }

    foreach ($post_vars as $key => $value) {
        if ($key == 'password') {
            $post[$key] = $value;
            continue;
        }
        $post[$key] = mysql_real_escape_string(strip_tags(trim($value)));
    }

    if (!($res = mysql_query('' . 'INSERT INTO `users` (`username` , `password` , `utype` , `fullname` , `email` , `address` , `city` , `state` , `country` , `zip` , `phone` , `company` , `paymethod_id` , `paymethod_info` , `getnewsletter` , `status`,balance , last_money_sent , pub_show_net_ads , filter_cat_ids, signup_date, last_login, ref_code) VALUES ( \'' . $post['username'] . '\', \'' . md5($post['password']) . '\', \'pub+adv\', \'\', \'' . $post['email'] . '\', \'\', \'' . $post['city'] . '\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\' , \'1\', 0, \'0000-00-00\', \'N\', \'\', curdate(), curdate(), \'\' ) '))) {
        exit(mysql_error());
    }
    if($res) return true;
    else return false;
}
function register_new_user($post_vars) {
    global $_config;
    if (!isset($_config)) {
        $_config = load_config();
    }
    
    foreach ($post_vars as $key => $value) {
        if ($key == 'text_ad_pass') {
            $post[$key] = $value;
            continue;
        }        
        $post[$key] = mysql_real_escape_string(strip_tags(trim($value)));
    }
    
	if(!$post['utype']){
		if ( $post['pm_id'] != '' || $post['is_publisher']=='both'){
			$utype = 'pub+adv';
		} else {
			if($post['is_publisher']=='N') $utype = 'adv';
			else $utype = 'pub';
		}
	}else $utype = $post['utype'];
	
    if ($_config['approve_new_user'] == 'yes') {
        $status = 2;
    } else {
        $status = 1;
    }
    
    if ($post['getNewsLetter'] == '') {
        $post['getNewsLetter'] = 'N';
    }
    $ref_code =  isset($_SESSION[ref])?$_SESSION[ref]:'';	

    if (!($res = mysql_query('' . 'INSERT INTO `users` (`username` , `password` , `utype` , `fullname` , `email` , `address` , `city` , `state` , `country` , `zip` , `phone` , `company` , `paymethod_id` , `paymethod_info` , `getnewsletter` , `status`,balance , last_money_sent , pub_show_net_ads , filter_cat_ids, signup_date, last_login, ref_code) VALUES ( \'' . $post['username'] . '\', \'' . md5($post['text_ad_pass']) . '\', \'' . $utype . '\', \'' . $post['fname'] . '\', \'' . $post['email'] . '\', \'' . $post['address'] . '\', \'' . $post['city'] . '\', \'' . $post['state'] . '\', \'' . $post['country'] . '\', \'' . $post['zip'] . '\', \'' . $post['phone'] . '\', \'' . $post['company'] . '\', \'' . $post['pm_id'] . '\', \'' . $post['pinfo'] . '\', \'' . $post['getNewsLetter'] . '\' , \'' . $status . '\', 0, \'0000-00-00\', \'N\', \'\', curdate(), curdate(), \'' . $ref_code . '\' ) '))) {
        exit(mysql_error());
    }
    
    if ($res) {
        include_once 'utils/EmailUtils.php';
        if ($_config['approve_new_user'] == 'no') {
            login($post['username'], $post['text_ad_pass']);
        }
        
        if ($_config['get_email_notification'] == 'yes') {
            $to      = $_config['admin_email'];
            $subject = 'New Account Registration';
            $message = '' . '
				<html>
				<head>
				 <title>New Account Registration</title>
				</head>
				<body>
				 <p>New user has been registered on ur site. </p>
				 


Username:  ' . $post['username'] . '<br />

<br />
<br />
<br />
<br />



Regards<br />
<br />


' . $_config['website_name'] . '<br />' . $_config['www'] . '<br />

				</body>
				</html>
				';
            $headers = 'MIME-Version: 1.0' . '';
            $headers .= 'Content-type: text/html; charset=utf-8' . '';
            $headers .= '' . 'To: ' . $_config['website_name'] . '<' . $_config['admin_email'] . '>' . '';
            $headers .= '' . 'From: ' . $_config['website_name'] . '<' . $_config['admin_email'] . '>' . '';
            mail($to, $subject, $message, $headers);
        } //end to send email notify to admin
        
		include_once("libs/template.mail.php");
		$type ="register";
		mailTemplates($post['email'], $post[username], $type, $utype);
        //sendMail($to,$subject,$message);
        //logFile($message);
        return true;
    }
    
    return false;
}

//get all case Publisher info
function getListPublisherInfo($pid=0,$keyword="",$type='',$catId=0, $link_score=0, $langid=0){	
	$catId = intval($catId);
	$link_score = intval($link_score);
	$langid = intval($langid);
	$slq ="select * from publishersinfo";
	if($link_score>0)
		$sWhere = " where google_page_rank >= $link_score ";
	else 
		$sWhere = " where pid>0 ";
	
	if($keyword)
		$sWhere .= " AND (websitename like '%$keyword%') OR (keywords LIKE '%$keyword%')";
	
	if($langid>0)
		$sWhere .= " AND langid = $langid ";
	
	$sWhere .= " AND sale_price>0 ";
	$order_by = " order by pid DESC";	
	
	$res = mysql_query($slq.$sWhere.$order_by);
    while ($row = mysql_fetch_assoc($res)) {
	if($catId>0){
		$catids = explode(" , ", $row['catIds']);
			if(!in_array($catId, $catids)) {
				 continue;
			}
		}
        $info[] = $row;
    }

 	$count = count($info);
    return array('total'=>$count, 'info'=>$info);
}


//getListPublisherInfo(0, '%wordpress%','',2);

function register_new_publisher($post_vars) {
    global $_config;
    if (!isset($_config)) {
        $_config = load_config();
    }

    foreach ($post_vars as $key => $value) {
        if ($key == 'url') {
            $post[$key] = trim($value);
            continue;
        }
        
        $post[$key] = strip_tags(trim($value));
    }
    
    if ($_config['approve_new_site'] == 'yes') {
        $status = 2;
    } else {
        $status = 1;
    }
    
    $ar            = alexarank($post['url']);	
   // $gpr           = google_page_rank($post['url']);
    
	$script_code = unique_id(20);
    //$domain_age = getDomainAge(addslashes($post['url']));
	$domain_age = 0;
    $res           = mysql_query('' . 'INSERT INTO `publishersinfo` ( `pid` , `uid` , `websitename` , `url` , `description` , `catid` , `subcatid` , `keywords` , `targetedad` , `clickrate` , `isadult` , `langid` , `adposition` , `isrestricted` , `restriction` , `alexa_rank`, `domain_age`, member_since, pay_rate, status, script )
							VALUES (NULL , \'' . $_SESSION['uid'] . '\', \'' . $post['wname'] . '\', \'' . $post['url'] . '\', \'' . $post['wdes'] . '\', \'' . $post['cats'] . '\', \'' . $post['subcats'] . '\', \'' . $post['keywords'] . '\', \'' . $post['tad'] . '\', \'' . $post['clickrate'] . '\', \'' . $post['isadult'] . '\', \'' . $post['lang'] . '\', \'' . $post['adposition'] . '\', \'' . $post['isrestricted'] . '\', \'' . $post['restriction'] . '\',\'' . $ar . '\',\'' . $domain_age . '\',  curdate(), 0, \'' . $status . '\', \'' . $script_code . '\' )');
    $pid           = mysql_insert_id();
    $_SESSION['pid'] = $pid;
	
	/*
    $sid           = mysql_result(mysql_query('SELECT id FROM `text_size` LIMIT 1'), 0, 0);
    mysql_query('' . 'INSERT INTO pub_ad_code SET uid=\'' . $_SESSION['uid'] . '\', pid=\'' . $pid . '\', type=\'text\',`txt_total_ads`=\'5\' , `txt_hl_len`=\'25\' , `txt_des_len`=\'70\' , `txt_border_c`=\'0000FF\' , `txt_bg_c`=\'FFFFFF\' , `txt_hl_c`=\'0000FF\' , `txt_des_c`=\'000000\' , `txt_font`=\'Verdana\' , `txt_hl_size`=\'11px\' , `txt_des_size`=\'10px\' , `txt_pow_by`=\'Y\' , `your_ad`=\'Y\' , `yourad_title`=\'\' , `txt_hl_U`=\'Y\' , `txt_hl_B`=\'Y\' , `img_vdo_size_id`=\'' . $sid . '\' ');
	*/
    /*$at = alexathumb($post['url']);
    $rf = 'wwwThumb/thumb_' . $pid . '_pic.jpg';
    copy_remote_file($at, $rf);
	
    $i = 0;
    while ($i < count($post_vars['dest'])) {
        $gid = $post_vars['dest'][$i];
        mysql_query('' . 'INSERT INTO pub_geo SET pid=\'' . $pid . '\', gid=\'' . $gid . '\'');
        ++$i;
    }
    */
    if ($res) {
        return $pid;
    }
    
    return false;
}


function register_new_publisher_step($post_vars) {
    global $_config;
    if (!isset($_config)) {
        $_config = load_config();
    }
    
    foreach ($post_vars as $key => $value) {
        if ($key == 'url') {
            $post[$key] = trim($value);
            continue;
        }
        
        $post[$key] = strip_tags(trim($value));
    }
    
    if ($_config['approve_new_site'] == 'yes') {
        $status = 2;
    } else {
        $status = 1;
    }
    
    $ar = 0;
    $gpr = 0;

    $res = mysql_query('' . 'INSERT INTO `publishersinfo` ( `pid` , `uid` , `websitename` , `url` , `description` , `catid` , `subcatid` , `keywords` , `targetedad` , `clickrate` , `isadult` , `langid` , `adposition` , `isrestricted` , `restriction` , `google_page_rank` , `alexa_rank`, member_since, pay_rate, status )
							VALUES (NULL , \'' . $_SESSION['uid'] . '\', \'' . $post['wname'] . '\', \'' . $post['url'] . '\', \'' . $post['wdes'] . '\', \'' . $post['cats'] . '\', \'' . $post['subcats'] . '\', \'' . $post['keywords'] . '\', \'' . $post['tad'] . '\', \'' . $post['clickrate'] . '\', \'' . $post['isadult'] . '\', \'' . $post['lang'] . '\', \'' . $post['adposition'] . '\', \'' . $post['isrestricted'] . '\', \'' . $post['restriction'] . '\', \'' . $gpr . '\', \'' . $ar . '\', curdate(), 0, \'' . $status . '\' )');
    $pid           = mysql_insert_id();
    $_SESSION['pid'] = $pid;
	
    /*$at = alexathumb($post['url']);
    $rf = 'wwwThumb/thumb_' . $pid . '_pic.jpg';
    copy_remote_file($at, $rf);*/
	/*
    $i = 0;
    while ($i < count($post_vars['dest'])) {
        $gid = $post_vars['dest'][$i];
        mysql_query('' . 'INSERT INTO pub_geo SET pid=\'' . $pid . '\', gid=\'' . $gid . '\'');
        ++$i;
    }
    */
    if ($res) {
        return $pid;
    }
    
    return false;
}


function update_publisher($post_vars, $type="update") {
    foreach ($post_vars as $key => $value) {
        if ($key == 'url') {
            $post[$key] = trim($value);
            continue;
        }
        
        $post[$key] = strip_tags(trim($value));
		
    }
	$catIds = "0";
	for($idx=1; $idx<=3; $idx++){
		if($post["cats".$idx]>0)
		$catIds .=  " , ".$post["cats".$idx];
		else continue;
	}    
	
	$post['wname'] = mysql_real_escape_string(strip_tags(trim($post['wname'])));
	$post['wdes'] = mysql_real_escape_string(strip_tags(trim($post['wdes'])));
    $post['wsale'] = isset($post['wsale']) && is_numeric($post['wsale']) ? $post['wsale'] : 0 ;
	$pid = intval($post[pid]);

   if($type=="update_cat")
   { 
   		$gpr = google_page_rank($post[url]);
   		$res = mysql_query('' . 'update `publishersinfo` set  `catid`=\'' . $post['cats'] . '\' ,`adposition`=\'' . $post['adposition'] . '\', `langid`=\'' . $post['langid'] . '\', `catIds`=\'' . $catIds . '\', `google_page_rank`=\'' . $gpr . '\'  where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' . $_SESSION['pid'] . '\'');
        if($res && $_SESSION[email]){
        //sendmail
        include_once("libs/template.mail.php");
        $to_email      =  $_SESSION[email];
        $type ="publisher_add_site";
        $publisher_arr = array();
        $publisher_arr[pid]= $_SESSION[pid];
        $publisher_arr[url]= $post[url];
        $to_username=$_SESSION[fullname];

        mailTemplates($to_email, $to_username, $type, '', $publisher_arr);

	}
		
   }elseif($type=="edit"){
   		$res = mysql_query('' . 'update `publishersinfo` set `websitename`=\'' . $post['wname'] . '\', `description`=\'' . $post['wdes'] . '\', `sale_price`=\'' . $post['wsale'] . '\', `set_price`=\'' . $post['wsale'] . '\', `keywords`=\'' . $post['keywords'] . '\',`catid`=\'' . $post['cats'] . '\' , `catIds`=\'' . $catIds . '\'  where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' . $pid . '\'');
   }elseif($type=="all"){
	   $url = getURLPulisher($pid);
	   if($url){
		   $gpr = google_page_rank($url);
		   $ar  = alexarank($url);
	   }
	   if($gpr>0 && $ar>0){
	 	  $res = mysql_query('' . 'update `publishersinfo` set `websitename`=\'' . $post['wname'] . '\', `description`=\'' . $post['wdes'] . '\', `keywords`=\'' . $post['keywords'] . '\',`catid`=\'' . $post['cats'] . '\' , `catIds`=\'' . $catIds . '\', `langid`=\'' . $post[langid] . '\',`google_page_rank`=\'' . $gpr . '\', `alexa_rank`=\'' . $ar . '\', `adposition`=\'' . $post['adposition'] . '\', `sale_price`=\'' . $post['wsale'] . '\', `set_price`=\'' . $post['wsale'] . '\', `restriction`=\'' . $post['restriction'] . '\', `approval_method`=\'' . $post['approval_method'] . '\' where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' .  $pid . '\'');
	   }else
   		$res = mysql_query('' . 'update `publishersinfo`set `websitename`=\'' . $post['wname'] . '\', `description`=\'' . $post['wdes'] . '\', `keywords`=\'' . $post['keywords'] . '\',`catid`=\'' . $post['cats'] . '\' , `catIds`=\'' . $catIds . '\', `langid`=\'' . $post[langid] . '\', `adposition`=\'' . $post['adposition'] . '\' ,`restriction`=\'' . $post['restriction'] . '\', `sale_price`=\'' . $post['wsale'] . '\', `set_price`=\'' . $post['wsale'] . '\', `approval_method`=\'' . $post['approval_method'] . '\' where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' .  $pid . '\'');
   }else{
   	// $ar  = alexarank($post[url]);
   	 	$res = mysql_query('' . 'update `publishersinfo` set `websitename`=\'' . $post['wname'] . '\', `url`=\'' . $post['url'] . '\', `sale_price`=\'' . $post['wsale'] . '\', `set_price`=\'' . $post['wsale'] . '\', `description`=\'' . $post['wdes'] . '\', `catid`=\'' . $post['cats'] . '\' , `catIds`=\'' . $catIds . '\'  where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' . $_SESSION['pid'] . '\'');
   }
   
    $pid = $post[update_pid];

    if ($res) {
        return true;
    }
    
    return false;
}

function getURLPulisher($pid){
	if($pid>0){
		$sql_string = "select url from publishersinfo where pid='".$pid."' ";
		$sql_obj = mysql_query($sql_string);	
		if(mysql_num_rows($sql_obj)) {
			$url = mysql_result($sql_obj, 0, 'url');			
		}
		return $url;
	}	
	return '';
}

function updateStatus($set=1, $pid, $script='', $root_url=''){
	if($script)
		$res = mysql_query('' . 'update `publishersinfo` set  `status`=\'' . intval($set) . '\', `root_url`=\'' . $root_url . '\', `update_status`=\'' . time() . '\', `update_date`=\'' . date("Y-m-d") . '\'  where script=\'' . $script . '\'');
	else
		$res = mysql_query('' . 'update `publishersinfo` set  `status`=\'' . intval($set) . '\'  where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' . intval($pid) . '\'');
	if($res) return true;
	return false;  
}

function get_sub_cat_list($cid) {
    $res = mysql_query('' . 'select * from subcategory where cid=\'' . $cid . '\' order by subcategory');
    while ($row = mysql_fetch_assoc($res)) {
        foreach ($row as $key => $val) {
            $c[$key][] = $val;
        }
    }
    
    return $c;
}
function get_acc_details() {
    if ($_SESSION['show_pub_stat'] == 'N') {
        $r                = mysql_fetch_assoc(mysql_query('' . 'select * from users where uid=\'' . $_SESSION['uid'] . '\''));
        $ret[balance]     = $r[balance];
        $ret[status]      = $r[status];
        $ret[newsletter]  = $r[getnewsletter];
        $ret[liveAds]     = mysql_result(mysql_query('' . 'select count(*) from advertisersinfo where uid=\'' . $_SESSION['uid'] . '\' and approved=\'Y\' and is_paid=\'Y\' and is_auth=\'Y\' 
			and ( 
					( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance>0 )
				)	
				and advertisersinfo.start_date<=CURDATE() 
			
			'), 0, 0);
        $ret[pendingAds]  = mysql_result(mysql_query('' . 'select count(*) from advertisersinfo where uid=\'' . $_SESSION['uid'] . '\' and approved=\'N\' and is_paid=\'Y\' and is_auth=\'Y\' '), 0, 0);
        $ret[clicksToday] = mysql_result(mysql_query('' . 'select count(*) from hits, advertisersinfo where advertisersinfo.uid=\'' . $_SESSION['uid'] . '\' and hits.adv_id=advertisersinfo.adv_id and hits.is_click=\'1\' and hits.is_sale=\'0\' and date = CURDATE()'), 0, 0);
        $ret[endingToday] = mysql_result(mysql_query('' . 'select count(*) from advertisersinfo where uid=\'' . $_SESSION['uid'] . '\' and approved=\'Y\' and is_paid=\'Y\' and is_auth=\'Y\' and  
			
								(
									( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date=CURDATE() )
									or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance=\'0\' )
								) 
									and advertisersinfo.start_date<=CURDATE() 
			
			'), 0, 0);
        return $ret;
    }
    
    if ($_SESSION['show_pub_stat'] == 'Y') {
        $r                    = mysql_fetch_assoc(mysql_query('' . 'select * from users where uid=\'' . $_SESSION['uid'] . '\''));
        $ret[balance]         = $r[balance];
        $ret[status]          = $r[status];
        $ret[newsletter]      = $r[getnewsletter];
        $ret[liveAds]         = mysql_result(mysql_query('' . 'select count(*) from advertisersinfo where pub_uid=\'' . $_SESSION['uid'] . '\' and approved=\'Y\' and is_paid=\'Y\' and is_auth=\'Y\' 
			and ( 
					( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance>0 )
				)	
				and advertisersinfo.start_date<=CURDATE() 
			
			'), 0, 0);
        $ret[pendingAds]      = mysql_result(mysql_query('' . 'select count(*) from advertisersinfo where pub_uid=\'' . $_SESSION['uid'] . '\' and approved=\'N\'  and is_paid=\'Y\' and is_auth=\'Y\' '), 0, 0);
        $ret[clicksToday]     = mysql_result(mysql_query('' . 'select count(*) from hits, advertisersinfo where advertisersinfo.pub_uid=\'' . $_SESSION['uid'] . '\' and hits.adv_id=advertisersinfo.adv_id and hits.is_click=\'1\' and hits.is_sale=\'0\' and date = CURDATE()'), 0, 0);
        $ret[endingToday]     = mysql_result(mysql_query('' . 'select count(*) from advertisersinfo where pub_uid=\'' . $_SESSION['uid'] . '\' and approved=\'Y\' and is_paid=\'Y\' and is_auth=\'Y\' and  
			
								(
									( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date=CURDATE() )
									or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance=\'0\' )
								) 
									and advertisersinfo.start_date<=CURDATE() 
			
			'), 0, 0);
        $ret[websiteListed]   = mysql_result(mysql_query('' . 'select count(*) from publishersinfo where uid=\'' . $_SESSION['uid'] . '\' '), 0, 0);
        $ret[totalAdProducts] = mysql_result(mysql_query('' . 'select count(*) from publishers_adspaces where uid=\'' . $_SESSION['uid'] . '\' '), 0, 0);
        return $ret;
    }
    
}

function get_adv_details($param, $show_from) {
    if ($param == 'current_ads') {
        $res   = mysql_query('' . 'select advertisersinfo.*, publishersinfo.*, publishers_adspaces.* from advertisersinfo, publishersinfo, publishers_adspaces where 
				advertisersinfo.uid=\'' . $_SESSION['uid'] . '\' and 
				
				( 
					( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance>0 )
				)  and advertisersinfo.start_date <= CURDATE()
				
				and advertisersinfo.approved<>\'R\' and advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' and advertisersinfo.pid=publishersinfo.pid and publishers_adspaces.ad_id=advertisersinfo.ad_id order by advertisersinfo.adv_id desc');
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            if ((($row[ad_type] == 'txt_ad' OR $row[ad_type] == 'img_ad') OR $row[ad_type] == 'vdo_ad')) {
                $c[$index]['length'] = $row[length];
            } else {
                $c[$index]['length'] = 'N/A';
            }
            
            $c[$index]['ad']          = $row[site_name];
            $c[$index]['sdate']       = $row[start_date];
            $c[$index]['cost']        = $row[price];
            $c[$index]['adv_id']      = $row[adv_id];
            $c[$index]['ad_space_id'] = $row[ad_id];
            if ($row[approved] == 'Y') {
                $edit = mysql_query('' . 'select approved from advertisersinfo_edit where adv_id=' . $row['adv_id'] . ' and approved<>\'R\' limit 1');
                if (mysql_num_rows($edit)) {
                    $edit_stat = mysql_result($edit, 0, 0);
                    if ($edit_stat == 'N') {
                        $c[$index]['status'] = 'Edit Awaiting Approval';
                    } else {
                        if ($edit_stat == 'Y') {
                            $c[$index]['status'] = 'Edit Approved';
                        }
                    }
                } else {
                    $c[$index]['status'] = 'Yes';
                }
            } else {
                if ($row['approved'] == 'N') {
                    $c[$index]['status'] = 'Awaiting Approval';
                }
            }
            
            ++$index;
        }
        
        return $c;
    }
    
    if ($param == 'rejected_ads') {
        $res   = mysql_query('' . 'select advertisersinfo.*, publishersinfo.*, publishers_adspaces.* from advertisersinfo, publishersinfo, publishers_adspaces where advertisersinfo.uid=\'' . $_SESSION['uid'] . '\' and advertisersinfo.approved<>\'N\' and advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' and advertisersinfo.pid=publishersinfo.pid and publishers_adspaces.ad_id=advertisersinfo.ad_id order by advertisersinfo.adv_id desc');
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            if ($row[approved] == 'Y') {
                $edit = mysql_query('' . 'select approved from advertisersinfo_edit where adv_id=' . $row['adv_id'] . ' and approved=\'R\' limit 1');
                if (mysql_num_rows($edit)) {
                    $c[$index][status] = 'Edit rejected';
                } else {
                    continue;
                }
            }
            
            if ($row[approved] == 'R') {
                $c[$index][status] = 'No';
            }
            
            if ((($row[ad_type] == 'txt_ad' OR $row[ad_type] == 'img_ad') OR $row[ad_type] == 'vdo_ad')) {
                $c[$index]['length'] = $row[length];
            } else {
                $c[$index]['length'] = 'N/A';
            }
            
            $c[$index][ad]       = $row[site_name];
            $c[$index][sdate]    = $row[start_date];
            $c[$index]['adv_id'] = $row[adv_id];
            $c[$index]['cost']   = $row[price];
            ++$index;
        }
        
        return $c;
    }
    
    if ($param == 'live_ads') {
        $res   = mysql_query('' . 'select advertisersinfo.*, publishersinfo.*, publishers_adspaces.* from advertisersinfo, publishersinfo, publishers_adspaces where 
				
				advertisersinfo.uid=\'' . $_SESSION['uid'] . '\' and 
				
				( 
					( advertisersinfo.ad_type=\'txt_ad\' and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance>0 )
				)	
				and advertisersinfo.start_date<=CURDATE() 
				
				and advertisersinfo.approved=\'Y\'  and advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' and advertisersinfo.pid=publishersinfo.pid and publishers_adspaces.ad_id=advertisersinfo.ad_id order by advertisersinfo.adv_id desc');
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            if ((($row[ad_type] == 'txt_ad' OR $row[ad_type] == 'img_ad') OR $row[ad_type] == 'vdo_ad')) {
                $c[$index]['length'] = $row[length];
            } else {
                $c[$index]['length'] = 'N/A';
            }
            
            $c[$index][ad]               = $row[site_name];
            $c[$index][sdate]            = $row[start_date];
            $c[$index][AdType]           = $row[ad_type];
            $c[$index][clicksToday]      = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and date=CURDATE() and is_click=1'), 0, 0);
            $c[$index][clicksTotal]      = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=1'), 0, 0);
            $c[$index][impressionsToday] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and date=CURDATE() and is_click=0 and is_sale=0'), 0, 0);
            $c[$index][impressionsTotal] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=0 and is_sale=0'), 0, 0);
            $c[$index][conversionsTotal] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_sale=1'), 0, 0);
            ++$index;
        }
        
        return $c;
    }
    
    if ($param == 'targeted_ads') {
        $res   = mysql_query('' . 'select * from adv_campaign where uid=\'' . $_SESSION['uid'] . '\' and approved<>\'N\' and is_paid=\'Y\' and is_auth=\'Y\' and start_date<=CURDATE() and remaining_budget>0 order by cmp_id desc');
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $c[$index]['cmp_id']       = $row['cmp_id'];
            $c[$index]['cname']        = $row['title'];
            $c[$index]['ad_type']      = $row['ad_type'];
            $c[$index]['rbudget']      = $row['remaining_budget'];
            $c[$index]['cpc']          = $row['max_cpc'];
            $c[$index]['clicksToday']  = mysql_result(mysql_query('' . 'select count(*) from hits where date=CURDATE() and cmp_id=' . $row['cmp_id'] . ' and is_click=1'), 0, 0);
            $c[$index]['clicksTotal']  = mysql_result(mysql_query('' . 'select count(*) from hits where cmp_id=' . $row['cmp_id'] . ' and is_click=1'), 0, 0);
            $c[$index]['pause_resume'] = $row['approved'];
            $q                         = mysql_query('' . 'select distinct publishersinfo.websitename, publishersinfo.pid from publishersinfo, hits where hits.cmp_id=' . $row['cmp_id'] . ' and hits.pub_id=publishersinfo.pid order by hits.hit_id, hits.pub_id');
            $ind                       = 0;
            while ($r = mysql_fetch_assoc($q)) {
                $c[$index]['wname'][$ind] = $r['websitename'];
                $c[$index]['wid'][$ind]   = $r['pid'];
                ++$ind;
            }
            
            ++$index;
        }
        
        return $c;
    }
    
    if ($param == 'detailed_ads') {
        $dqry = '' . 'select advertisersinfo.*, publishersinfo.*, publishers_adspaces.* from advertisersinfo, publishersinfo, publishers_adspaces where 
				advertisersinfo.uid=\'' . $_SESSION['uid'] . '\' and advertisersinfo.pid=publishersinfo.pid and publishers_adspaces.ad_id=advertisersinfo.ad_id  and 
				advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' and advertisersinfo.approved<>\'R\'  ';
        if ($show_from == 0) {
            $dqry .= ' and (
									( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date=CURDATE() )
									or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance=\'0\' )
									) and advertisersinfo.start_date<=CURDATE() ';
        } else {
            if ($show_from == 7) {
                $dqry .= ' and  advertisersinfo.start_date>=(CURDATE()-7)  ';
            } else {
                if ($show_from == 30) {
                    $dqry .= ' and  advertisersinfo.start_date>=(CURDATE()-30)  ';
                }
            }
        }
        
        $dqry .= ' order by advertisersinfo.adv_id desc';
        $res   = mysql_query($dqry);
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $tmp   = explode('-', $row['end_date']);
            $end   = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            unset($tmp);
            $tmp   = explode('-', $row['start_date']);
            $start = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            if ((($row[ad_type] == 'txt_ad' OR $row[ad_type] == 'img_ad') OR $row[ad_type] == 'vdo_ad')) {
                $c[$index]['length'] = $row[length];
                $is_ppc              = false;
            } else {
                $c[$index]['length'] = 'N/A';
                $is_ppc              = true;
            }
            
            $c[$index]['ad']     = $row[site_name];
            $c[$index]['sdate']  = $row[start_date];
            $c[$index]['edate']  = $row[end_date];
            $c[$index]['adv_id'] = $row[adv_id];
            if ($row[approved] == 'Y') {
                $edit = mysql_query('' . 'select approved from advertisersinfo_edit where adv_id=' . $row['adv_id'] . ' limit 1');
                if (@mysql_num_rows($edit)) {
                    $edit_stat = mysql_result($edit, 0, 0);
                    if ($edit_stat == 'N') {
                        $c[$index]['status'] = 'Running Now (Edit Awaiting Approval)';
                    } else {
                        if ($edit_stat == 'Y') {
                            $c[$index]['status'] = 'Running Now (Edit Approved)';
                        } else {
                            if ($edit_stat == 'R') {
                                $c[$index]['status'] = 'Running Now (Edit rejected)';
                            }
                        }
                    }
                } else {
                    $c[$index]['status'] = 'Running Now';
                }
            } else {
                if ($row['approved'] == 'N') {
                    $c[$index]['status'] = 'Awaiting Approval';
                }
            }
            
            if ($end < $today) {
                $c[$index]['status'] = 'Ended';
            }
            
            $c[$index][clicksTotal]      = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=1 and is_sale=0'), 0, 0);
            $c[$index][impressionsTotal] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=0 and is_sale=0'), 0, 0);
            $c[$index][conversionsTotal] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=0 and is_sale=1'), 0, 0);
            ++$index;
        }
        
        return $c;
    }
    
}

function cancelAdvertiser($adv_id, $url){
	if($adv_id<=0) return false;	

	$buying_obj = mysql_query('' . 'SELECT adv_id, price, buying_date, coupon_price, coupon_length FROM advertisersinfo WHERE uid= ' . $_SESSION[uid] . ' and adv_id = ' . $adv_id . '  LIMIT 1');
    if (mysql_num_rows($buying_obj)) {		
			$buying_date = mysql_result($buying_obj, 0, 'buying_date');		
			$price = mysql_result($buying_obj, 0, 'price');
			$coupon_price = mysql_result($buying_obj, 0, 'coupon_price');
			$coupon_length = mysql_result($buying_obj, 0, 'coupon_length');
			if($buying_date == date("Y-m-d")){	
			$update = mysql_query('' . 'UPDATE advertisersinfo SET is_paid=\'C\' WHERE adv_id=\'' . $adv_id . '\' AND uid=\'' . $_SESSION[uid] . '\' LIMIT 1');	
			if($coupon_length>=1)	
				return ($price - $price*$coupon_price)*$coupon_length;
			else return $price;
		//check action delete buying_date
		}else return false;
    }
	

}

function RenewlAdvertiser($adv_id, $url, $day=30){
	if($adv_id<=0 || $_SESSION[uid]<=0) return false;	

	 $renew_obj = mysql_query('' . 'SELECT adv_id, price, buying_date, end_date FROM advertisersinfo WHERE uid= ' . $_SESSION[uid] . ' and adv_id = ' . $adv_id . '  LIMIT 1');
    if (mysql_num_rows($renew_obj)) {		
		$end_date = mysql_result($renew_obj, 0, 'end_date');		
		$price = mysql_result($renew_obj, 0, 'price');
		$date_now = date("Y-m-d");
		if($end_date<$date_now) $end_date = $date_now;
		
		$end_date_renew = date('Y-m-d', strtotime('+'.$day.' day', strtotime($end_date)));
		
    	if($end_date_renew){	
		$update = mysql_query('' . 'UPDATE advertisersinfo SET is_paid=\'Y\', end_date = \''.$end_date_renew.'\' WHERE adv_id=\'' . $adv_id . '\' AND uid=\'' . $_SESSION[uid] . '\' LIMIT 1');		
		return $price;
		//check action delete buying_date
		}else return false;
    }
	

}


function get_pub_details($param, $pid) {
    if ($param == 'new_ads') {
        $res   = mysql_query('' . 'select advertisersinfo.*, publishersinfo.*, publishers_adspaces.* from advertisersinfo, publishersinfo, publishers_adspaces where 
				advertisersinfo.pub_uid=\'' . $_SESSION['uid'] . '\' and 
				
				
				( 
					( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance>0 )
				)	

				
				and advertisersinfo.approved<>\'R\'  and advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' and advertisersinfo.pid=publishersinfo.pid and publishers_adspaces.ad_id=advertisersinfo.ad_id order by advertisersinfo.adv_id desc');
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            if ($row[approved] == 'Y') {
                $edit = mysql_query('' . 'select approved from advertisersinfo_edit where adv_id=' . $row['adv_id'] . ' and approved=\'N\' limit 1');
                if (mysql_num_rows($edit)) {
                    $c[$index]['status'] = 'Edit';
                } else {
                    continue;
                }
            }
            
            if ($row['approved'] == 'N') {
                $c[$index]['status'] = 'New Ad';
            }
            
            $c[$index]['ad'] = $row[site_name];
            if ($row[ad_type] == 'txt_ad') {
                $c[$index]['type'] = 'Text';
            } else {
                if ($row[ad_type] == 'img_ad') {
                    $c[$index]['type'] = 'Image';
                } else {
                    if ($row[ad_type] == 'vdo_ad') {
                        $c[$index]['type'] = 'Video';
                    }
                }
            }
            
            if ($row[cost] != $row[price]) {
                $c[$index]['offer'] = 'Y';
            } else {
                $c[$index]['offer'] = 'N';
            }
            
            $c[$index]['cost']   = $row[price];
            $c[$index]['adv_id'] = $row[adv_id];
            ++$index;
        }
        
        return $c;
    }
    
    if ($param == 'earning') {
        $tmp = explode('-', $pid);
        if ($pid == 'all') {
            $res = mysql_query('' . 'select * from advertisersinfo where pub_uid=\'' . $_SESSION['uid'] . '\' and buying_date<>\'0000-00-00\' and approved=\'Y\'  and is_paid=\'Y\' and is_auth=\'Y\' order by adv_id desc');
        } else {
            if ($pid == 'uns') {
                $res = mysql_query('' . 'select advertisersinfo.* from advertisersinfo, users where advertisersinfo.pub_uid=\'' . $_SESSION['uid'] . '\' and users.last_money_sent<advertisersinfo.buying_date and advertisersinfo.approved=\'Y\'  and advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' order by advertisersinfo.adv_id desc');
            } else {
                $res = mysql_query('' . 'select * from advertisersinfo where pub_uid=\'' . $_SESSION['uid'] . '\' and month(buying_date)=\'' . $tmp['0'] . '\' and year(buying_date)=\'' . $tmp['1'] . '\' and buying_date<>\'0000-00-00\' and approved=\'Y\' and is_paid=\'Y\' and is_auth=\'Y\' order by adv_id desc');
            }
        }
        
        $index      = 0;
        $total      = 0;
        $ppc_total  = 0;
        $ppc_clicks = 0;
        $net_total  = 0;
        $net_clicks = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $len = mysql_result(mysql_query('' . 'select length from publishers_adspaces where ad_id=\'' . $row['ad_id'] . '\' '), 0, 0);
            if (!isset($_config)) {
                $_config = load_config();
            }
            
            $pub_pay_rate = mysql_result(mysql_query('' . 'select pay_rate from publishersinfo where pid=\'' . $row['pid'] . '\' '), 0, 0);
            if ($pub_pay_rate == 0) {
                $pub_pay_rate = $_config[default_pay_rate];
            }
            
            $pub_website            = mysql_result(mysql_query('' . 'select websitename from publishersinfo where pid=\'' . $row['pid'] . '\' '), 0, 0);
            $c[$index]['ad']        = $row[site_name] . ' (' . $pub_website . ')';
            $c[$index]['sold_date'] = $row[buying_date];
            if ($len == 0) {
                $c[$index]['length'] = 'N/A';
                $c[$index]['price']  = round($row[ppc_balance] * ($pub_pay_rate / 100), 2);
            } else {
                $c[$index]['length'] = $len;
                $c[$index]['price']  = round($row[price] * ($pub_pay_rate / 100), 2);
            }
            
            if ($lms = @mysql_result(@mysql_query('' . 'select last_money_sent from users where uid=\'' . $_SESSION['uid'] . '\' and last_money_sent<>\'0000-00-00\' '), 0, 0)) {
                $c[$index]['money_sent'] = $lms;
            } else {
                $c[$index]['money_sent'] = 'Not Yet';
            }
            
            $total += $c[$index]['price'];
            ++$index;
        }
        
        if ($pid == 'all') {
            $net_hits = mysql_query('' . 'select distinct hits.*, publishers_adspaces.cost from hits, publishers_adspaces where publishers_adspaces.uid=\'' . $_SESSION['uid'] . '\' and publishers_adspaces.ad_id=hits.ad_id and hits.cmp_id<>\'0\' and hits.is_click=\'1\' ');
        } else {
            if ($pid == 'uns') {
                $net_hits = mysql_query('' . 'select distinct hits.*, publishers_adspaces.cost from hits, publishers_adspaces where publishers_adspaces.uid=\'' . $_SESSION['uid'] . '\' and publishers_adspaces.ad_id=hits.ad_id and hits.money_sent=\'0000-00-00\' and hits.cmp_id<>\'0\' and hits.is_click=\'1\' ');
            } else {
                $net_hits = mysql_query('' . 'select distinct hits.*, publishers_adspaces.cost from hits, publishers_adspaces where publishers_adspaces.uid=\'' . $_SESSION['uid'] . '\' and publishers_adspaces.ad_id=hits.ad_id and month(hits.date)=\'' . $tmp['0'] . '\' and year(hits.date)=\'' . $tmp['1'] . '\' and hits.cmp_id<>\'0\' and hits.is_click=\'1\' ');
            }
        }
        
        $net_clicks = mysql_num_rows($net_hits);
        while ($nc = mysql_fetch_assoc($net_hits)) {
            $pub_pay_rate = mysql_result(mysql_query('' . 'select pay_rate from publishersinfo where pid=\'' . $nc['pub_id'] . '\' '), 0, 0);
            if ($pub_pay_rate == 0) {
                $pub_pay_rate = $_config[default_pay_rate];
            }
            
            $rate = $nc[cost];
            $net_total += $rate * ($pub_pay_rate / 100);
        }
        
        $c[0]['total_sold'] = $total;
        $c[0]['ppc_total']  = $ppc_total;
        $c[0]['net_total']  = $net_total;
        $c[0]['ppc_clicks'] = $ppc_clicks;
        $c[0]['net_clicks'] = $net_clicks;
        return $c;
    }
    
    if ($param == 'pub_live_ads') {
        $res   = mysql_query('' . 'select advertisersinfo.*, publishersinfo.*, publishers_adspaces.* from advertisersinfo, publishersinfo, publishers_adspaces where 
				advertisersinfo.pub_uid=\'' . $_SESSION['uid'] . '\' and 
				( 
					( (advertisersinfo.ad_type=\'txt_ad\' or advertisersinfo.ad_type=\'img_ad\' or advertisersinfo.ad_type=\'vdo_ad\') and advertisersinfo.end_date>=CURDATE() )
					or ( (advertisersinfo.ad_type=\'ppc_txt_ad\' or advertisersinfo.ad_type=\'ppc_img_ad\' or advertisersinfo.ad_type=\'ppc_vdo_ad\') and advertisersinfo.ppc_balance>0 )
				)	
				and advertisersinfo.start_date<=CURDATE() 
				and advertisersinfo.approved=\'Y\'  and advertisersinfo.is_paid=\'Y\' and advertisersinfo.is_auth=\'Y\' and advertisersinfo.pid=publishersinfo.pid 
				and advertisersinfo.pid=\'' . $pid . '\' and publishers_adspaces.ad_id=advertisersinfo.ad_id order by advertisersinfo.adv_id desc');
        $index = 0;
        while ($row = mysql_fetch_assoc($res)) {
            if ((($row[ad_type] == 'txt_ad' OR $row[ad_type] == 'img_ad') OR $row[ad_type] == 'vdo_ad')) {
                $c[$index]['length'] = $row[length];
            } else {
                $c[$index]['length'] = 'N/A';
            }
            
            $c[$index][ad]               = $row[site_name] . ' (' . $row[websitename] . ')';
            $c[$index][clicksToday]      = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and date=CURDATE() and is_click=1'), 0, 0);
            $c[$index][clicksTotal]      = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=1 '), 0, 0);
            $c[$index][impressionsToday] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and date=CURDATE() and is_click=0 and is_sale=0'), 0, 0);
            $c[$index][impressionsTotal] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_click=0 and is_sale=0'), 0, 0);
            $c[$index][conversionsTotal] = mysql_result(mysql_query('' . 'select count(*) from hits where adv_id=' . $row['adv_id'] . ' and is_sale=1'), 0, 0);
            ++$index;
        }
        
        return $c;
    }
    
    $res   = mysql_query('' . 'select * from publishers_adspaces where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' . $pid . '\' and ad_type=\'' . $param . '\'  order by ad_id desc');
    $index = 0;
    while ($row = mysql_fetch_assoc($res)) {
        $c[$index]['cost']   = $row[cost];
        $c[$index]['size']   = $row[size];
        $c[$index]['length'] = $row[length];
        $c[$index]['ad_id']  = $row[ad_id];
        $c[$index]['pid']    = $row[pid];
        $c[$index]['title']  = $row[title];
        ++$index;
    }
    
    return $c;
}

function get_web_page( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $content;
}

function timeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s'){
        $difference = time() - $timestamp;
       
        if($difference < 0) return ''; // if difference is lower than zero check server offset
        elseif($difference > 1592000){ // if difference is over 10 days show normal time form
       
                $periods = array('years' => 31536000, 'months' => 2592000);
                $output = '';
                foreach($periods as $key => $value){
               
                        if($difference >= $value){                      
                                $time = round($difference / $value);
                                $difference %= $value;                              
                                $output .= ($output ? ' ' : '').$time.' ';
                                $output .= (($time > 1 && $key == 'ngày') ? $key.'s' : $key);                               
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return ($output ? $output : '');
        }
        else return " 1 month";
}


function validateURL($str) {
    $length = strlen($str);
    $idx = 0;
    while($length--) {
       $c = $str[$idx++];
       if(ord($c) > 127){
          return false;
       }
    }
    $regexp = "/https?:\/\/([a-zA-Z0-9]+.)+[a-zA-Z0-9-_?&=:\/.]+/i";
    if(preg_match($regexp,$str)) {
		$url1  = str_replace('www.', '', $str);
		$url2  = str_replace('http://', 'http://www.', $url1);
        $check_isset_url = mysql_query('' . 'SELECT pid FROM publishersinfo WHERE (url=\'' . trim($url1) . '\') OR (url=\'' . trim($url2) . '\') LIMIT 1');
		if(mysql_num_rows($check_isset_url)){
			return 1;
		}
		return 2;
    } else {
        return false;
    }
}

function isExist($string = '', $post = array()){
    if($post[$string] && $post[$string] !='') return 1;
    else return 0;
}

function isValid($str, $type='url'){
	if($type=='email'){//case for valid email
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $str)){
			$check_isset_email = mysql_query('' . 'SELECT uid FROM users WHERE email=\'' . strip_tags(trim($str)) . '\' LIMIT 1');
			if(mysql_num_rows($check_isset_email)){
				return 1;
			}
			return 2;
		}
		return false;
	}elseif($type=='username'){
			$check_isset_username = mysql_query('' . 'SELECT uid FROM users WHERE username=\'' . strip_tags(trim($str)) . '\' LIMIT 1');
			if(mysql_num_rows($check_isset_username)){
				return 1;
			}
			return 2;	
	}else{
		//case for valid url
		$length = strlen($str);
		$idx = 0;
		while($length--) {
		   $c = $str[$idx++];
		   if(ord($c) > 127){
			  return false;
		   }
		}
		$regexp = "/https?:\/\/([a-zA-Z0-9]+.)+[a-zA-Z0-9-_?&=:\/.]+/i";
		if(preg_match($regexp,$str)) {
			$check_isset_url = mysql_query('' . 'SELECT pid FROM publishersinfo WHERE url=\'' . trim($str) . '\' LIMIT 1');
			if(mysql_num_rows($check_isset_url)){
				return 1;
			}
			return 2;
		} else {
			return false;
		}
		//end case for valid url
	}
}

//$license_key = mysql_result(mysql_query('select value from configurations where name = \'key_string\' '), 0, 0);

function checkIssetUrl($url)
{
	$agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"; 
	
	$ch=curl_init();
	
	curl_setopt ($ch, CURLOPT_URL,$url );
	
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	
	curl_setopt ($ch,CURLOPT_VERBOSE,false);
	
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	
	$page=curl_exec($ch);
	
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	curl_close($ch);
	
	if($httpcode>=200 && $httpcode<300) return true;
	
	else return false;
}

function unique_id($l = 20) {
    return strtoupper(substr(md5(uniqid(mt_rand().time(), true)), 0, $l));
}

/**
 * Log file
 */
function logFile($message) {
	$message = $message . "\n";
	$file = fopen(ROOT_PATH . "/logs/log_".date('Y-m-d', time()).".txt", "a");
	//$file = fopen("E:/log.txt", "a");
	fwrite($file, $message);
	fclose($file);
}
function getModuleName(){	
	$PHP_SELF=$_SERVER['REQUEST_URI'];
	$tmp=explode("/",$PHP_SELF);
	if(count($tmp)>0)
		$mn=$tmp[count($tmp)-1];
	$mn=explode("?",$mn);
	return $mn[0];
	
}
function getGenders($gender = ''){
    $list = array(
        'M' => 'Male',
        'F' => 'Female'
    );

    if($gender && in_array($gender, $list))
        return 0;
    else
        return $list;
}
$_config = load_config();
?>