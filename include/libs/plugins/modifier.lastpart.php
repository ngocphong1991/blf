<?php
// by adnan.eee@gmail.com
function smarty_modifier_lastpart($string, $char)
{
    $tmp = explode($char,$string);
	return 'adaa';//$tmp[count($tmp) - 1];
}
?>