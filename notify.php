<?php
include ("include/config.php");
require_once('classes/class_user.php'); 
$cls_user = new User();

error_reporting(E_ALL ^ E_NOTICE); 
$uid = $_GET['uid'];
$email = $_GET['ipn_email']; 
$header = ""; 
$emailtext = ""; 
	
$data['item_number'] 		= $_POST['item_number1'];
$data['payment_status'] 	= $_POST['payment_status'];
$data['payment_amount'] 	= $_POST['mc_gross'];
$data['payment_currency']	= $_POST['mc_currency'];
$data['tax']				= $_POST['tax'];
//$data['receiver_email'] 	= $_POST['receiver_email'];
$data['payer_email'] 		= $email;

// Read the post from PayPal and add 'cmd' 
$req = 'cmd=_notify-validate'; 
if(function_exists('get_magic_quotes_gpc')) 
{  
$get_magic_quotes_exists = true; 
} 
foreach ($_POST as $key => $value) 
// Handle escape characters, which depends on setting of magic quotes 
{  
if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){  
	$value = urlencode(stripslashes($value)); 
} else { 
	$value = urlencode($value); 
} 
$req .= "&$key=$value"; 
} 
// Post back to PayPal to validate 
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n"; 
$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n"; 
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// Process validation from PayPal 
// TODO: This sample does not test the HTTP response code. All 
// HTTP response codes must be handled or you should use an HTTP 
// library, such as cUrl 


if (!$fp) { // HTTP ERROR 
} else { 
// NO HTTP ERROR 
fputs ($fp, $header . $req); 
while (!feof($fp)) { 
$res = fgets ($fp, 1024); 
if (strcmp ($res, "VERIFIED") == 0) { 
	// TODO: 
	// Check the payment_status is Completed 
	// Check that txn_id has not been previously processed 
	// Check that receiver_email is your Primary PayPal email 
	// Check that payment_amount/payment_currency are correct 
	// Process payment 
	// If 'VERIFIED', send an email of IPN variables and values to the 
	// specified email address 
	foreach ($_POST as $key => $value){ 
		$emailtext .= $key . " = " .$value ."\n\n"; 
	} 	
	if($uid>0 && number_format($data["payment_amount"])>0){
		$user_info = $cls_user->plusMoney($uid, trim($data["payment_amount"]));
		//mysql_query("update advertisersinfo set is_paid='Y', is_auth='Y', buying_date=curdate() where uid='".$uid."' and is_paid='N'");
	}
		mysql_query('' . 'insert into payments set payment_status=\''.$data["payment_status"].'\', advid=\''.$uid.'\', payment_amount = \''.$data["payment_amount"].'\', advemail=\''.$email.'\', text=\''.$emailtext.'\', payment_time=\''.time().'\' ');	
	
	//mail($email, "Live-VERIFIED IPN", $emailtext . "\n\n" . $req); 
} else if (strcmp ($res, "INVALID") == 0) { 
	// If 'INVALID', send an email. TODO: Log for manual investigation. 
	foreach ($_POST as $key => $value){ 
	$emailtext .= $key . " = " .$value ."\n\n"; 
	} 
		mysql_query('' . 'insert into payments set payment_status=\'NotOK\', text=\''.$emailtext.'\'');
	//mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req); 
	}	 
} 
} 
fclose ($fp); 
?>
