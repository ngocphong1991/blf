<?php
include ("../include/config.php");
require_once('classes/class_user.php');
require_once('nusoap.php');
$secure_pass = $_config['secure_pass']; // Mật khẩu giao tiếp API của Merchant với NgânLượng.vn


function UpdateOrder($transaction_info,$order_code,$payment_id,$payment_type,$secure_code)
{                    
    global $secure_pass;
	// Kiểm tra chuỗi bảo mật
   	$secure_code_new = md5($transaction_info.' '.$order_code.' '.$payment_id.' '.$payment_type.' '.$secure_pass);
	if($secure_code_new != $secure_code)
	{
		return -1; // Sai mã bảo mật
	}
	else // Thanh toán thành công
	{
        $tracking = array();
        $check_order = mysql_query('SELECT * FROM tracking_order WHERE payment_id=\'' . $payment_id . '\' LIMIT 1');
        if (mysql_num_rows($check_order)) {
            $tracking['uid']      = mysql_result($check_order, 0, 'uid');;
            $tracking['money_before'] = mysql_result($check_order, 0, 'money_before');
            $tracking['money_after']    = mysql_result($check_order, 0, 'money_after');
            $tracking['amount']    = mysql_result($check_order, 0, 'amount');
        }
        $cls_user = new User();

        // Trường hợp là thanh toán tạm giữ. Hãy đưa thông báo thành công và cập nhật hóa đơn phù hợp
		if($payment_type == 2)
		{
            if($tracking){
                mysql_query('UPDATE tracking_order SET payment_type=\'' . $payment_type . '\', error_text=\'pending\' WHERE payment_id=\'' . $payment_id . '\' LIMIT 1');
            }
			// Lập trình thông báo thành công và cập nhật hóa đơn
		}
		// Trường hợp thanh toán ngay. Hãy đưa thông báo thành công và cập nhật hóa đơn phù hợp
		elseif($payment_type == 1)
		{
            if($tracking){
                mysql_query('UPDATE tracking_order SET payment_type=\'' . $payment_type . '\', money_before=\'' . $tracking['money_before'] . '\', money_after=\'' . ($tracking['money_before'] + $tracking['amount']) . '\' WHERE payment_id=\'' . $payment_id . '\' LIMIT 1');
                $cls_user->plusMoney($tracking['uid'], trim($tracking['amount']));
            }
			// Lập trình thông báo thành công và cập nhật hóa đơn			
		}
	}
}

function RefundOrder($transaction_info,$order_code,$payment_id,$refund_payment_id,$payment_type,$secure_code)
{                    
    global $secure_pass;
	// Kiểm tra chuỗi bảo mật
   	$secure_code_new = md5($transaction_info.' '.$order_code.' '.$payment_id.' '.$refund_payment_id.' '.$secure_pass);
	if($secure_code_new != $secure_code)
	{
		return -1; // Sai mã bảo mật
	}	
	else // Trường hợp hòan trả thành công
	{
		// Lập trình thông báo hoàn trả thành công và cập nhật hóa đơn
        $check_order = mysql_query('SELECT * FROM tracking_order WHERE payment_id=\'' . $payment_id . '\' LIMIT 1');
        if (mysql_num_rows($check_order)) {
            mysql_query('UPDATE tracking_order SET payment_type=\'' . $payment_type . '\', error_text=\'cancel\' WHERE payment_id=\'' . $payment_id . '\' LIMIT 1');
        }
    }
}
// Khai bao chung WebService
$server = new nusoap_server();
$server->configureWSDL('WS_WITH_SMS',NS);
$server->wsdl->schemaTargetNamespace=NS;
// Khai bao cac Function
$server->register('UpdateOrder',array('transaction_info'=>'xsd:string','order_code'=>'xsd:string','payment_id'=>'xsd:int','payment_type'=>'xsd:int','secure_code'=>'xsd:string'),array('result'=>'xsd:int'),NS);
$server->register('RefundOrder',array('transaction_info'=>'xsd:string','order_code'=>'xsd:string','payment_id'=>'xsd:int','refund_payment_id'=>'xsd:int','payment_type'=>'xsd:int','secure_code'=>'xsd:string'),array('result'=>'xsd:int'),NS);
// Khoi tao Webservice
$HTTP_RAW_POST_DATA = (isset($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA :'';
$server->service($HTTP_RAW_POST_DATA);
?>