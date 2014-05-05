<?php
include ("include/config.php");
include_once("global.php");
include_once("payments/NL.php");

if($_SERVER['REQUEST_METHOD']=='POST'){
    if( $_POST['amount'] && is_numeric($_POST['amount'])){
        $nl = new NL($_config['merchant_site_code'], $_config['secure_pass']);
        //Define infomation order
        $receiver = $_config['account_nganluong'];
        $return_url = $_config['www'].'success.php';
        $transaction_info="Test";
        $order_code = 'naptien';
        $price = $_POST['amount'];
        $currency = $_config['currency_char'];
        //Create Ngan Luong url
        $url= $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency);

        if($url){
            if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) echo '<script>location=\''.$url.'\'</script>';
            else  echo '<script type"javascripts">location.href=\''.$url.'\'</script>';
        }
    }else $smarty->assign('msg', 'Vui lòng nhập vào số tiền bạn muốn nạp!');
}

$content = $smarty->fetch('pay-cart.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>