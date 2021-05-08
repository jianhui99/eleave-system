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
    $contact = $_POST['contact'];
    $education = $_POST['education'];
    $status =$_POST['select'];

    if(isset($_GET['editid'])){
        $sql = "UPDATE teacher SET teacher_name='$name', username='$username', password='$password',email='$email', phone='$contact',education='$education', status='$status' WHERE teacher_id='$_GET[editid]'";
            $query = $con->query($sql);
            if(mysqli_affected_rows($con) > 0){
                $_SESSION['message'] = "Teacher record updated successfully.";
                $_SESSION['msg_type'] = "success";
            }else{
                $_SESSION['message'] = "No records updated.";
                $_SESSION['msg_type'] = "info";
            } 
    }else{
        $sql = "INSERT INTO teacher(teacher_name,username,password,email,phone,education,status)VALUES('$name','$username','$password','$email','$contact','$education','$status')";
            if($query = $con->query($sql)){
                $_SESSION['message'] = "New Teacher has been added successfully.";
                $_SESSION['msg_type'] = "success";
                $con->close();
            }else{
                echo mysqli_error($con);
            } 
    }
}
// show data when user edit
if(isset($_GET['editid'])){
    $_SESSION['title'] = "Edit Teacher";

    $sql="SELECT * FROM teacher WHERE teacher_id='$_GET[editid]' ";
	$query = $con->query($sql);
    $rows = mysqli_fetch_array($query);

    $name = $rows['teacher_name'];
    $username = $rows['username'];
    $email = $rows['email'];
    $contact = $rows['phone'];
    $status = $rows['status'];
    $education = $rows['education'];
}else{
    $_SESSION['title'] = "Add New Teacher";
    $name = '';
    $username = '';
    $email = '';
    $contact = '';
    $status = '';
    $education = '';
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
                            <h2 class="page-header">Teacher Setting</h2>
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
                    <!-- add teacher form -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><?php echo $_SESSION['title'] ?></h3>
                                    <br>
                                    <form method="post">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Teacher Name</th>
                                                            <td><input type="text" class="form-control" name = "name" id="name" value="<?php echo $name?>" placeholder="Enter teacher name" autofocus required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Login Username</th>
                                                            <td><input type="text" class="form-control" name="username" id="username" value="<?php echo $username?>" placeholder="Enter login username" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email Address</th>
                                                            <td><input type="email" class="form-control" name="email" id="email" value="<?php echo $email?>" placeholder="Enter email address" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Contact Number</th>
                                                            <td><input type="text" class="form-control" name="contact" id="contact" value="<?php echo $contact?>" placeholder="Enter contact number" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Education Level</th>
                                                            <td>
                                                                <select name="education" id="education" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <?php
                                                                        $level = array("Diploma","Degree","Master","Doctor");
                                                                        foreach($level as $val){
                                                                            if($val == $education){
                                                                                echo "<option value='$val' selected>$val</option>";
                                                                            }else{
                                                                                echo "<option value='$val'>$val</option>";
                                                                            }
                                                                        }
                                                                    
                                                                    ?>
                                                                </select>
                                                            </td>
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
                    <!-- add teacher form -->
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
