<?php 
class PayLogs extends dbBasic{
	function PayLogs(){
		$this->pkey = "id";
		$this->tbl = "pay_logs";
	}
	
   function getTotalMoney($userId, $month=0, $year=0, $type='total'){
		$userId = intval($userId);
		if($userId<=0) return false;
			if($month && $year>0)
			$res_pub = mysql_query('' . 'SELECT sum(money) as total FROM pay_logs WHERE month= \'' . $month . '\',year= \'' . $year . '\', user_id=\'' . $userId . '\'  LIMIT 1');
			else
			$res_pub = mysql_query('' . 'SELECT sum(money) as total FROM pay_logs WHERE user_id=\'' . $userId . '\'  LIMIT 1');				
			
			if (mysql_num_rows($res_pub)) {             
					$total  = mysql_result($res_pub, 0, 'total');			
				}
			return $total;
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