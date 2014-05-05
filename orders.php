<?php
include ("include/config.php");
include ("global.php");
$msg = "";

if(!isset($_SESSION[uid])){	
	header("location: ".$_config[www]."/account.php");			
	exit();
}
//@ get lastest order
function getListOrders(){
	if(!$_SESSION[uid]) return false;
	
	//echo "SELECT * FROM advertisersinfo WHERE uid = '$_SESSION[uid]' and is_paid ='Y' ORDER BY pid DESC";	
	$lastest_order = mysql_query("SELECT * FROM advertisersinfo WHERE uid = '$_SESSION[uid]' and is_paid ='Y' ORDER BY adv_id DESC");	
	while($r = @mysql_fetch_assoc($lastest_order)) {
		$lastest_order_arr[] = array('pid'=>$r['pid'], 'adv_id'=>$r['adv_id'], 'ad_des'=>$r['ad_des'],'req_date'=>$r['req_date'],'buying_date'=>$r['buying_date'], 'ad_url'=>$r['ad_url'], 'price'=>my_money_format('%i', $r['price']));		
	}
	return $lastest_order_arr;
}

$lastest_order = getListOrders();
if($lastest_order) $smarty->assign('lastest_order',$lastest_order);

$content = $smarty->fetch('orders.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>