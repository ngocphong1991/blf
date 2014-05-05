<?php
include ("include/config.php");
$msg = "";

$smarty->assign('rand1',rand(1, 10));
$smarty->assign('rand2',rand(5, 15));


if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=="submit"){
    $data = $_POST['data'];
    
    $name = $data['name'];
    $email = $data['email'];
    $subject = $data['subject'];
    $body = $data['body'];
    
    $from    = $email;
    $to      = 'support@textlink.vn';
    $subject = 'Contact from TextLink: '.$subject;
    $message = '<p>Name: '.$name.'</p>
        <p>Email: '.$email.'</p>
        
        <br><br>Content: '.$body;
    $headers = 'From: '.$email. "\r\n" .
        'Reply-To: '.$to."\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    mail($to, $subject, $message, $headers);
    $smarty->assign('msg_contact', 'Liên hệ của bạn đã được gửi. Cám ơn bạn đã quan tâm đến TextLink.');
    
}
$meta[title] ='Hãy liên hệ với chúng tôi - Textlink.vn';
$meta[des] ='Nếu bạn gặp bất kỳ vấn đề gì trong quá trình sử dụng Textlink.vn, xin hãy vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hotline - Mỗi câu hỏi của các bạn là một cơ hội để chúng tôi nâng cao dịch vụ chăm sóc khách hàng!.';
$smarty->assign('meta', $meta);

$content = $smarty->fetch('contact.tpl');
$smarty->assign('content',$content);
$smarty->display('master_page.tpl');
?>