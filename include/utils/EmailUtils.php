<?php
/*
 * Sent mail function
 */
function sendMail($recipient,$subject,$body){
	include INCLUDE_DIR . "libs/mail/class.phpmailer.php";
    include INCLUDE_DIR . "libs/mail/class.smtp.php";

    $mail = new PHPMailer();
    $mail->IsSMTP(); // set mailer to use SMTP
    $mail->Host = "localhost"; // specify main and backup server
    $mail->Port = 25; // set the port to use
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->SMTPSecure = 'ssl';
    $mail->Username = "admin@textlink.vn"; // your SMTP username or your gmail username
    $mail->Password = "textlink2012"; // your SMTP password or your gmail password
    $from = "no-reply@maxcom.vn"; // Reply to this email
    $name=""; // Recipient's name
    $mail->From = $from;
    $mail->FromName = "Your From Name"; // Name to indicate where the email came from when the recepient received
    $mail->AddAddress($recipient,$name);
    $mail->AddReplyTo($from,"Vo Duy Tuan");
    $mail->WordWrap = 50; // set word wrap
    $mail->IsHTML(true); // send as HTML
    $mail->Subject = $subject;
    $mail->Body = $body; //HTML Body
    $mail->AltBody = ""; //Text Body
    //$mail->SMTPDebug = 2;
    if(!$mail->Send()) {
        echo "<h1>Loi khi goi mail: " . $mail->ErrorInfo . '</h1>';
    }
}