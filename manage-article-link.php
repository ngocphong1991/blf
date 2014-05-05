<?php
include ("include/config.php");
$msg = "";
$userId = intval($_SESSION[uid]);
if(!isset($_SESSION[uid])){
    header("location: ".$_config[www]."/account.php");
    exit();
}

$order_id = isset($_GET[order_id])?intval($_GET[order_id]):0;
$adv_id = isset($_GET[adv_id])?intval($_GET[adv_id]):0;
$export_cls = isset($_GET[type])?$_GET[type]:'';
$status_id = isset($_GET[status_id])?$_GET[status_id]:'';

$smarty->assign('_session',$_SESSION);
if($status_id){
    if($order_id<=0 && $adv_id>0) $order_id = $adv_id;
    require('classes/class_advertisersinfo.php');
    $cls_advertisersinfo = new Advertisersinfo();

    if(isset($order_id) && $order_id>0){ $where = 'adv_id = '.$order_id; } else $where = 'is_paid="Y"';

    if(isset($_POST[update]) && $_POST[link_text] && ($_POST[order_id]>0)){
        $key = $_POST[order_id];
        $value = "ad_des='".stripslashes($_POST['link_text'])."'";
        if($_POST['link_url'])
            $value .= ",ad_url='".stripslashes($_POST['link_url'])."'";
        $value .= ",update_time='".time()."'";
        //$value .= ",ad_url='".$val['ad_url']."'";
        $advertiser_info = $cls_advertisersinfo->getOne($key);
        if(date('m') == date("m", $advertiser_info[update_time])){ $msg = '<span style="color:red">You cannot update advertise link two times per month.</span>' ;}
        else{
            $cls_advertisersinfo->updateOne($key, $value);
            $msg = '<span style="color:geen">Update successful.</span>' ;
        }
    }
    $all = getListOrder($order_id, $userId);
    if($export_cls) export_excel($all[all]);

    $where .=  ' and uid = '.$userId;

    //$all = $cls_advertisersinfo->getAll($where);
    $smarty->assign('msg', $msg);
    $smarty->assign('order_id', $order_id);
    $smarty->assign('ids', $all[ids]);
    $smarty->assign('all', $all[all]);
    $content = $smarty->fetch('manage-article-link.tpl');
}else{
    $content = $smarty->fetch('manage-article-link.tpl');
}

function getListOrder($adv_id=0, $userId){
    $list_arr = array();
    $tlwhere =" WHERE publishersinfo.status = 2 and advertisersinfo.uid =".$userId."  and advertisersinfo.is_paid='Y' ";
    if($adv_id>0)
        $tlwhere .= " AND advertisersinfo.adv_id = ".$adv_id." ";
    $list_order = mysql_query("select publishersinfo.pid, publishersinfo.url, publishersinfo.websitename,publishersinfo.google_page_rank, publishersinfo.description, advertisersinfo.price, advertisersinfo.adv_id, advertisersinfo.ad_des, advertisersinfo.buying_date,advertisersinfo.end_date, advertisersinfo.ad_url from publishersinfo LEFT JOIN (advertisersinfo) ON (advertisersinfo.pid=publishersinfo.pid) ".$tlwhere." order by advertisersinfo.adv_id DESC ");
    while($r = @mysql_fetch_assoc($list_order)) {
        $r[cancel] = 0;
        if(date("Y-m-d")==$r[buying_date])
            $r[cancel]=1;
        $list_arr[ids][] = $r;
        $list_arr[all][] = $r;

    }
    return $list_arr;
}

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
        xlsWriteLabel($xlsRow,0,'dantri.com.vn');
        xlsWriteLabel($xlsRow,1,'dan tri');
        xlsWriteLabel($xlsRow,2,'123');
        xlsWriteLabel($xlsRow,3,'accepted');
        xlsWriteLabel($xlsRow,4,'dan tri');
        xlsWriteLabel($xlsRow,5,'21/3');
        xlsWriteLabel($xlsRow,6,'1');
        xlsWriteLabel($xlsRow,7,'dan tri');
        xlsWriteLabel($xlsRow,8,'http://tinmoi.vn');
        xlsWriteLabel($xlsRow,9,'10');
        echo  $xlsRow;
    }
    $xlsRow++;

    xlsEOF();
}
?>