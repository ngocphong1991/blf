<?php
//@ function check VietNam Domain Age
//@ Return timestamp
//$domain_age = getDomainAge('cab.vn');
//echo timeAgo($domain_age);

function getDomainName($domain, $type='ext'){
	$true = getTrueDomain($domain);
	$temparray=explode('.',trim($true,"www."));

	$domain=array_shift($temparray);

	$domainExt=join('.',$temparray);	
	$domainExt_arr = explode("/", $domainExt);	
		
	if($type=='ext') return ".".$domainExt_arr[0];
	else return $domain.".".$domainExt_arr[0];;
}

function updateDomainAge($domain_age,$pid){
	$res = mysql_query('' . 'update `publishersinfo` set  `domain_age`=\'' . $domain_age . '\'  where uid=\'' . $_SESSION['uid'] . '\' and pid=\'' . $pid. '\'');
	return  $res;
}

function getTrueDomain($domain){	
	$des = array("", "", "", "");
	$from   = array("http://", "https://", "http://www.", "https://www.");
	$tru_domain = str_replace($from, $des, $domain);
	return $tru_domain;
}

function getVNDomain($domain, $type="noxml"){	
	if($type=='xml'){
	$doc = new DOMDocument();
	$doc->load( 'http://www.matbao.net/whoisXML.aspx?domain='.trim($domain).'' );

	$description = $doc->getElementsByTagName("item");
		foreach( $description as $key=> $employee )
		{		
			$names = $employee->getElementsByTagName( "description" );
			$vnDomainAge = $names->item(0)->nodeValue;
		}   
	}
	else
	{
		$vnDomainAge = get_web_page("http://www.pavietnam.vn/vn/whois.php?cmd=getwhois&domain=".trim($domain)."");
		//$vnDomainAge = get_web_page("http://www.matbao.net/RWhois.aspx?Domain=".trim($domain)."");
	
	}

	if(!$vnDomainAge) return 0;
	  	$vnDomainAge=substr($vnDomainAge,strpos($vnDomainAge,'Issue Date :')+strlen('Issue Date :'));	
		if($vnDomainAge === false){} else{
			$vnDomainAge=substr($vnDomainAge,0,strpos($vnDomainAge,'Expired Date :'));
		}
		$vnDomainAge = strip_tags($vnDomainAge);	
		$date = explode('/', trim($vnDomainAge));
		$D = $date[0];
		$M = $date[1];
		$Y = $date[2];
		$dobshow = $M."/".$D."/".$Y;  
		$vnDomainAge = strtotime($dobshow);		
		return trim($vnDomainAge);	
}

function getDomainAge($domain, $type) {
	$domain = getTrueDomain($domain);
	$domain = getDomainName($domain,'domain');
    $domainAge = new DomainAge();
    return trim($domainAge->age($domain));
}

function getOtherDomain($domain){

    $result = get_web_page("http://www.domainageonline.com/process_tool.php?domain=".$domain."");

    $domain_age=substr($result,strpos($result,'first registered on <strong>')+strlen('first registered on <strong>'));
    $domain_age=substr($domain_age,0,strpos($domain_age,'</strong>'));
    //$domain_age = strtotime(trim($domain_age));
    if(!$domain_age){
        $result = whois::lookup($domain);
        if(strstr($result, " No match")){
               $domain_age = 0;
        }else{
            $domain_age=substr($result,strpos($result,'Creation Date:')+strlen('Creation Date:'));
            if($domain_age === false){} else{
                $domain_age=substr($domain_age,0,strpos($domain_age,'Expiration Date: '));
        }
    }

    $domain_age = strip_tags($domain_age);
    unset($result);
			
	}
	$domain_age = strtotime(trim($domain_age));	
	return $domain_age;
}

class whois
{
    const timeout = 30;
    const whoishost = 'whois.internic.net';
    
    public static function lookup($domain){

       $result = "";
       $errno = 0;
       $errstr='';
    
       $fd = fsockopen(whois::whoishost,43, $errno, $errstr, whois::timeout);

       if ($fd){
             fputs($fd, $domain."\015\012");
           while (!feof($fd))    {
            $result .= fgets($fd,128) . "<br />";
           }
           fclose($fd);
        }
         return $result;
     }
}

