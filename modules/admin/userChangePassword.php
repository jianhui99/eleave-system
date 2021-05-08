<?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['admin_id'])){
	header('location:index');
	exit();
}


if(isset($_POST['submit'])){
    $oldPass = md5($_POST['oldpass']);
    $newPass = md5($_POST['newpass']);
    $confirmPass = md5($_POST['confirmpass']);
    $id = $_SESSION['admin_id'];

    $sql = "SELECT * FROM admin WHERE admin_id ='$id'";
    $query = $con->query($sql);
    $result = $query->fetch_array();

    if($oldPass != '' && $newPass != '' && $confirmPass != ''){
        if($oldPass == $result['password']){
            if($newPass === $confirmPass){
                $sql = "UPDATE admin SET password='$newPass' WHERE admin_id='$id'";
                $query = $con->query($sql);
                if(mysqli_affected_rows($con) > 0){
                    $_SESSION['message'] = 'Password has been changed success.';
                    $_SESSION['msg_type'] = 'success';
                }else{
                    $_SESSION['message'] = 'Password change failed.';
                    $_SESSION['msg_type'] = 'danger';
                }     
            }else{
                $_SESSION['message'] = "Those passwords don't match. Try again";
                $_SESSION['msg_type'] = 'danger';
            }
        }else{
            $_SESSION['message'] = 'Kindly check your old password. Try again';
            $_SESSION['msg_type'] = 'danger';
        }
    }else{
        $_SESSION['message'] = 'No records updated.';
        $_SESSION['msg_type'] = 'info';
    }
}
//fetch admin data
if(isset($_SESSION['admin_id'])) {	
	$admin_id = $_SESSION['admin_id'];
	$sql = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
	$con->close();
}

?>
<!-- import navigation bar -->
<?php require_once "side_navigation_bar.php"; ?>
            <!-- wrapper -->
            <div id="page-wrapper">
                <!-- Content -->
                <div class="container-fluid">
                    <!-- title -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">Admin Profile Setting</h2>
                        </div>
                    </div>
                    <!-- title -->
                    <!-- bootstrap alert -->
                    <?php
                    if(isset($_SESSION['message'])):?>
                        <div class="alert alert-<?=$_SESSION['msg_type']?> " role="alert">
                            <?php
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                    <?php endif ?>
                    <!-- bootstrap alert -->
                    <!-- change password form -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>Change Password</h3>
                                    <br>
                                    <form method="post">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Old Password</th>
                                                            <td><input type="password" class="form-control" name = "oldpass" id="oldpass" placeholder="Enter old password" autofocus></td>
                                                        </tr>
                                                        <tr>
                                                            <th>New Password</th>
                                                            <td><input type="password" class="form-control" name="newpass" id="newpass" placeholder="Enter new password"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Confirm Password</th>
                                                            <td><input type="password" class="form-control" name="confirmpass" id="confirmpass"placeholder="Enter confirm password"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>    
                                                <button type="submit" name="submit" id="submit" class="btn btn-info savebtn pull-right">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- change password form -->
                </div>   
                <!-- Content -->
            </div>
            <!-- wrapper -->

        <!-- jQuery -->
        <script src="../../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../js/startmin.js"></script>

    </body>
</html>
