<?php 
class Bank extends dbBasic{
	function Bank(){
		$this->pkey = "bank_id";
		$this->tbl = "bank";
	}
    function getName($bank_id) {
        $one = $this->getOne($bank_id);
        return $one['name'];
    }
}
?>