<?php
	$host_name = 'localhost';
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'buylink';
	
	$con = mysql_pconnect($host_name, $db_user, $db_pass);
	
	if (!$con) {
	   die('Could not connect: ' . mysql_error());
	}

	$db_selected = mysql_select_db($db_name, $con);

	if (!$db_selected) {
	   die ('Can not use database : ' . mysql_error());
	}

	define("DB_SERVER", $host_name);
	define("DB_USERNAME", $db_user);
	define("DB_PASSWORD", $db_pass);
	define("DB_DATABASE", $db_name);
	define("RECORD_PER_PAGE", 10);
    
	class dbBasic{
    function dbBasic(){
        if(!$cnn = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD))
            die("Error: Not connect to database!");
        if(!$sldb = mysql_select_db(DB_DATABASE,$cnn))
            die("Error: Not open table ".DB_DATABASE."!");
    }
    function getOne($id){
        if($sql = mysql_query("SELECT * FROM ".$this->tbl." where ".$this->pkey."='".$id."'")) {
            $_cn= mysql_fetch_assoc($sql);
            return $_cn;
        }
    }
    function getCount($cons){
        if($cons!='') $cons = " where ".$cons;
        if($sql = mysql_query("SELECT count(".$this->pkey.") as intCount FROM ".$this->tbl.$cons)) {
            $_cn= mysql_fetch_assoc($sql);
            return $_cn['intCount'];
        }
    }
    function getSum($field, $cons){
        if($cons!='') $cons = " where ".$cons;
        if($sql = mysql_query("SELECT sum(".$field.") as intSum FROM ".$this->tbl." ".$cons)) {
            $_cn= mysql_fetch_assoc($sql);
            return $_cn['intSum'];
        }
    }
    function getMax($field,$cons){
        if($cons!='') $cons = " where ".$cons;
        if($sql = mysql_query("SELECT max(".$field.") as intMax FROM ".$this->tbl.$cons)) {
            $_cn= mysql_fetch_assoc($sql);
            return $_cn['intMax'];
        }
    }
    function getAll($cons){
        if($cons!='') $cons = " where ".$cons;
        if($sql = mysql_query("SELECT * FROM ".$this->tbl.$cons)) {
            $arr="";
            while($_cn= mysql_fetch_assoc($sql)){
                $arr[] = $_cn;
            }
            return $arr;
        }
    }
    function getListPage($cons){
        if($cons=='') $cons="1=1";
        $page = isset($_GET["page"])? $_GET["page"] : 1;
        return $this->getAll($cons.' limit '.($page-1)*RECORD_PER_PAGE.','.RECORD_PER_PAGE);
    }
    function getNavPage($cons){
        if($cons=='') $cons="1=1";
        $page = isset($_GET["page"])? $_GET["page"] : 1;
        $totalRecord = $this->getCount($cons);
        $totalPage = ceil($totalRecord / RECORD_PER_PAGE);
        $paging='';
        if($page>1) $paging[]=array(0 => 1, 1 => "First");
        if($page>1) $paging[]=array(0 => $page-1, 1 => "Prev");
        if(($page-100)>0) $paging[]=array(0 => $page-100, 1 => $page-100);
        if(($page-50)>0) $paging[]=array(0 => $page-50, 1 => $page-50);
        if(($page-10)>0) $paging[]=array(0 => $page-10, 1 => $page-10);
        for($i=$page-5; $i<$page+5; $i++) if($i>0 && $i<=$totalPage) $paging[]=array(0 => $i, 1 => $i);
        if(($page+10)<=$totalPage) $paging[]=array(0 => $page+10, 1 => $page+10);
        if(($page+50)<=$totalPage) $paging[]=array(0 => $page+50, 1 => $page+50);
        if(($page+100)<=$totalPage) $paging[]=array(0 => $page+100, 1 => $page+100);
        if($page<$totalPage) $paging[]=array(0 => $page+1, 1 => "Next");
        if($page<$totalPage) $paging[]=array(0 => $totalPage, 1 => "Last");
        return $paging;
    }
    function updateOne($id, $value){
        $sql= "UPDATE ".$this->tbl." SET ".$value." WHERE ".$this->pkey." = '".$id."'";
        if(mysql_query($sql)) return true;
        else return $sql;
    }
    function updateAll($value, $cons){
        if($cons!='') $cons = " where ".$cons;
        $sql= "UPDATE ".$this->tbl." SET ".$value." ".$cons;
        if(mysql_query($sql)) return true;
        else return $sql;
    }
    function insertOne($field, $value){
        $sql= "INSERT INTO ".$this->tbl." (".$field.") VALUES(".$value.")";
        if(mysql_query($sql)) return true;
        else return $sql;
    }
    function deleteOne($id){
        $sql="DELETE FROM ".$this->tbl." where (".$this->pkey."='".$id."')";
        if(mysql_query($sql)) return true;
        else return $sql;
    }
    function toSlug($doc) {
		$str = addslashes(html_entity_decode($doc));
		$str = preg_replace("/(�|�|?|?|�|�|?|?|?|?|?|a|?|?|?|?|?)/", 'a', $str);
		$str = preg_replace("/(�|�|?|?|?|�|?|?|?|?|?)/", 'e', $str);
		$str = preg_replace("/(�|�|?|?|i)/", 'i', $str);
		$str = preg_replace("/(�|�|?|?|�|�|?|?|?|?|?|o|?|?|?|?|?)/", 'o', $str);
		$str = preg_replace("/(�|�|?|?|u|u|?|?|?|?|?)/", 'u', $str);
		$str = preg_replace("/(?|�|?|?|?)/", 'y', $str);
		$str = preg_replace("/(d)/", 'd', $str);
		$str = preg_replace("/(�|�|?|?|�|�|?|?|?|?|?|A|?|?|?|?|?)/", 'A', $str);
		$str = preg_replace("/(�|�|?|?|?|�|?|?|?|?|?)/", 'E', $str);
		$str = preg_replace("/(�|�|?|?|I)/", 'I', $str);
		$str = preg_replace("/(�|�|?|?|�|�|?|?|?|?|?|O|?|?|?|?|?)/", 'O', $str);
		$str = preg_replace("/(�|�|?|?|U|U|?|?|?|?|?)/", 'U', $str);
		$str = preg_replace("/(?|�|?|?|?)/", 'Y', $str);
		$str = preg_replace("/(�)/", 'D', $str);
		$str = preg_replace("/( )/", '-', $str);
		$str = stripslashes($str);
        $str=strtolower($str);
		return $str;
	}
}
$dbBasic = new dbBasic();
?>