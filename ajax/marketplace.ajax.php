<?php
include ("../include/config.php");
include ("../global.php");
if($_SESSION[uid]<=0){
	$arr = array("result"=>"failure","output"=> "");
	echo json_encode($arr);
}

$pid = intval($_POST[id]);
$type = $_POST[type];
$url = $_POST[url];
$text = $_POST[text];
	if($_POST[action]=="add_to_cart"){
	if(isset($pid) && $_SESSION[uid]>0){		
		if(checkIssetAdvertise($pid)){		
		$_POST[pub_uid] = 1;		
			updateAdvertise($pid,'insert',30);
		}else {
			updateAdvertise($pid,"update",30);
		}		
		$arr = array("id"=>$pid);
	}
	echo json_encode($arr);
}
if($_POST[action]=="remove_from_cart" && $_SESSION[uid]>0){
 	mysql_query('' . 'delete from advertisersinfo where pid=\'' . $pid . '\' and is_paid= \'N\' and uid=\'' . $_SESSION[uid] . '\'');
	$arr = array();
	echo json_encode($arr);
}

if($_POST[action]=="get_cart_labels"){
	$res = mysql_query('select count(pid) as total, SUM(price) as price from advertisersinfo where is_paid="N" and uid=' . $_SESSION['uid']);
	$total = mysql_result($res, 0, 'total');
	$price = mysql_result($res, 0, 'price');
	$arr = array("items"=>$total,"num_regular"=> $total,"num_context"=>"0","subtotal"=> "$560.00", "discount"=>"$0.00","initial"=>"$560.00","total"=>$price. " ".$_lang[money]);
	echo json_encode($arr);
}

// case search regular links
if($_POST[action]=="search_regular"){
$category_id = isset($_POST[category_id])?intval($_POST[category_id]):0;
$link_score = isset($_POST[link_score])?intval($_POST[link_score]):0;
$keyword = ($_POST[keywords]=='Enter your keyword(s)')?'':addslashes($_POST[keywords]);

$value = ($type=='regular')?'Regular Links':'Context Links';

$link_score = isset($_POST[link_score])?intval($_POST[link_score]):0;
$langid = isset($_POST[langid])?intval($_POST[langid]):0;

$list_pulisher_info = getListPublisherInfo(0, $keyword,'',$category_id, $link_score, $langid);

$html = '';
foreach($list_pulisher_info[info] as $val){
$html .= '<tr class="row1"> <td><div><a href="'.$_config['www'].'/view-site.php?pid='.$val[pid].'">'.$val[description].'</a></div></td><td class="centered">'.getLangName($val[langid]).'</td> <td class="centered">'.$val[google_page_rank].' </td><td class="centered">'.$val[alexa_rank].'</td><td class="centered">'.timeAgo($val[domain_age]).'</td> <td class="alignright large green bold">'.my_money_format('%i', $val[sale_price]).'</td> <td class="alignright large green bold">'.getDomainName($val[url]).'</td><td class="centered"><a onclick="addToCart(this, \'regular\', '.$val[pid].', \'\', \'\', \'\'); return false;" href="#"><img alt="Add to cart" src="'.$_config[www].'/templates/'.$_config[template].'/images/btn-add-cart.png"></a></td></tr>';
}


$arr = array("output"=>'<h2>Showing 1 - 1 of '.$list_pulisher_info[total].' results for "'.$keyword.'" (PR '.$link_score.'+) in '.$value.'</h2><!--<div class="pagination"><span class="pages">Pages:</span> <span class="current">1</span> </div>--><table class="data large marketplace" id="marketplace-table"> <thead> <tr> <th><a onclick="sortMartketplace(\'title\', \'ASC\'); return false;" href="#">Website Details</a></th>  <th style="width: 80px;">Language</th><th style="width: 20px;">PageRank</th><th style="width: 50px;">Alexa</th><th style="width: 78px;">Domain age</th>	<th style="width: 75px;">Price/mo</th><th style="width: 10px;">TLD</th><th style="width: 73px;" class="last">Add to cart</th><th style="width: 73px;" class="last"></th> </tr> </thead> <tbody>'.$html.' </tbody> </table><!--<div class="pagination"><span class="pages">Pages:</span> <span class="current">1</span></div>-->');
echo json_encode($arr);
}


function updateAdvertise($pid,$type='insert', $length=30){
	//$length = $_POST[ad_length];
	$sdate = date("Y-m-d");
	if(!isset($pid) || $pid<=0) return false;
	$_POST[ad_type] = 'txt_ad';
	
	$arr_publisher = array();
	$publisher_obj = mysql_query('' . 'SELECT pid, sale_price,set_price, uid, websitename, url FROM publishersinfo WHERE pid=\'' . $pid . '\' LIMIT 1');
	
    if (mysql_num_rows($publisher_obj)) {
		$arr_publisher[pid] = mysql_result($publisher_obj, 0, 'pid');
        $arr_publisher[price] = mysql_result($publisher_obj, 0, 'sale_price');
		$arr_publisher[set_price] = mysql_result($publisher_obj, 0, 'set_price');
		$arr_publisher[websitename] = mysql_result($publisher_obj, 0, 'websitename');
		$arr_publisher[url] = mysql_result($publisher_obj, 0, 'url');
		$arr_publisher[pub_uid] = mysql_result($publisher_obj, 0, 'uid');
    } 
	
	if($arr_publisher[pid] && $type='insert'){
		$insert = mysql_query("insert into advertisersinfo set uid='$_SESSION[uid]', pub_uid='".$arr_publisher[pub_uid]."', pid='$pid', ad_type='$_POST[ad_type]', ad_id='$_POST[order_product_id]', site_name='".safe_entry($sitename)."', ad_hl='', ad_des='".safe_entry($ad_des)."', ad_url='".safe_entry($ad_url)."', price='".$arr_publisher[price]."', set_price='".$arr_publisher[set_price]."', req_date=curdate(), start_date='$sdate', end_date = DATE_ADD('$sdate', INTERVAL $length DAY), approved='N', is_paid='N', is_auth='N' ");	
		$ins_id = mysql_insert_id();
		return $ins_id;
	}else{
		$res = mysql_query('' . 'update `advertisersinfo` set  `price`=\'' . $arr_publisher[price] . '\' , `req_date`=\'' . curdate() . '\'  where pid=\'' . $pid . '\'');
		}
	
	return false;
}

function checkIssetAdvertise($pid){	
	$res = mysql_query('' . 'SELECT adv_id FROM advertisersinfo WHERE pid=\'' . $pid . '\' AND uid=\'' . $_SESSION[uid] . '\' LIMIT 1');
	if (mysql_num_rows($res)) {
		return false;
	}
	else return true;
}
?>
