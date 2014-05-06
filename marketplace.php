<?php
include ("include/config.php");
include_once("global.php");

if(!isset($_SESSION[uid])){	
	header("location: ".$_config[www]."/account.php");			
	exit();
}

$meta[title] ='Buylink - Nơi bạn thỏa mãn niềm đam mê SEO của mình !';
$meta[des] ='Buylink giúp bạn chọn mua các textlink có giá trị cao với chi phí hợp lý, thỏa mãn niềm đam mê xây dựng backlinks và nâng cao thứ hạng từ khóa cho website của bạn.';
$smarty->assign('meta', $meta);
if(isset($_GET['offset']))
$offset=$_GET['offset'];
else $offset=0;
$limit=10;
$num=0;

$res = mysql_query('select count(pid) as total, SUM(price) as price from advertisersinfo where is_paid="N" and uid=' . $_SESSION['uid']);
$total_price = mysql_result($res, 0, 'price');

if($_GET['keywords']!='Nhập từ khóa cần tìm' && $_GET['keywords']!='')
$keywords = $_GET['keywords'];
else $keywords='';
$category_id=isset($_GET['category_id'])?intval($_GET['category_id']):0;
$link_score=isset($_GET['link_score'])?intval($_GET['link_score']):0;
$langid=isset($_GET['language'])?$_GET['language']:'';
$type = isset($_GET['type'])?htmlspecialchars($_GET['type']):'';
$domain = isset($_GET['domain']) && $_GET['domain'] != 'Tên miền' ? $_GET['domain'] : '';

$category = '';
$param = " where ";	
$search = '';
if($keywords)
	$search .= " and  (description like '%$keywords%' or websitename like '%$keywords%') ";
if(is_int($link_score) && $link_score>0)
    $search .= " and google_page_rank >= '$link_score' ";
if($langid>0)
    $search .= " and langid='$langid'' ";
if($domain)
    $search .= " and url like '%$domain%' ";
	
$in_arr_str = implode(',',	$in_array);

$ws_qry = "select * from publishersinfo where  status = '2' and sale_price>0 $search order by pid desc";

$num = mysql_num_rows(mysql_query($ws_qry));

$ws = mysql_query("$ws_qry limit $offset, $limit");

$idx=0;
//$list_my_arr = getMyAdvertiser();
 while ($row = @mysql_fetch_assoc($ws)) {
 	$idx++;
	$val = ($idx%2==0)?'2':'1';		
	if($category_id>0){
		$catids = explode(" , ", $row['catIds']);
			if(!in_array($category_id, $catids)) {
				 continue;
			}
		}		
	
	$def_len = $_SESSION[show_length];
	$def_ad_type = $_SESSION[show_cat];
	if($def_len == 0 && $def_ad_type='txt_ad') $def_ad_type = 'ppc_txt_ad';

	$c[] = array ('pid' => $row[pid], 'wname' => $row[websitename],'description' => $row[description], 'alexa_rank' => $row[alexa_rank],'domain_age'=>$row[domain_age], 'domain_ext'=>getDomainName($row[url]), 'google_page_rank'=>$row[google_page_rank], 'daily_users' => $max_u, 'cpc' => $a_cpc, 'cost' => $cst, 'T' => $T, 'I' => $I, 'V' => $V, 'key'=>$val,'domain_age'=>timeAgo($row['domain_age']),'sale_price'=>my_money_format('%i', $row['sale_price']), 'lang'=>getLangName($row[langid]), 'unit_price'=>$row['unit_price']);
 }

$smarty->assign('winfo', $c);

// Pagination
$TblPagignationClass = new  TblPagignationClass('Previous','Next',$limit, $_GET);
$TblPagignationClass->SetOffset($offset) ;
$TblPagignationClass->SetNumofRows($num) ;
$TblPagignationClass->SetFileName($_SERVER['PHP_SELF']) ;
$Template_Pagignation_Data = $TblPagignationClass->CreatePagignationData() ;

$smarty->assign('Template_Pagignation_Data', $Template_Pagignation_Data);

$offset=1;
$smarty->assign('offset', $offset);
$smarty->assign('cat_menu', get_list('category', 'category'));

while ($rl = mysql_fetch_assoc($lres)) {
	$tl = $rl[length];
	$lens[$tl] = $tl.' '.$_lang['Day'].' '.$_lang['Ads'];
	}

$lang_list = get_list('language','language');
$smarty->assign('langs',$lang_list['language']);
$smarty->assign('lang_ids',$lang_list['lid']);
$smarty->assign('total_price',$total_price. " ".$_lang['money']);
$cat_list = get_list('category','category');
$smarty->assign('cats',$cat_list['category']);
$smarty->assign('cat_ids',$cat_list['cid']);

$smarty->assign('len_menu', $lens);
$smarty->assign('right_panel', 'off');
$content = $smarty->fetch('marketplace.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>