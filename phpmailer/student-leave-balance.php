<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


// Include autoload.php file
require 'vendor/autoload.php';

$sqls = "SELECT * FROM student WHERE student_id = '$result[student_id]'";
$querys = $con->query($sqls);
$rss = $querys->fetch_array();

$email = "jianhui9998@gmail.com";

$student = $rss["student_name"];

$content = "Hi, this is a student's balance request."."<br>".
    "Student Name: $student"."<br>".
    "Please click on the link below to login:"."<br>".
    "<a href='http://localhost/E-leaveSystem/modules/admin/index.php'>Login as admin</a>";

    
    // Create object of PHPMailer class
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;           // 0=no output, 1=Commands, 2=Data & Commands, 3=2+connection status 4=Low-Level data output
        $mail->isSMTP();                // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;         // Enable SMTP authentication
        $mail->Username = 'jianhui5939@gmail.com';  // Gmail
        $mail->Password = 'jian123hui';             // Gmail Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;              // TCP port to connect to

        // Email ID from which you want to send the email
        $mail->setFrom("jianhui5939@gmail.com", "Department  Office(Academic Unit)");
        // Recipient Email ID where you want to receive emails
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = '[Student] Leave Balance Request';
        $mail->Body = $content;
        $mail->send();
        // $mail->ClearAllRecipients();
        // $mail->ClearAttachments();

    } catch (Exception $e) {
        $e->getMessage();
    }
?>
