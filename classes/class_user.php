<?php 
class User extends dbBasic{
	function User(){
		$this->pkey = "uid";
		$this->tbl = "users";
	}
    function getMyProfile() {
        $id = $_SESSION['uid'];
        $res = $this->getOne($id);
        return $res;
    }
		
	function getUserInfo($id) {
        $id = intval($id);
		if($id<=0) return false;
        $res = $this->getOne($id);
        return $res;
    }
	function getEmail($id) {
        $id = intval($id);
		if($id<=0) return false;
        $res = $this->getOne($id);
        return $res[email];
    }
	
    function plusMoney($uid, $money) {
        $one = $this->getOne($uid);
        $value = $one['adv_money'];
        $money+=$value;
        if($this->updateOne($uid,"adv_money='".$money."'")) return true;
        else return false;
    }
    function minusMoney($uid, $money) {
        $money = $money;
        $one = $this->getOne($uid);
        $value = $one['adv_money'];
        $value=$value-$money;
        if($this->updateOne($uid,"adv_money='".$value."'")) return true;
        else return false;
    }
    function getYourMoney() {
        $res = $this->getMyProfile();
        return $res['adv_money'];
    }
	function is_publishers($uid) {
        $one = $this->getOne($uid);
        $type = $one['utype'];
        $mask = str_replace('pub', '', $type);
        if($mask==$type) return false;
        else return true;
    }
	function getUserName($uid) {
        $one = $this->getOne($uid);
        return $one['username'];
    }
	
    function trans_money($money) {
        $money = (int)$money;
        $id = $_SESSION['uid'];
        $one = $this->getOne($id);
        
        if($id=='' || $id==0 || $money<0 || $money>$one['pub_money']) return false;
        else {
            $pub_money = $one['pub_money']-$money;
            $adv_money = $one['adv_money']+$money;
            
            $value = "pub_money='$pub_money', adv_money='$adv_money'";
            if($this->updateOne($id, $value)) return true;
            else return false;
        }
    }
	function WithDraw($money) {
        $money = (int)$money;
        $id = $_SESSION['uid'];
        $one = $this->getOne($id);
        
        if($id=='' || $id==0 || $money<0 || $money>$one['pub_money']) return false;
        else {
            $pub_money = $one['pub_money']-$money;            
            $value = "pub_money='$pub_money'";
            if($this->updateOne($id, $value)) return true;
            else return false;
        }
    }
    
    
}
?>