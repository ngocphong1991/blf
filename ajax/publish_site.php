<?php
include ("../include/config.php");
if($_SESSION[uid]<=0){
	$arr = array("result"=>"failure","output"=> "");
	echo json_encode($arr);
}

if($_POST[action]=="check_website"){
	$error ='';
    
	if(empty($_POST[wname])) $error .='<li>Vui lòng nhập tiêu đề webiste</li>';
	if(!isset($_POST[guide])) $error .='<li>Bạn chưa đồng ý điều khoản dử dụng</li>';
	if(!validateURL($_POST[url]) || !isset($_POST[url])) $error .='<li>URL không đúng định dạng</li>';
	if(validateURL($_POST[url])==1) $error .='<li>Url này đã được sử dụng</li>';	
	if(strlen($_POST[wdes])<150) $error .='<li>Mô tả quá ngắn</li>';        
	
	 if($error){	
		$arr = array('result'=>'failure',"output"=> '<ul>'.$error.'</ul>');
		echo json_encode($arr);
	}else {		
		$pid = register_new_publisher($_POST);      
		$arr = array("result"=>"success","output"=> "", "pid"=>$pid);
		echo json_encode($arr);
	}
}elseif($_POST[action]=="update_website_placement"){
	$pid = isset($_POST[id])?intval($_POST[id]):0;
	$is_manual = isset($_POST[is_manual])?$_POST[is_manual]:'N';
	if($_SESSION[uid]>0){
	$res = mysql_query('' . 'update `publishersinfo` set  `is_manual`=\'' . $is_manual . '\' where pid=\'' . $pid . '\' and uid = \'' . $_SESSION[uid] . '\'');
	$arr = array("result"=>"success","output"=> "", "pid"=>$pid);
		echo json_encode($arr);
	}
	
}
elseif($_POST[action]=="submit_website"){//case submit website
	if(update_publisher($_POST,"update_cat"))	
		$arr = array("result"=>"accepted","pid"=>$_SESSION[pid], "output"=> "");
	else
		$arr = array("result"=>"failure","output"=> '<ul><li>Read our Publisher\'s Guide</li></ul>');
	echo json_encode($arr);

}elseif($_POST[action]=="update_website"){
	if(update_publisher($_POST,"all")){
		$arr = array("result"=>"success","output"=> "This website has been updated.");
	}else
		$arr = array("result"=>"failure","output"=> "Please try again.");
	echo json_encode($arr);
}elseif($_POST[action]=="active_website"){
		if(isset($_POST[url]) && isset($_POST[script]) && isset($_POST[pid])){
			$url = $_POST[url]."/".$_POST[script].".xml";
			//$url = 'http://localhost/ad/ad_files/yfx0u3s57wm875oj.xml';
			if(checkIssetUrl($url)){
				updateStatus(2,$_POST[pid]);
				$arr = array("result"=>"success","output"=> "This website has been active.");
			}
			else 
			$arr = array("result"=>"failure","output"=> "Please try again <span color='green'>".$url."</span> not exit.");
			
		}
		else
			$arr = array("result"=>"failure","output"=> "Please try again Please try again <span color='green'>".$url."</span> not exit.");
	echo json_encode($arr);
}
?>