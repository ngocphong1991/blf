<?php 
class Coupon extends dbBasic{
	function Coupon(){
		$this->pkey = "coupon_card_id";
		$this->tbl = "coupon_card";
	}
	
	function getRandom($l=10) {
		return strtoupper(substr(md5(uniqid(mt_rand().time(), true)), 0, $l));
	}
}
?>