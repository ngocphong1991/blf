<?php

$url =  urlencode("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

echo  ($url);

function textlink_ads()
{
    $content = '';
    // Number of seconds before connection to XML times out
    // (This can be left the way it is)
    $CONNECTION_TIMEOUT = 10;

    // Local file to store XML
    // This file MUST be writable by web server
    // You should create a blank file and CHMOD it to 666
    $LOCAL_FILENAME = "f2a2c2bf0c62c79a305dc037b208c723.xml";

    if (!file_exists($LOCAL_FILENAME)) {
        @touch($LOCAL_FILENAME);
        @chmod($LOCAL_FILENAME, 0666);
    }

    if (!file_exists($LOCAL_FILENAME)) {
        die("Script error: $LOCAL_FILENAME does not exist. Please create a blank file named $LOCAL_FILENAME.");
    }

    if (!is_writable($LOCAL_FILENAME)) {
        die("Script error: $LOCAL_FILENAME is not writable. Please set write permissions on $LOCAL_FILENAME.");
    }

    if (filemtime($LOCAL_FILENAME) < (time() - 3600) || filesize($LOCAL_FILENAME) < 3) {
        $url = 'http://textlink.vn/ad_files/xml.php?k=f2a2c2bf0c62c79a305dc037b208c723&l=dragonfly-textlink-2.0.2';
        
        if (function_exists('json_decode') && is_array(json_decode('{"a":1}', true))) {
            $url .= '&f=json';
        }

        textlink_updateLocal($url, $LOCAL_FILENAME, $CONNECTION_TIMEOUT);
    }

    $xml = textlink_getLocal($LOCAL_FILENAME);
    $links = textlink_decode($xml);

    if (is_array($links)) {
        foreach ($links as $link) {
            if (isset($link['PostID']) && $link['PostID'] > 0) {
                continue;
            }

            $content .= ($link['BeforeText'] ? $link['BeforeText'] . ' ' : '') . '<a href="' . $link['URL'] . '">' . $link['Text'] . '</a>' . ($link['AfterText'] ? ' ' . $link['AfterText'] : '') . "\n";
        }
    }
    return $content;
}

function textlink_updateLocal($url, $file, $time_out)
{
    touch($file);

    if ($xml = file_get_contents_textlink($url, $time_out)) {
        if ($handle = fopen($file, 'w')) {
            fwrite($handle, $xml);
            fclose($handle);
        }
    }
}

function textlink_getLocal($file)
{
    if (function_exists('file_get_contents')) {
        return file_get_contents($file);
    }

    $contents = '';
    if ($handle = fopen($file, 'r')) {
        $contents = fread($handle, filesize($file) + 1);
        fclose($handle);
    }

    return $contents;
}

function file_get_contents_textlink($url, $time_out)
{
    $result = '';
    $url = parse_url($url);

    if ($handle = @fsockopen($url['host'], 80)) {
        if (function_exists('socket_set_timeout')) {
            socket_set_timeout($handle, $time_out, 0);
        } else if (function_exists('stream_set_timeout')) {
            stream_set_timeout($handle, $time_out, 0);
        }

        fwrite($handle, 'GET ' . $url['path'] . '?' . $url['query'] . " HTTP/1.0\r\nHost: " . $url['host'] . "\r\nConnection: Close\r\n\r\n");
        while (!feof($handle)) {
            $result .= @fread($handle, 40960);
        }
        fclose($handle);
    }

    $return = '';
    $capture = false;
    foreach (explode("\n", $result) as $line) {
        $char = substr(trim($line), 0, 1);
        if ($char == '[' || $char == '<') {
            $capture = true;
        }

        if ($capture) {
            $return .= $line . "\n";
        }
    }

    return $return;
}

function textlink_decode($str)
{
    if (!function_exists('html_entity_decode')) {
        function html_entity_decode($string)
        {
           // replace numeric entities
           $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\1"))', $string);
           $string = preg_replace('~&#([0-9]+);~e', 'chr(\1)', $string);
           // replace literal entities
           $trans_tbl = get_html_translation_table(HTML_ENTITIES);
           $trans_tbl = array_flip($trans_tbl);
           return strtr($string, $trans_tbl);
        }
    }

    if (substr($str, 0, 1) == '[') {
        $arr = json_decode($str, true);
        foreach ($arr as $i => $a) {
            foreach ($a as $k => $v) {
                $arr[$i][$k] = textlink_decode_str($v);
            }
        }

        return $arr;
    }

    $out = '';
    $retarr = '';

    preg_match_all("/<(.*?)>(.*?)</", $str, $out, PREG_SET_ORDER);
    $n = 0;
    while (isset($out[$n])) {
        $retarr[$out[$n][1]][] = textlink_decode_str($out[$n][0]);
        $n++;
    }

    if (!$retarr) {
        return false;
    }

    $arr = array();
    $count = count($retarr['URL']);
    for ($i = 0; $i < $count; $i++) {
        $arr[] = array(
            'BeforeText' => $retarr['BeforeText'][$i],
            'URL' => $retarr['URL'][$i],
            'Text' => $retarr['Text'][$i],
            'AfterText' => $retarr['AfterText'][$i],
        );
    }
    return $arr;
}

function textlink_decode_str($str)
{
    $search_ar = array('&#60;', '&#62;', '&#34;');
    $replace_ar = array('<', '>', '"');
    return str_replace($search_ar, $replace_ar, html_entity_decode(strip_tags($str)));
}

$content = textlink_ads();
echo $content;
?>