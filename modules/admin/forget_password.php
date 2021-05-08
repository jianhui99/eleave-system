<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

// Include autoload.php file
require '../../phpmailer/vendor/autoload.php';
$mail = new PHPMailer(true);

require_once '../../database/db_connection.php';

session_start();

//show error.
$errors = array();

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    if($email != ""){
        $sql = "SELECT email FROM admin WHERE email = '$email'";
        $query = $con->query($sql);
        if($query-> num_rows > 0){
            $token = "mynameisleongjianhuiandadminid1830061";
            $token = str_shuffle($token);
            $token = substr($token, 0, 15);

            $sql = "UPDATE admin SET token = '$token' WHERE email='$email'";
            if($query = $con->query($sql)){
                $_SESSION['success'] = "success";

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'jianhui5939@gmail.com';
                    $mail->Password = 'jian123hui';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
    
                    // Email from which you want to send the email
                    $mail->setFrom("jianhui5939@gmail.com", "Department  Office(Academic Unit)");
                    // Recipient Email where you want to receive emails
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = '[System Reset Password]';
                    $mail->Body = "
                        Hi,<br>
                        In order to reset your password, please click on the link below:<br>
                        <a href='http://localhost/E-leaveSystem/modules/admin/recover_password.php?email=$email&token=$token'>Reset your password.</a>
                    ";
                    $mail->send();

                }catch(Exception $e) {
                    echo "<script type='text/javascript'>alert(\"$mail->ErrorInfo.\");</script>";
                } 
            }else{
                $errors[]  = "$con->error";
            }
        }else{
            $errors[] = "Invalid email, Try again.";
        }
    }else{
        $errors[] = "Kindly enter your email.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>School E-leave Management System | Forget Password</title>
  	<!-- Custom style-->
	<link rel="shortcut icon" type="image/png" href="../../images/logo.png">
	  <link rel="stylesheet" type="text/css" href="../../css/style.css">
	  <!-- Bootstrap Core CSS -->
	  <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="logo">

</div>

<br>
<div class="container">
            <div class="row">
				<div class="col-md-4 col-md-offset-4">
					<?php if(!empty($errors)) {?>
						<div class="alert alert-danger">
							<li>
                            <?php foreach ($errors as $value) {
								echo $value;
							} ?>
                            </li>
						</div>
					<?php } ?>
				</div>
				<?php if(isset($_SESSION['success'])) :?>
                    
                    <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recover Password</h3>
						</div>
                        <div class="panel-body">
                            <div class="alert alert-success">
                                <p>A password recovery link has been sent to your email.
                                 Please login to your email and click on the link to reset your account password.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['success']);?>
                <?php else: ?>
                    <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recover Password</h3>
						</div>
						
                        <div class="panel-body">
                            <form method="post" role="form">
                                <fieldset>
									<form action="" method="POST">
										<table>
                                            <tr>
                                                <td>
                                                    <p>Please enter your email so we can assist you in recovering your account.</p>
                                                </td>
                                            </tr>
											<tr>
												<td>
													<input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
												</td>
											</tr>
											<tr>
												<td>
													<button type="submit" name="submit" class="btn btn-info">Recover password</button>
												</td>
											</tr>
										</table>
									</form>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
            </div>
		</div>
<div class="copyright">
	<p>Copyright &copy; 2020 School E-Leave Management System <br> All rights reserved</p>
</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


