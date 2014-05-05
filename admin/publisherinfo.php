<?php
date_default_timezone_set('Asia/Bangkok');
$admin_page = 'Y';
include ("../include/config.php");    
include ("global.php");
date_default_timezone_set('Asia/Bangkok');
###
    require('../classes/class_advertisersinfo.php'); $cls_advertisersinfo = new Advertisersinfo(); $smarty->assign('cls_advertisersinfo', $cls_advertisersinfo);
    require('../classes/class_user.php'); $cls_user = new User(); $smarty->assign('cls_user', $cls_user);
	require('../classes/class_publishersinfo.php'); $cls_Publishersinfo = new Publishersinfo();
	$smarty->assign('cls_Publishersinfo', $cls_Publishersinfo);	
	
    $cons = '1=1 ';
	 if($_GET['keyword']) {
        $cons .= " and uid in (SELECT uid FROM users WHERE username like '%".$_GET['keyword']."%') ";
        $smarty->assign('keyword', $_GET['keyword']);
    }
    
    if($_GET['url']) {
        $cons .= " and  url like '%".$_GET['url']."%' "; 
        $smarty->assign('url', $_GET['url']);
    }

    if($_GET['status']!='') {
        $cons .= " and status='".$_GET['status']."' ";
        $smarty->assign('status', $_GET['status']);
    }
   	if($_GET['is_manual']!='') {
        $cons .= " and is_manual='".$_GET['is_manual']."' ";
        $smarty->assign('is_manual', $_GET['is_manual']);
    }
	 $cons .= " ORDER BY update_date DESC ";
	 	
    $all_advertisersinfo = $cls_Publishersinfo->getListPage($cons);

    $smarty->assign('all_publishersinfo', $all_advertisersinfo);
    $paging = $cls_Publishersinfo->getNavPage($cons);
    $smarty->assign('paging', $paging);
    $cursorPage = isset($_GET["page"])? $_GET["page"] : 1;
    $smarty->assign('cursorPage', $cursorPage);
    
	//@ case for edit action
	$edit_action = isset($_GET[edit])?intval($_GET[edit]):0;
	
	if($edit_action>0){
		$arr = array();
		$pub_info[year] =0;
		$pub_info = $cls_Publishersinfo->getOne($edit_action);
	        
            
			$difference = time() - $pub_info[domain_age];
            
			$periods = array('years' => 31536000, 'months' => 2592000);
			$pub_info[year] = round($difference / 31536000);
            
			
			$difference %= 31536000;    
			$pub_info[month] = round($difference / 2592000);
			
			$smarty->assign('pub_info', $pub_info);            
			//@ update action
			$websitename= isset($_POST[websitename])?addslashes($_POST[websitename]):0;
			$arr[description] = isset($_POST[description])?addslashes($_POST[description]):0;
			
			$year = isset($_POST[year])?intval($_POST[year]):'';
			$month = isset($_POST[month])?intval($_POST[month]):'';
            		
			$arr[alexa_rank] = isset($_POST[alexa_rank])?addslashes($_POST[alexa_rank]):''; 			
			if($year>0 && $month >0){
				if($month>=6) $year = intval($year -1);
				$month = $year*12 + $month;
			}else if($year==0)
            $month = $month;

            $date_time  = date('Y-m-d');
			$date_time =  date('Y-m-d', strtotime('-'.$month.' month'));
            
            $arr[domain_age]= strtotime($date_time);       
        	        $time_ago =  gettimeAgo($arr[domain_age]);
                    echo  $time_ago."";
			$arr[google_page_rank] = isset($_POST[google_page_rank])?intval($_POST[google_page_rank]):'';			

			if($arr && $_POST[websitename]){
				$value ="websitename='".$websitename."'";
				foreach($arr as $key=>$val){
					if($key && $val)
						$value .= ",".$key."='".$val."'";
						else continue;
					}
					
					$cls_Publishersinfo->updateOne($edit_action, $value); 					
					//header("location: ".$_config['www']."/admin/publisherinfo.php?edit=".$edit_action.""); 
				    
			}
	}
    
$smarty->assign('msg', $msg);
$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$protocol.='://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$smarty->assign('protocol', $protocol);

$content = $smarty->fetch('publisherinfo.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');

function gettimeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s'){
        $difference = time() - $timestamp;
       
        if($difference < 0) return ''; // if difference is lower than zero check server offset
        elseif($difference > 1592000){ // if difference is over 10 days show normal time form
       
                $periods = array('years' => 31536000, 'months' => 2592000);
                $output = '';
                foreach($periods as $key => $value){
               
                        if($difference >= $value){                      
                                $time = round($difference / $value);
                                $difference %= $value;                              
                                $output .= ($output ? ' ' : '').$time.' ';
                                $output .= (($time > 1 && $key == 'ngày') ? $key.'s' : $key);                               
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return ($output ? $output : '');
        }
        else return " 1 month";
}
?>