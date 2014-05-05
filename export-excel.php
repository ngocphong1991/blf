<?php
include ("include/config.php");
$msg = "";

$userId = intval($_SESSION[uid]);
if($userId<=0) {echo 'Not exit, please login first'; exit();}

$order_id = isset($_GET[order_id])?intval($_GET[order_id]):0;
$adv_id = isset($_GET[adv_id])?intval($_GET[adv_id]):0;
$export_cls = isset($_GET[type])?$_GET[type]:'';


if($order_id<=0 && $adv_id>0) $order_id = $adv_id;

require('classes/class_advertisersinfo.php');
$cls_advertisersinfo = new Advertisersinfo();

if(isset($order_id) && $order_id>0){ $where = 'adv_id = '.$order_id; } else $where = 'is_paid="Y"';

if(isset($_POST[update]) && $_POST[link_text] && ($_POST[order_id]>0)){
	$key = $_POST[order_id];
  	$value = "ad_des='".stripslashes($_POST['link_text'])."'";
	if($_POST['link_url'])
	$value .= ",ad_url='".stripslashes($_POST['link_url'])."'";
    // $value .= ",ad_after='".$val['ad_after']."'";
	//$value .= ",ad_url='".$val['ad_url']."'";
	$cls_advertisersinfo->updateOne($key, $value);
}
$all = getListOrder($order_id, $userId);
if($order_id>0)
	export_excel($all[ids]);
else 
	export_excel($all[all]);
$where .=  ' and uid = '.$userId;

function getListOrder($adv_id=0, $userId){
$list_arr = array();
$list_order = mysql_query("select publishersinfo.pid, publishersinfo.url, publishersinfo.websitename,publishersinfo.google_page_rank, publishersinfo.description, publishersinfo.sale_price, advertisersinfo.adv_id, advertisersinfo.ad_des, advertisersinfo.buying_date,advertisersinfo.end_date, advertisersinfo.ad_url,advertisersinfo.is_auth from publishersinfo LEFT JOIN (advertisersinfo) ON (advertisersinfo.pid=publishersinfo.pid) where publishersinfo.status = 2 and advertisersinfo.uid =".$userId."  and advertisersinfo.is_paid='Y' ");
		
	while($r = @mysql_fetch_assoc($list_order)) {		
			$r[cancel] = 0;
			if(date("Y-m-d")==$r[buying_date])
				$r[cancel]=1;
			$list_arr[ids][] = $r;					
			$list_arr[all][] = $r;
			
	}
	return $list_arr;
}

//$all = $cls_advertisersinfo->getAll($where);
$smarty->assign('order_id', $order_id);
$smarty->assign('ids', $all[ids]);
$smarty->assign('all', $all[all]);
if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=="submit"){
}

$content = $smarty->fetch('links.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

function export_excel($arr_adv){
$result = array();
	$filename ="links.xls";
    //$result=mysql_query("select * from tbl_name");
    function xlsBOF()
    {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
    }
    function xlsEOF()
    {
    echo pack("ss", 0x0A, 0x00);
    return;
    }
    function xlsWriteNumber($Row, $Col, $Value)
    {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
    }
    function xlsWriteLabel($Row, $Col, $Value )
    {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
    return;
    }
    header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
    xlsBOF();
    xlsWriteLabel(0,0,"Website URL");
    xlsWriteLabel(0,1,"Website Title");
    xlsWriteLabel(0,2,"Order");
	xlsWriteLabel(0,3,"Status");
	
	xlsWriteLabel(0,4,"Start Date");
    xlsWriteLabel(0,5,"Stop Date");
    xlsWriteLabel(0,6,"Pagerank");
	xlsWriteLabel(0,7,"Link Text");
	xlsWriteLabel(0,8,"Link URL");
	xlsWriteLabel(0,9,"Price/mo");
    $xlsRow = 2;
    foreach($arr_adv as $key =>$val){
		xlsWriteLabel($xlsRow,0,$val[url]);
		xlsWriteLabel($xlsRow,1,$val[websitename]);
		xlsWriteLabel($xlsRow,2,$val[adv_id]);
		xlsWriteLabel($xlsRow,3, $val[is_auth]);
		xlsWriteLabel($xlsRow,4, $val[start_date]);
		xlsWriteLabel($xlsRow,5,$val[end_date]);
		xlsWriteLabel($xlsRow,6, $val[google_page_rank]);
		xlsWriteLabel($xlsRow,7,$val[ad_des]);
		xlsWriteLabel($xlsRow,8,$val[ad_url]);
		xlsWriteLabel($xlsRow,9,$val[sale_price]);
		$xlsRow = $xlsRow;
		$xlsRow++;
	}
    
   
    xlsEOF();
}
?>