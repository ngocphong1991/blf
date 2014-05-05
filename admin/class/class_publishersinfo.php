<?php 
class Publishersinfo extends dbBasic{
	function Publishersinfo(){
		$this->pkey = "pid";
		$this->tbl = "publishersinfo";
	}
    function getChild($pid) {
        $all = $this->getAll("parentId='".$pid."'");
        return $all;
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
    function set_link_confirm($pid) {
        $one = $this->getOne($pid);
        $res = md5('TEXT-LINK'.$pid.$one['set_price']);
        $value = "link_confirm='".$res."'";
        if($this->updateOne($pid, $value)) return true;
        else return false;
    }
    function get_link_confirm($pid) {
        $one = $this->getOne($pid);
        return 'http://localhost/ad/admin/pay_rates.php?rates&act=confirm&u='.$one['link_confirm'];
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
}
?>