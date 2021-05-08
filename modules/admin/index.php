<?php

require_once '../../database/db_connection.php';

session_start();

//show error.
$errors = array();

//check if user already logined.
if(isset($_SESSION['admin_id'])){
	header('location:dashboard');
	exit();
}

if(isset($_POST['btnLogin'])){
	$username = mysqli_real_escape_string($con, $_POST['user_name']);
	$password = md5($_POST['user_password']);

	if(empty($username) == true || empty($password) == true){
		$errors[] = "Invalid login, please try again";
	}else{
		$sql = "SELECT * FROM admin WHERE username ='$username'";
		$query = $con->query($sql);

		//check user exist or not.
		if($query->num_rows > 0){
			//if exist, check username and password
			 $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
			 $query = $con->query($sql);
			 $result = $query->fetch_array();
			 if($query->num_rows == 1){
			 	$_SESSION['logged_id'] == true;
				$_SESSION['admin_id'] = $result['admin_id'];
				
				//update login time
				$sql = "UPDATE admin SET login_at = Now() WHERE admin_id='$_SESSION[admin_id]'";
				$query = $con->query($sql);

				//  set profile picture to empty
				if(empty($result['image'])){
					$default_picture = "images/empty.png";
					$id = $result['admin_id'];
					$sql = "UPDATE admin SET image='$default_picture' WHERE admin_id='$id'";
					$query = $con->query($sql);
				}

			 	header('location:dashboard');
				exit();

			}else{
				 $errors[] = "Kindly check your password.";
				//  $errors[] = $password;
			}
		}else{
			$errors[] = "Username doesn't exists.";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>School E-leave Management System | Admin Login</title>
  	<!-- Custom style-->
	<link rel="shortcut icon" type="image/png" href="../../images/logo.png">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<!-- Bootstrap Core CSS -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                            <h3 class="panel-title">Login as Admin</h3>
						</div>
						
                        <div class="panel-body">
                            <form method="post" role="form">
                                <fieldset>
									<form action="" method="POST">
										<table>
											<tr>
												<th><label for="username">Username</label></th>
												<td>
													<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter username" autofocus>
												</td>
											</tr>
											<tr>
												<th><label for="password">Password</label></th>
												<td>
													<input type="password" name="user_password" id="user_password" class="form-control" placeholder="Enter password">
													<img class="hidePassword" src="images/eye-close.png">
													<img class="showPassword" src="images/eye-open.png">
												</td>
											</tr>
											<tr>
												<th></th>
												<td>
													<button type="submit" name="btnLogin" id="btnLogin" class="btn btn-info">Login</button>
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
	<a href="../student" style="text-decoration:none">Student Login |</a>
	<a href="../teacher" style="text-decoration:none">Teacher Login |</a>
	<a href="forget_password.php" style="text-decoration:none">Forgot Password?</a>
</div>
<br>
<div class="copyright">
	<p>Copyright &copy; 2020 School E-Leave Management System <br> All rights reserved</p>
</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	$(document).ready(function(){
		$(".hidePassword").on('click', function(){
			$(this).hide();
			$(".showPassword").show();
			var passwordTxt = $("#user_password");
			var passwordType = passwordTxt.attr('type');
			if(passwordType == 'password'){
				passwordTxt.attr('type', 'text');
			}
		});
		$(".showPassword").on('click', function(){
			$(this).hide();
			$(".hidePassword").show();
			var passwordTxt = $("#user_password");
			var passwordType = passwordTxt.attr('type');
			if(passwordType == 'text'){
				passwordTxt.attr('type', 'password');
			}
		});
	});

</script>	

	
