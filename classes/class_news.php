<?php 
class News extends dbBasic{
	function News(){
		$this->pkey = "Id";
		$this->tbl = "news";
	}
    
    function get_count_news($news_cat_id) {
        $all = $this->getAll('CategoryId='.$news_cat_id);
        if($all[0]) return count($all);
        else return 0;                
    }
    
    function get_from_cat($news_cat_id) {
        $all = $this->getAll('CategoryId='.$news_cat_id.' order by order_no');
        return $all;                
    }
    
    function get_count_item() {
        $all = $this->getAll('');
        if($all[0]) return count($all);
        else return 0;   
    }            
}
?>