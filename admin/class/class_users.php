<?php 
class Users extends dbBasic{
	function Users(){
		$this->pkey = "uid";
		$this->tbl = "users";
	}
}
?>