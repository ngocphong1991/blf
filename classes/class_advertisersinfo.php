<?php 
class Advertisersinfo extends dbBasic{
	function Advertisersinfo(){
		$this->pkey = "adv_id";
		$this->tbl = "advertisersinfo";
	}
    function setPaid($day=30, $date='') {
		if(!$_SESSION[uid] || $_SESSION[uid]<=0) return false;
		if(!$date)
		$date = date("Y-m-d");
		$end_date = date('Y-m-d', strtotime('+'.$day.' day', strtotime($date)));	
		

        if($this->updateAll("is_paid='Y', buying_date = curdate(), end_date = '".$end_date."'", "is_paid='N' AND uid = $_SESSION[uid] ")) return true;
        return false;
    }
	
	function setRenew($adv_id, $day=30, $end_date) {
		if(!$_SESSION[uid] || $_SESSION[uid]<=0) return false;
		$date = date("Y-m-d");
		//$end_date = date('Y-m-d', strtotime('+'.$day.' day', strtotime($date)));		
        if($this->updateAll("is_paid='Y', buying_date = curdate(), end_date = '".$end_date."'", "adv_id=$adv_id AND uid = $_SESSION[uid] ")) return true;
        return false;
    }
	
	function getPendingMoney(){
		if(!$_SESSION[uid] || $_SESSION[uid]<=0) return false;
		$total = $this->getSum('set_price', 'end_date > CURDATE() and is_paid = "Y" and pub_uid = '.$_SESSION[uid].'');
		return $total;				
	}
	
	function setUserPaid(){
		
	}
	
	function getLastestOrder($pid=0){
		$one = $this->getOne($pid);
        return $one['set_price'];
	}
	
	function getSalePrice($adv_id=0){
		$one = $this->getOne($adv_id);
        return $one['price'];
	}
	
	function getUserOrder(){
		
	}
}
?>