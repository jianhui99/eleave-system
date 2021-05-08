<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


// Include autoload.php file
require 'vendor/autoload.php';

//using unique id fetch applyleave details
$sql = "SELECT * FROM applyleave WHERE uid = '$unique_id'";
$query = $con->query($sql);
$rs = $query->fetch_array();

//using student_id fetch student leave balance
$sqls = "SELECT * FROM student WHERE student_id = '$rs[student_id]'";
$querys = $con->query($sqls);
$rss = $querys->fetch_array();

$leave_type = $rs['leave_type'];
$available_leave_times = $rss["available_leave_times"];
$leave_id = $rs["leave_id"];
$name = $rs["student_name"];
$start = substr("$rs[date_start]",0,-9);
$end = substr("$rs[date_end]",0,-9);
$total = $rs["total_days"];
$reason = $rs["leave_reason"];
$reference = $rs['document'];

$email = "jianhui9998@gmail.com";

if(isset($_SESSION['update'])){
    unset($_SESSION['update']);
    $content = "<html><body>";
    $content .= "<h3>Hi, the updated leave application request has arrived.</h3>";
    $content .= "<table rules='all' style='border: 1px solid black; cellpadding='10'>";
    $content .= "<tr style='background: #eee;'><td><strong>Leave ID:</strong> </td><td>" . $leave_id . "</td></tr>";
    $content .= "<tr><td><strong>Student Name:</strong> </td><td>" . $name . "</td></tr>";
    $content .= "<tr><td><strong>Leave Type:</strong> </td><td>" . $leave_type . "</td></tr>";
    $content .= "<tr><td><strong>Start Date:</strong> </td><td>" . $start . "</td></tr>";
    $content .= "<tr><td><strong>End Date:</strong> </td><td>" . $end . "</td></tr>";
    $content .= "<tr><td><strong>Total Days:</strong> </td><td>" . $total . "</td></tr>";
    $content .= "<tr><td><strong>Reason:</strong> </td><td>" . $reason . "</td></tr>";
    $content .= "<tr style='background: #eee;'><td><strong>Available Leave Balance:</strong> </td><td>" . $available_leave_times . "</td></tr>";
    $content .= "</table>";
    $content .= "<h4>Please click on the link below to login: </h4>";
    $content .= "<a href='http://localhost/E-leaveSystem/modules/admin/index.php'>Login as admin</a>";
    $content .= "</body></html>";
}else{
    $content = "<html><body>";
    $content .= "<h3>Hi, a new leave application request has arrived.</h3>";
    $content .= "<table rules='all' style='border: 1px solid black; cellpadding='10'>";
    $content .= "<tr style='background: #eee;'><td><strong>Leave ID:</strong> </td><td>" . $leave_id . "</td></tr>";
    $content .= "<tr><td><strong>Student Name:</strong> </td><td>" . $name . "</td></tr>";
    $content .= "<tr><td><strong>Leave Type:</strong> </td><td>" . $leave_type . "</td></tr>";
    $content .= "<tr><td><strong>Start Date:</strong> </td><td>" . $start . "</td></tr>";
    $content .= "<tr><td><strong>End Date:</strong> </td><td>" . $end . "</td></tr>";
    $content .= "<tr><td><strong>Total Days:</strong> </td><td>" . $total . "</td></tr>";
    $content .= "<tr><td><strong>Reason:</strong> </td><td>" . $reason . "</td></tr>";
    $content .= "<tr style='background: #eee;'><td><strong>Available Leave Balance:</strong> </td><td>" . $available_leave_times . "</td></tr>";
    $content .= "</table>";
    $content .= "<h4>Please click on the link below to login: </h4>";
    $content .= "<a href='http://localhost/E-leaveSystem/modules/admin/index.php'>Login as admin</a>";
    $content .= "</body></html>";
}
    
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
        $mail->setFrom($email, "Student Leave Application");
        // Recipient Email ID where you want to receive emails
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = '[Vocational Programme] Leave Application Request';
        $mail->Body = $content;
        if($reference != ''){
            $mail->addAttachment("../../reference/$reference");
        }
        $mail->send();

    } catch (Exception $e) {
        $e->getMessage();
    }
?>
