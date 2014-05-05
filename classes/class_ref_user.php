<?php 
class RefUser extends dbBasic{
	function RefUser(){
		$this->pkey = "ref_user_id";
		$this->tbl = "ref_user";
	}
	
    function get_my_ref($user_id=0) {
		if($user_id<=0)		
        $user_id = $_SESSION['uid'];
		else $user_id = intval($user_id);
        if(!$user_id) return '';
        $all = $this->getAll("user_id='".$user_id."'");
        $one = $all[0];        
        $title = $one['title'];
        if($title) return $title;
        else {
            $f = 'user_id, title';
            $v = "'".$user_id."','".$this->gen_chars().$user_id."'";
            if($this->insertOne($f, $v)) return $this->get_my_ref();
            else return '';
        }
    }
	
	function getReferFromUserId($userId){
		$userId = intval($userId);
		if($userId<=0) return false;
		
		$res = mysql_query('' . 'SELECT title FROM ref_user WHERE user_id=\'' . $userId . '\' LIMIT 1');
		if (mysql_num_rows($res)) {             
			$refer_code      = mysql_result($res, 0, 'title');	
			return $refer_code;
		}
		else return '';
		
	}
	
	function getAffiliateFromPub($userId, $admin_tranfer_date=''){
		$userId = intval($userId);
		if($userId<=0) return false;
		if($admin_tranfer_date) $condition = 'and update_time> "'.$admin_tranfer_date.'"';
		$res_pub = mysql_query('' . 'SELECT sum(earnings) as total FROM earnings WHERE uid=\'' . $userId . '\'  LIMIT 1');				
			
			if (mysql_num_rows($res_pub)) {             
					$total      = mysql_result($res_pub, 0, 'total');			
				}
				return $total;
	}
	
	function getAffiliateFromAdv($userId, $ref_code=''){
		$userId = intval($userId);
		if($userId<=0) return false;
		if($ref_code){
			$adver_earnings = 0;
			//echo 'SELECT price, coupon_price, coupon_length FROM advertisersinfo WHERE ref_code=\'' . $ref_code . '\' and is_paid= \'Y\'';
			$res_adv = mysql_query('' . 'SELECT price, coupon_price, coupon_length FROM advertisersinfo WHERE ref_code=\'' . $ref_code . '\' and is_paid= \'Y\'');
			while ($row = mysql_fetch_assoc($res_adv)) {				
				if($row[coupon_price]>0 && $row[coupon_length]>1)
					$adver_earnings += $row[price]*(1- $row[coupon_price])*$row[coupon_length]*(1/10);	
				else if($row[coupon_price]>0)
					$adver_earnings += $row[price]*(1- $row[coupon_price])*(1/10);	
				else 
					$adver_earnings += $row[price]*(1/10);
				}
				return $adver_earnings;			
		}else{
			$res_adv = mysql_query('' . 'SELECT sum(price) as total, coupon_price, coupon_length FROM advertisersinfo WHERE uid=\'' . $userId . '\' and is_paid= \'Y\' LIMIT 1');				
			
			if (mysql_num_rows($res_adv)) {             
				$total      = mysql_result($res_adv, 0, 'total');	
				$coupon_price = mysql_result($res_adv, 0, 'coupon_price');	
				$coupon_length = mysql_result($res_adv, 0, 'coupon_length');
				
				if($coupon_price>0 && $coupon_length>1)
					$adver_earnings = $total*(1- $coupon_price)*$coupon_length*(1/10);	
				else if($coupon_price>0)
					$adver_earnings = $total*(1- $coupon_price)*(1/10);	
				else 
					$adver_earnings = $total*(1/10);
					
				return $adver_earnings;
			}
		}
		return 0;
	}
	
	function getAffiliateEarning($userId, $type='total', $ref_val=''){
		$userId = intval($userId);
		if($userId<=0) return false;
		if(!$ref_val)
		$ref_val = $this->getReferFromUserId($userId);
		$affiliate = array();
		
		$affiliate[advertiser] =0; $affiliate[publisher] = 0;
		if($ref_val && $ref_val!=''){			
			$res = mysql_query('' . 'select pub_money, admin_tranfer_aff_date, uid from users where ref_code=\'' . $ref_val . '\' ');
			while ($row = mysql_fetch_assoc($res)) {
				$affiliate[advertiser] += ($this->getAffiliateFromAdv($row[uid]));
				$affiliate[publisher] += ($this->getAffiliateFromPub($row[uid],$row['admin_tranfer_aff_date']))*(1/10);
				//$affiliate[publisher] += ($row[pub_money])*(1/10);
				//$affiliate[publisher] += ($this->getAffiliateFromPub($row[uid]), $row[admin_tranfer_aff_date]));
			}
		
		}
		$affiliate[total] = ($affiliate[advertiser]+$affiliate[publisher]);
		if($type=='arr') return $affiliate;
		else return $affiliate[$type];
		//return $affiliate;
	}
	
    function get_user($ref_val) {
        $res = $this->getAll("title='$ref_val'");
        $one = $res[0];
        return $one['user_id'];
    }
	
    function gen_chars($length = 6) {
        $chars = '0123456789abcdefghjkmnoprstvwxyz';
        $Code = '';
        for ($i = 0; $i < $length; ++$i) $Code .= substr($chars, (((int) mt_rand(0,strlen($chars))) - 1),1);
        return $Code;
    }
}
?>