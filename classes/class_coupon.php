<?php 
class Coupon extends dbBasic{
	function Coupon(){
		$this->pkey = "coupon_id";
		$this->tbl = "coupon";
	}
	    
	function setPaid($day=30) {
		if(!$_SESSION[uid] || $_SESSION[uid]<=0) return false;
		$date = date("Y-m-d");
		$end_date = date('Y-m-d', strtotime('+'.$day.' day', strtotime($date)));		
        if($this->updateAll("is_paid='Y', buying_date = curdate(), end_date = '".$end_date."'", "is_paid='N' AND uid = $_SESSION[uid] ")) return true;
        return false;
    }

}
?>