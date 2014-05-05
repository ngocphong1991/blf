<?php 
class Category extends dbBasic{
	function Category(){
		$this->pkey = "cid";
		$this->tbl = "category";
	}
}
?>