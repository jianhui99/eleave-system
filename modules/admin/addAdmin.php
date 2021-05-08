<?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['admin_id'])){
	header('location:index');
	exit();
}

//fetch admin data
if(isset($_SESSION['admin_id'])) {	
	$admin_id = $_SESSION['admin_id'];
	$sql = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($username);
    $email = $_POST['email'];
    $status =$_POST['select'];

    if(isset($_GET['editid'])){
        $sql = "UPDATE admin SET admin_name='$name', username='$username', password='$password', email='$email', status='$status' WHERE admin_id='$_GET[editid]'";
        $query = $con->query($sql);
            if(mysqli_affected_rows($con) > 0){
                $_SESSION['message'] = "Admin record updated successfully.";
                $_SESSION['msg_type'] = "success";
            }else{
                $_SESSION['message'] = "No records updated.";
                $_SESSION['msg_type'] = "info";
            } 
    }else{
        $sql = "INSERT INTO admin(admin_name,username,password,email,status)VALUES('$name','$username','$password','$email','$status')";
            if($query = $con->query($sql)){
                $_SESSION['message'] = "New Admin has been added successfully.";
                $_SESSION['msg_type'] = "success";
                $con->close();
            }else{
                echo mysqli_error($con);
            } 
    }
}
// show data when user edit
if(isset($_GET['editid'])){
    $_SESSION['title'] = "Edit Administrator";
    $sql="SELECT * FROM admin WHERE admin_id='$_GET[editid]' ";
	$query = $con->query($sql);
    $rows = mysqli_fetch_array($query);

    $name = $rows['admin_name'];
    $username = $rows['username'];
    $email = $rows['email'];
    $status = $rows['status'];
}else{
    $_SESSION['title'] = "Add New Administrator";
    $name = '';
    $username = '';
    $email = '';
    $status = '';
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
                            <h2 class="page-header">Admin Setting</h2>
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
                    <!-- add admin form -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>
                                        <?php
                                            echo $_SESSION['title'];
                                        ?>
                                    </h3>
                                    <br>
                                    <form method="post">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Admin Name</th>
                                                            <td><input type="text" class="form-control" name = "name" id="name" value="<?php echo $name?>" placeholder="Enter admin name" autofocus required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Login Username</th>
                                                            <td><input type="text" class="form-control" name="username" id="username" value="<?php echo $username?>" placeholder="Enter login username" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td><input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo $email?>" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td>
                                                                <select name="select" id="select" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <?php
                                                                    $arr = array("Active", "Inactive");
                                                                    foreach($arr as $val){
                                                                        if($val == $status){
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
                                                <button type="submit" name="submit" id="submit" class="btn btn-info pull-right">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- add admin form -->
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
