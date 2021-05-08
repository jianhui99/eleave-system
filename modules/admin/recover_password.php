<?php 

require_once '../../database/db_connection.php';

session_start();

//show error.
$errors = array();

function redirect(){
    header('location: index');
}
if(empty($_GET['token']) || empty($_GET['email'])){
    redirect();
}

if(isset($_POST['submit'])){
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    if(isset($_GET['email']) && isset($_GET['token'])){
        $email = $con->real_escape_string($_GET['email']);
        $token = $con->real_escape_string($_GET['token']);
    
        $sql = "SELECT * FROM admin WHERE email = '$email' AND token='$token'";
        $query = $con->query($sql);
        if($query->num_rows > 0){
            if(empty($password) == true || empty($cpassword) == true){
                $errors[]  = "Kindly enter the password field.";
            }else{
                if($password == $cpassword){
                    $sql = "UPDATE admin SET password='$password' WHERE email='$email' AND token='$token'";
                    if($query = $con->query($sql)){
                        echo "<script>alert('Your password was successfully changed.');window.location.href='index';</script>";
                    }else{
                        $errors[]  = "$con->error";
                    }
                }else{
                    $errors[]  = "Kindly check your confirm password.";
                }
            }
        }else{
            redirect();
        }
    }else{
        redirect();
    }
    
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>School E-leave Management System | Recover Password</title>
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
							<?php foreach ($errors as $key => $value) {
								echo $value;
							} ?>
						</div>
					<?php } ?>
				</div>
				
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Reset your password</h3>
						</div>
						
                        <div class="panel-body">
                            <form method="post" role="form">
                                <fieldset>
									<form action="" method="POST">
										<table>
                                            <tr>
                                                <td><label for="username">New Password</label></td>
                                            </tr>
											<tr>
												<td>
													<input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
												</td>
											</tr>
                                            <tr>
                                                <td><label for="password">Confirm Password</label></td>
                                            </tr>
											<tr>
												
												<td>
													<input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Enter confirm password" required>
												</td>
											</tr>
											<tr>
												<td>
													<button type="submit" name="submit" class="btn btn-info">Reset password</button>
												</td>
											</tr>
										</table>
									</form>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
		</div>
<div class="copyright">
	<p>Copyright &copy; 2020 School E-Leave Management System <br> All rights reserved</p>
</div>

</body>
</html>



