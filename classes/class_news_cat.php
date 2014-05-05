<?php 
class NewsCat extends dbBasic{
	function NewsCat(){
		$this->pkey = "Id";
		$this->tbl = "news_cat";
	}
}
?>