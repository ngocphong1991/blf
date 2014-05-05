<?php
include ("../include/config.php");
if($_POST[action]=="register"){
	$error ='';
	if(empty($_POST[username])) $error .='<li>The "Username" field was left blank.</li>';	
	if(isValid($_POST[username],'username')==1) $error .='<li>This "Username" is already in use.</li>';
	
	if(empty($_POST[text_ad_pass])) $error .='<li>The "Password" field was left blank.</li>';
	if(empty($_POST[email])) $error .='<li>The "E-mail Address" field was left blank.</li>';
	if(empty($_POST[country])) $error .='<li>The "E-mail Address" field was left blank.</li>';
	if(!isValid($_POST[email],'email')) $error .='<li>Email is not valid.</li>';
	elseif(isValid($_POST[email],'email')==1) $error .='<li>This email is already in use.</li>';
	
	if($_POST[country]=='unknown') $error .='<li>Please select your contry.</li>';
	if(empty($_POST[agree])) $error .='<li>You must agree to the terms of service.</li>';
	if($_POST[text_ad_pass2] != $_POST[text_ad_pass]) $error .='<li>Passwords do not match.</li>';
	
	
	if($error){	
		$arr = array('result'=>'failure',"output"=> '<div class="error-box small-box"><img class="error-icon" src="'.$_config["www"].'/templates/'.$_config["template"].'/images/icon-error.png" alt="" /><h3>Please correct:</h3><ul>'.$error.'</ul></div>');

	}else {		
		if(register_new_user($_POST)) {
			$arr = array("result"=>"success","output"=> "", "pid"=>$pid);
			
		} else {
			$msg = "There was a server error right this moment. Please try again later...";
			$arr = array('result'=>'failure',"output"=> '<div class="error-box small-box"><img class="error-icon" src="'.$_config["www"].'/templates/'.$_config["template"].'/images/icon-error.png" alt="" /><h3>Please correct:</h3><ul>'.$msg.'</ul></div>');
		}
	}
	echo json_encode($arr);
}
?>
