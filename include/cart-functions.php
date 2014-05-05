<?php
//@ function get total cart
//@ Return total cart
//@ author: TienPV
function getTotalCart(){
	$total =0;
	$res = mysql_query("SELECT count(*) as total FROM advertisersinfo WHERE uid='$_SESSION[uid]' and is_paid='N' order by adv_id desc");
    if (mysql_num_rows($res)) {
        $total = mysql_result($res, 0, 'total');
	}
	return $total;
}
?>