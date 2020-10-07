<?php

require_once '../vendor/autoload.php';

// Namespace for PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$usernames = array(
    "nvrwdu@hotmail.com", "theoneword@live.co.uk"
);
$passwords = array(
    "12345", "67890"
);


function sendMailToGangs($email, $name, $subject = '', $body = '', $attachmentDir)
{
    /* Dispatch email with timesheet data */

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

    $mail->AddAddress("$email", "$name");

    $mail->addAttachment($attachmentDir);


    $mail->isHTML(true);

    $mail->Subject = $subject;
    //$mail->addEmbeddedImage('path/to/image_file.jpg', 'image_cid');

    // Mail template. Different if user is admin
//        if($isAdmin) {
//            $mailTemplate = "<b>Admin, a new timesheet has been submitted. Please check inbox</b>";
//        } else {
//            $mailTemplate = "<b>Thank you for submitting your timesheet. You will be notified of any status updates.";
//        }

    //<b><br><br><br><br>
//        $name<br>
//        $contract<br>
//        $jobnumber<br>
//        $estimate<br>
//        $exchange<br>
//        $email<br>

    // $mail->Body = '<b>Mail body in HTML. Message sent successfully<b>';
    $mail->Body = $body;
    $mail->AltBody = 'This is the plain text version of the email content';

    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
        echo 'Message has been sent';
    }

    $mail->smtpClose();
}






sendMailToGangs("nvrwdu@hotmail.com",
    "Mohammed Amir",
    "New Timesheet app",
    "A new web service is live for you to submit timesheets.


Website : https://apttimesheets.herokuapp.com

Username : <user> Password : <pass>



From Monday 05/10/2020, please use the service to submit all timesheets.

If you have any problems, please refer to the user guide, or email amir@aptgs.co.uk.


Kind regards",
"./APTTimesheetsUserGuide.docx");


?>