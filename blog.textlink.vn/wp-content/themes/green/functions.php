<?php
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'sidebar1'));
register_sidebar(array('name'=>'sidebar2'));

/* EXCERPT
/* ----------------------------------------------*/
function ld_clean($excerpt, $substr=0) {
	$string = strip_tags(str_replace('[...]', '...', $excerpt));
	if ($substr>0) {
		$string = substr($string, 0, $substr);
	}
	return $string;
}

?>