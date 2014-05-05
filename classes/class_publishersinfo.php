<?php 
class Publishersinfo extends dbBasic{
	function Publishersinfo(){
		$this->pkey = "pid";
		$this->tbl = "publishersinfo";
	}
    function getUserRate($pid) {
        $one = $this->getOne($pid);
        return $one['pay_rate'];
    }
    function getAdminRate($pid) {
        $one = $this->getOne($pid);
        return $one['set_price'];
    }
    function getStatus($pid) {
        $one = $this->getOne($pid);
        return $one['status'];
    }
		
	 function getPublisherInfo($pid, $return='') {
        $one = $this->getOne($pid);
		if($return) return $one[$return];  
        else return $one;
    }
	
    function set_link_confirm($pid) {
        $one = $this->getOne($pid);
        $res = md5('TEXT-LINK'.$pid.$one['set_price']);
        $value = "link_confirm='".$res."'";
        if($this->updateOne($pid, $value)) return true;
        else return false;
    }
    function get_link_confirm($pid) {
        $one = $this->getOne($pid);
        return 'http://textlink.vn/admin/pay_rates.php?rates&act=confirm&u='.$one['link_confirm'];
    }
    function is_confirm($key) {
        $all = $this->getAll("link_confirm='".$key."'");
        $one = $all[0];
        if($one['pid']!='') {
            $value = 'status=2';
            if($this->updateOne($one['pid'], $value)) return true;
        }
        return false;
    }
    function getListCat($pid) {
        $one = $this->getOne($pid);
        $arr = explode(',', $one['catIds']);
        $res = '';
        for($i=0; $i<sizeof($arr); $i++) {
            if((int)$arr[$i]>0) {
                $res[] = $arr[$i];
            }
        }
        return $res;
    }
    function is_homepage($pid) {
        $one = $this->getOne($pid);
        return ($one['is_homepage']==1);
    }
    function getPrice($pid) {
        $one = $this->getOne($pid);
        return my_money_format('%i',$one['sale_price']);
    }
	 function getPublisherUrl($pid) {
        $one = $this->getOne($pid);
        return $one['url'];
    }
    function getTotalPrice() {
        $res = $this->getSum('publishersinfo.sale_price', " publishersinfo.pid in(select pid from advertisersinfo where advertisersinfo.is_paid='N' AND advertisersinfo.uid='$_SESSION[uid]') ");
        return $res;
    }
    
    function timeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s'){
        $difference = time() - $timestamp;
       
        if($difference < 0) return ''; // if difference is lower than zero check server offset
        elseif($difference > 1592000){ // if difference is over 10 days show normal time form
       
                $periods = array('years' => 31536000, 'months' => 2592000);
                $output = '';
                foreach($periods as $key => $value){
               
                        if($difference >= $value){                      
                                $time = round($difference / $value);
                                $difference %= $value;                              
                                $output .= ($output ? ' ' : '').$time.' ';
                                $output .= (($time > 1 && $key == 'ngày') ? $key.'s' : $key);                               
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return ($output ? $output : '');
        }
        else return " 1 month";
}
}
?>