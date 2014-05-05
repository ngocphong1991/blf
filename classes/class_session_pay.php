<?php 
class SessionPay extends dbBasic{
	function SessionPay(){
		$this->pkey = "session_pay_id";
		$this->tbl = "session_pay";
	}
    
}
?>