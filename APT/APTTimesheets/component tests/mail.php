<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';

//PHPMailer Object
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions


//smtp config
$mail->isSMTP();

// GMail SMTP Settings
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'nvrwdu@gmail.com';
$mail->Password =  '((Pi3141))';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->From = "nvrwdu@hotmail.com";
$mail->FromName = "Mohammed Amir";

$mail->AddAddress('nvrwdu@hotmail.com', 'Mohammed Amir');
$mail->AddAddress('dawed48796@araniera.net', 'Maulana Steve');


$mail->isHTML(true);

$mail->Subject = "PHPMailer SMTP test";
//$mail->addEmbeddedImage('path/to/image_file.jpg', 'image_cid');
$mail->Body = '<b>Mail body in HTML. Message sent successfully<b>';
$mail->AltBody = 'This is the plain text version of the email content';

if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}else{
    echo 'Message has been sent';
}


?>