class DomainAge{
    private $WHOIS_SERVERS=array(
        "com"               =>  array("whois.verisign-grs.com","/Creation Date:(.*)/"),
        "net"               =>  array("whois.verisign-grs.com","/Creation Date:(.*)/"),
        "org"               =>  array("whois.pir.org","/Created On:(.*)/"),
        "info"              =>  array("whois.afilias.info","/Created On:(.*)/"),
        "biz"               =>  array("whois.neulevel.biz","/Domain Registration Date:(.*)/"),
        "us"                =>  array("whois.nic.us","/Domain Registration Date:(.*)/"),
        "uk"                =>  array("whois.nic.uk","/Registered on:(.*)/"),
        "ca"                =>  array("whois.cira.ca","/Creation date:(.*)/"),
        "tel"               =>  array("whois.nic.tel","/Domain Registration Date:(.*)/"),
        "ie"                =>  array("whois.iedr.ie","/registration:(.*)/"),
        "it"                =>  array("whois.nic.it","/Created:(.*)/"),
        "cc"                =>  array("whois.nic.cc","/Creation Date:(.*)/"),
        "ws"                =>  array("whois.nic.ws","/Domain Created:(.*)/"),
        "sc"                =>  array("whois2.afilias-grs.net","/Created On:(.*)/"),
        "mobi"              =>  array("whois.dotmobiregistry.net","/Created On:(.*)/"),
        "pro"               =>  array("whois.registrypro.pro","/Created On:(.*)/"),
        "edu"               =>  array("whois.educause.net","/Domain record activated:(.*)/"),
        "tv"                =>  array("whois.nic.tv","/Creation Date:(.*)/"),
        "travel"            =>  array("whois.nic.travel","/Domain Registration Date:(.*)/"),
        "in"                =>  array("whois.inregistry.net","/Created On:(.*)/"),
        "me"                =>  array("whois.nic.me","/Domain Create Date:(.*)/"),
        "cn"                =>  array("whois.cnnic.cn","/Registration Date:(.*)/"),
        "asia"              =>  array("whois.nic.asia","/Domain Create Date:(.*)/"),
        "ro"                =>  array("whois.rotld.ro","/Registered On:(.*)/"),
        "aero"              =>  array("whois.aero","/Created On:(.*)/"),
        "nu"                =>  array("whois.nic.nu","/created:(.*)/"),
        "vn"                =>  array("whois.net.vn","/Issue Date :(.*)/"),
    );
    public function age($domain)
    {
        $domain = trim($domain); //remove space from start and end of domain
        if(substr(strtolower($domain), 0, 7) == "http://") $domain = substr($domain, 7); // remove http:// if included
        if(substr(strtolower($domain), 0, 4) == "www.") $domain = substr($domain, 4);//remove www from domain
        if(preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i",$domain))
        {
            $domain_parts = explode(".", $domain);
            $tld = strtolower(array_pop($domain_parts));
            if(!$server=$this->WHOIS_SERVERS[$tld][0]) {
                return false;
            }

            if($tld == 'vn') $res = file_get_contents("http://www.whois.net.vn/whois.php?domain=$domain&act=getwhois");
            else $res=$this->queryWhois($server,$domain);

            if(preg_match($this->WHOIS_SERVERS[$tld][1],$res,$match))
            {
                if(count(explode('/', $match[1]))) $match[1] = trim(str_replace('<br>','',str_replace('/', '-', $match[1])));
                date_default_timezone_set('UTC');
                return strtotime($match[1]);
            }
            else
                return false;
        }
        else
            return false;
    }
    private function queryWhois($server,$domain)
    {
        $fp = @fsockopen($server, 43, $errno, $errstr, 20) or die("Socket Error " . $errno . " - " . $errstr);
        if($server=="whois.verisign-grs.com")
            $domain="=".$domain;
        fputs($fp, $domain . "\r\n");
        $out = "";
        while(!feof($fp)){
            $out .= fgets($fp);
        }
        fclose($fp);
        return $out;
    }
}



?>