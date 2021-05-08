<?php 

require_once '../../database/db_connection.php';

session_start();

//show error.
$errors = array();

//check if user already logined.
if(isset($_SESSION['student_id'])){
	header('location:dashboard.php');
	exit();
}

if(isset($_POST['btnLogin'])){
	$username = mysqli_real_escape_string($con, $_POST['user_name']);
	$password = md5($_POST['user_password']);

	if(empty($username) == true || empty($password) == true){
		$errors[] = "Invalid login, please try again.";
		header('index.php');
	}
	else{

		$sql = "SELECT * FROM student WHERE username ='$username'";
		$query = $con->query($sql);
		if($query->num_rows > 0){
			//check username and password
			 $sql = "SELECT * FROM student WHERE username = '$username' AND password = '$password'";
			 $query = $con->query($sql);
			 $result = $query->fetch_array();

			 if($query->num_rows == 1){
			 	$_SESSION['logged_id'] == true;
			 	$_SESSION['student_id'] = $result['student_id'];
				
				//update login time
				$sql = "UPDATE student SET login_at = Now() WHERE student_id='$_SESSION[student_id]'";
				$query = $con->query($sql);
				//  set profile picture to empty
				$profile_pic = $result['image'];
				if($profile_pic == ""){
					$id = $result['student_id'];
					$image = "images/empty.png";
					$sql = "UPDATE student SET image='$image' WHERE student_id='$id'";
					$query = $con->query($sql);

					$con->close();
				}
			 	header('location:Dashboard.php');
			 	exit();
			 }
			 else{
			 	$errors[] = "Username or Password invalid.";
			 }
		}
		else{
			$errors[] = "Username dosen't exists.";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>School E-leave Management System | User Login</title>
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
                            <h3 class="panel-title">Login as Student</h3>
						</div>
						
                        <div class="panel-body">
                            <form method="post" role="form">
                                <fieldset>
									<form action="" method="POST">
										<table>
											<tr>
												<td><label for="username">Username</label></td>
												<td>
													<input type="text" name="user_name" id="user_name" class="form-control" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['username'];}?>" placeholder="Enter username" autofocus>
												</td>
											</tr>
											<tr>
												<td><label for="password">Password</label></td>
												<td>
													<input type="password" name="user_password" id="user_password" class="form-control" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];}?>" placeholder="Enter password" >
													<img class="hidePassword" src="../admin/images/eye-close.png">
													<img class="showPassword" src="../admin/images/eye-open.png">
												</td>
											</tr>
											<tr>
												<th></th>
												<td>
													<button type="submit" name="btnLogin" class="btn btn-info">Login</button>
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
	<a style="text-decoration:none" href="../teacher">Teacher Login |</a>
	<a style="text-decoration:none" href="../admin">Admin Login |</a>
	<a style="text-decoration:none" href="forget_password.php">Forgot Password?</a>
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