<?php 
class Admin extends dbBasic{
	function Admin(){
		$this->pkey = "uid";
		$this->tbl = "admin";
	}    
}
?>