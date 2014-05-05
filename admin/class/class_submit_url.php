<?php 
class SubmitUrl extends dbBasic{
	function SubmitUrl(){
		$this->pkey = "submit_url_id";
		$this->tbl = "submit_url";
	}
    function get_with_pid($pid) {
        $all = $this->getAll("pid='".$pid."'");
        return $all;
    }
}
?>