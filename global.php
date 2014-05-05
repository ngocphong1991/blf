<?php
$module_name = getModuleName();
$smarty->assign('module_name',$module_name);
if($_SESSION[uid]>0){
	require_once('classes/class_user.php'); 
	$cls_user = new User();
	$user_info = $cls_user->getMyProfile();
	
	if($user_info[fullname]!='')
		$smarty->assign('fullname',$user_info[fullname]);
	else $smarty->assign('fullname',$user_info[username]);
	$smarty->assign('your_balance', my_money_format('%i', $user_info[adv_money]) );
	
	if($user_info[utype]=='pub')
	$smarty->assign('my_balance',"Doanh thu Publisher: ".my_money_format('%i', $user_info[pub_money]));
	else if($user_info[utype]=='adv')
	$smarty->assign('my_balance',"<span>Số dư tài khoản Advertiser: </span>".my_money_format('%i', $user_info[adv_money]) );
	else
	$smarty->assign('my_balance',"<span>Số dư tài khoản Advertiser:</span> ". my_money_format('%i', $user_info[adv_money]));
	
	$smarty->assign('total_earnings',my_money_format('%i', $user_info[pub_money]));
	
	$smarty->assign('user_info', $user_info);
	//print_r($user_info);
}

if(connect_memcache()){
	global $Cache;
	//$Cache->set('tienpv', 1000);
	//echo $Cache->get('tienpv');
}
function connect_memcache(){
	global $Cache;	
	require_once('classes/memcache.class.php'); 
	if($Cache==null){
		//$Cache = new Memcache();
		//if(@$Cache->connect(localhost, 11211)){
			//return true;
		//}
		return false;
	}
	return true;

return false;
}

function getMyAdvertiser(){
	if($_SESSION[uid]>0){
		$adv_obj = mysql_query('' . 'SELECT adv_id, pid, uid, pub_uid FROM advertisersinfo WHERE uid=\'' . $_SESSION[uid] . '\' ');
		 while ($row = mysql_fetch_assoc($adv_obj)) {
			$pid_arr[] =  $row[pid];
		 }
		return $pid_arr;
	}
	else return array(0);
}

function getListLang(){
	
}
function my_money_format($formato, $valor) {
    // Se a funcao my_money_format esta disponivel: usa-la
    if (function_exists('money_format')) {
        return money_format($formato, $valor);
    } else return (float)$valor ." USD";
}
?>