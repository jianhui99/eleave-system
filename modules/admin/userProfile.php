<?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['admin_id'])){
	header('location:index');
	exit();
}
//update admin profile
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];
    $target = "../../images/".basename($image);
    $status = $_POST['select'];
    $admin_id = $_SESSION['admin_id'];

    if(!empty($name) && !empty($status)){
        //update admin name
        $sql_n = "UPDATE admin SET admin_name = '$name' WHERE admin_id = '$admin_id'";
        if($query = $con->query($sql_n)){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Admin profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
        //update admin status
        $sql_s = "UPDATE admin SET status = '$status' WHERE admin_id = '$admin_id'";
        if($query = $con->query($sql_s)){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Admin profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
    }
    //update admin username
    if(!empty($username)){
        $my_query = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' ");
        if(mysqli_num_rows($my_query) > 0){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'This username already has taken. Try again.';
                $_SESSION['msg_type'] = 'info';
            }
        }
        else{
            $sql_u = "UPDATE admin SET username = '$username' WHERE admin_id = '$admin_id'";
            $result = mysqli_query($con, $sql_u); 

            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Admin profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
    }
    //update admin email
    if(!empty($email)){
        $my_query = mysqli_query($con, "SELECT * FROM admin WHERE email='$email' ");
        if(mysqli_num_rows($my_query) > 0){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'This email already has taken. Try again.';
                $_SESSION['msg_type'] = 'info';
            }
        }
        else{
            $sql_e = "UPDATE admin SET email = '$email' WHERE admin_id = '$admin_id'";
            $result = mysqli_query($con, $sql_e); 

            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Admin profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
    }
    //update admin profile image
    if(!empty($image)){
        $sql_i = "UPDATE admin SET image='images/$image' WHERE admin_id='$admin_id'";
        if($query = $con->query($sql_i)){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Admin profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
            if($image != ""){
                move_uploaded_file($_FILES["image"]["tmp_name"], $target);
            }
        }
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
                    <!-- profile form -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>View and Update your profile</h3>
                                    <br>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Admin ID</th>
                                                            <td><input type="text" class="form-control" value="<?php echo $result['admin_id'];?>" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Admin Name</th>
                                                            <td><input type="text" name="name" id="name" class="form-control" pattern="[A-Za-z ]{5,}" value="<?php echo $result['admin_name'];?>" placeholder="ZhenMeiLi"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Login Username</th>
                                                            <td><input type="text" name="username" id="username" class="form-control" placeholder="<?php echo $result['username'];?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td><input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="<?php echo $result['email'];?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profile Picture</th>
                                                            <td><input type="file" name="image" id="image" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td>
                                                            <select name="select" id="select" class="form-control">
                                                                <option value="">Select</option>
                                                                <?php
                                                                $arr = array("Active", "Inactive");
                                                                foreach($arr as $val){
                                                                    if($val == $result['status']){
                                                                        echo "<option value='$val' selected>$val</option>";
                                                                    }else{
                                                                        echo "<option value='$val'>$val</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            </td>
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
                    <!-- profile form -->
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
