<?php
class TextLink {
	
	var $key = '60c1b6bb7db78fef73af2e069abc33d6';
	var $feed;
	var $links;
	var $feedUrl;
	var $cacheFile;
	var $cacheTime = 10000;
	var $timeout   = 10;
	
	
	function TextLink()
	{
		$this->feedUrl		= 'http://textlink.vn/ad_files/'.$this->key.'.xml';
		$this->cacheFile	= $this->key.'.xml';
		$this->links		= array();
		$this->loadFeed();
	}
	
	
	function output()
	{
	
		if(count($this->links) > 1){
			echo("<ul>\n");
			foreach($this->links as $link)
			{
				echo("<li><a href=\"{$link['link']}\">{$link['text']}</a></li>\n");
			}
			echo("</ul>\n");
		}else if(count($this->links) == 1){
			foreach($this->links as $link)
			{
				echo("<a href=\"{$link['link']}\">{$link['text']}</a>");
			}
		}
	}
	
	
	function loadFeed()
	{
		if(!file_exists($this->cacheFile)) return;
		if(!is_writable($this->cacheFile)) return;
		
		if( filemtime($this->cacheFile) > (time() - $this->cacheTime) ){
			$this->loadCache();
		}else{
			$this->touchCache();
			$this->downloadFeed();
			if($this->feed){
				$this->cacheFeed();
			}else{
				$this->loadCache();
			}
		}
		
		$this->parseFeed();
	}
	
	function parseFeed()
	{
		if(!$this->feed) return;
		
		$values = array();
		$index  = array();
	
		$parser = xml_parser_create();
        xml_parse_into_struct($parser, $this->feed, $values, $index);
        xml_parser_free($parser);
		
        $linkIndex = $index['LINK'];
        $textIndex = $index['TITLE'];
        $urlIndex  = $index['URL'];
		//$urlIndex  = $index['DESCRIPTION'];
  
        if(is_array($linkIndex)){	
        	foreach($linkIndex as $idx1 => $idx2){
	        	//if($idx1 == 0) continue;
				$my_url = curPageURL();
                //if($my_url != $values[$urlIndex[$idx1]]['value']) continue;
	      
	        	$this->links[] = array(
	        		'link'	=> $values[$linkIndex[$idx1]]['value'],
	        		'text'	=> $values[$textIndex[$idx1]]['value']
	        	);
				
	        }
        }
	}
	
	
	function loadCache()
	{		
		$this->feed = '';
		if( $handle = fopen($this->cacheFile, 'r') ){
			while (!feof($handle)) {			
				$this->feed .= fread($handle, 8192);
			}
			fclose($handle);
		}
	}
	
	
	function touchCache()
	{
		if( $handle = fopen($this->cacheFile, 'a') ){
			fwrite($handle, ' ');
			fclose($handle);
		}
	}
	
	
	function cacheFeed()
	{
		if( $handle = fopen($this->cacheFile, 'w') ){
			fwrite($handle, $this->feed);
			fclose($handle);
		}
	}
	
	
	function downloadFeed()
	{
		$result		= '';
		$errorNum	= '';
		$errorStr	= '';
		//echo $this->feedUrl;
		
		$url = parse_url($this->feedUrl);
		//print_r($url);
		if ($handle = @fsockopen ($url['host'], 80, $errorNum, $errorStr, $this->timeout))
		{
			
			if(function_exists('socket_set_timeout')) {
				socket_set_timeout($handle, $this->timeout, 0);
			}
			if(function_exists('stream_set_timeout')) {
				stream_set_timeout($handle, $this->timeout, 0);
			}
	
			fwrite ($handle, "GET {$url['path']} HTTP/1.0\r\nHost: {$url['host']}\r\nConnection: Close\r\n\r\n");
			while(!feof($handle)){
				$result .= @fread($handle, 8192);
			}
			fclose($handle);
		}
		
		if(strpos($result, '<?xml') !== false){
			$this->feed = trim(substr($result, strpos($result, '<?xml')));
		}

	}
	
}


$textlink = new TextLink();
$textlink->output();
unset($textlink);

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>