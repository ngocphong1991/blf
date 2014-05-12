<?php
ob_start();
error_reporting(0);
session_start();

define("ENABLE_MEMCACHED", TRUE);
define("MEMCACHE_SERVER", "localhost");
define("MEMCACHE_SERVER_PORT", 11211);

$_config = array();

require_once("db_connection.php");

require_once("libs/Smarty.class.php");

include("functions.php");

include("domain-age-functions.php");

include("script-functions.php");

include("cart-functions.php");

require_once("pagination.php");

setlocale(LC_MONETARY, 'en_US');

$smarty = new Smarty;

if($admin_page == 'Y') {
	$smarty->assign('sel_tmp', $_config['template'] );
	$_config['template'] = 'default';
}

$smarty->template_dir = 'templates/'.$_config['template'].'/';
$smarty->compile_dir = 'templates_c/';
$smarty->config_dir = 'configs/';
$smarty->cache_dir = 'cache/';

//$smarty->caching = true;
//$smarty->cache_lifetime = 3600;
$smarty->compile_check = true; //
$smarty->debugging = false;  //
$smarty->error_reporting = false;

$lang_file = 'lang/'.$_config['lang'].'.php';

require_once($lang_file);

$smarty->assign('_lang',$_lang);

$smarty->assign('template_dir',$_config['www'].'/templates/'.$_config['template']);

$smarty->assign('CURRENCY',$_config['currency']);

$smarty->assign('_config',$_config);

$scfn = $_SERVER['SCRIPT_FILENAME'];
$t = explode('/', $scfn );
$cp = $t[count($t)-1];
$smarty->assign('cp',$cp);

//$tip = mysql_result(mysql_query("select tip from tips order by rand() limit 1"),0,0);
$TIP = '<p align="left" class="post-footer align-left" style="margin-bottom: 10px;">
	<span class="tips_body">
		<span class="tips">'.$_config['website_name'].' '.$_lang['Tip'].':</span>
		<strong><span id="tips_text">'.
			stripslashes($tip);
		'</span></strong>
	</span>
</p>';

if($_SESSION[uid]){
	$total_cart = getTotalCart();
	$smarty->assign('total_cart', $total_cart);

}else{
    if(isset($_COOKIE["login"]) && is_numeric($_COOKIE["login"])){
        $res = mysql_query('' . 'SELECT * FROM users WHERE uid=\'' . mysql_real_escape_string(strip_tags(trim($_COOKIE["login"]))) . '\' LIMIT 1');
        if (mysql_num_rows($res)) {
            if (!mysql_result($res, 0, 'status')) {
                return 'suspended';
            }
            $_SESSION['uid']      = mysql_result($res, 0, 'uid');
            $_SESSION['username'] = mysql_result($res, 0, 'username');
            $_SESSION['fullname'] = mysql_result($res, 0, 'fullname');
            $_SESSION['adv_money'] = mysql_result($res, 0, 'adv_money');
            $_SESSION['pub_money'] = mysql_result($res, 0, 'pub_money');
            $_SESSION['utype']    = mysql_result($res, 0, 'utype');
            $_SESSION['email']    = mysql_result($res, 0, 'email');
            if ($_SESSION['utype'] == 'pub+adv') {
                $_SESSION['show_pub_stat'] = 'Y';
            } else {
                $_SESSION['show_pub_stat'] = 'N';
            }
        }
    }
}
ob_end_clean();
?>
