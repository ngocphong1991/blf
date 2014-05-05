<?php
include ("include/config.php");
include_once("global.php");
$msg = "";
$do = $_REQUEST['do'];
require('classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
require('classes/class_publishersinfo.php'); $cls_publishersinfo = new Publishersinfo(); $smarty->assign('cls_publishersinfo', $cls_publishersinfo);
require('classes/class_category.php'); $cls_category = new Category(); $smarty->assign('cls_category', $cls_category);

if(isset($_GET['no_www'])){
    $msg = "You hav no website to advertise on. Please register a website first.";
}

if(isset($_POST['delete_pid'])){
	mysql_query("DELETE FROM publishersinfo WHERE pid='$_POST[del_pid]'");
	header("location: publishers.php");			
	exit();
}

if($_SESSION['utype'] != 'pub+adv'){
	header("location: account.php?smw&red_url=".urlencode(basename($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING']));
	exit();
}

$_POST['catIds'] = explode(" , ", $_POST['catIds']);
if(isset($_POST[subcats]) && isset($_POST[cats])){
    $scat_list = get_sub_cat_list($_POST[cats]);
} else {
    $scat_list = get_sub_cat_list($cat_list['cid'][0]);
}

$month_date_arr = array(1=>'Tháng 1',2=>'Tháng 2',3=>'Tháng 3',4=>'Tháng 4',5=>'Tháng 5',6=>'Tháng 6',7=>'Tháng 7',8=>'Tháng 8',9=>'Tháng 9',10=>'Tháng 10',11=>'Tháng 11',12=>'Tháng 12');
$str='';
foreach($month_date_arr as $key=>$val){
	$selected='';
	if(!isset($_GET[month]) || $_GET[month]==''){
		if($key==date('n'))
		$selected ='selected="selected"';
	}else {
		if($key==$_GET[month])
		$selected ='selected="selected"';
	}
	$str .='<option '.$selected.' value="'.$key.'">'.$val.'</option>';              
}
$my_website_earnings = totalEarning();

$smarty->assign('pub_arr',$my_website_earnings);
$my_website_earnings=$my_website_earnings[total];
$smarty->assign('str',$str);
$smarty->assign('my_website_earnings',$my_website_earnings);
$smarty->assign('earning_date',date("F Y"));
$smarty->assign('scat_ids',$scat_list['sid']);
$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);
$smarty->assign('right_panel','off');

$content = $smarty->fetch('total-earnings.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

function totalEarning(){
	$month = isset($_GET[month])?intval($_GET[month]):date('n');
	if($month<10) $month = "0".$month;
	$year = isset($_GET[year])?intval($_GET[year]):date('Y');
	
	$start = $year."-".$month."-01";
	//echo $date_now;
	if($_SESSION[uid]>0){
		$slq ="select publishersinfo.pid, publishersinfo.uid, publishersinfo.set_price, publishersinfo.is_manual, advertisersinfo.start_date,advertisersinfo.ad_des, advertisersinfo.ad_url,advertisersinfo.money_sent_to_pub, advertisersinfo.end_date, advertisersinfo.adv_id, advertisersinfo.is_auth, advertisersinfo.end_date from publishersinfo LEFT JOIN (advertisersinfo) ON (advertisersinfo.pid = publishersinfo.pid) where advertisersinfo.pub_uid=".$_SESSION[uid]." and advertisersinfo.is_paid='Y' and  advertisersinfo.start_date <= SUBDATE(CURDATE(), 30) ";
		$order_by = " order by update_status DESC";
		$money_earn_obj = mysql_query($slq.$order_by);
		$total=0;
		while ($row = mysql_fetch_assoc($money_earn_obj)) {
			if($row[pid]>0){
				if($row[money_sent_to_pub]> $row[start_date]);
				echo '';
				$arr_pub[] = $row;			
				$arr_pub[total] +=  $row[set_price];
			}else continue;
		}
		//print_r($arr_pub);
		//$smarty->assign('arr_pub',$arr_pub);		
		return $arr_pub;
	}
}

?>