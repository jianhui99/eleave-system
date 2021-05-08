<?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['student_id'])){
	header('location:index');
	exit();
}

//update student profile
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
	$image = $_FILES['image']['name'];
    $target = "../../images/".basename($image);
    $student_id = $_SESSION['student_id'];
    
    if(!empty($name) && !empty($contact)){
        //update student name
        $sql_n = "UPDATE student SET student_name = '$name' WHERE student_id = '$student_id'";
        if($query = $con->query($sql_n)){
            if(mysqli_affected_rows($con) > 0 ){
                $sql = "UPDATE applyleave SET student_name='$name' WHERE student_id='$student_id'";
                $query = $con->query($sql);

                $_SESSION['message'] = 'Student profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
        
        //update student phone
        $sql_p = "UPDATE student SET phone = '$contact' WHERE student_id = '$student_id'";
        if($query = $con->query($sql_p)){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Student profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }

    }
    //update student username
    if(!empty($username)){
        $my_query = mysqli_query($con, "SELECT * FROM student WHERE username='$username' ");
        if(mysqli_num_rows($my_query) > 0){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'This username already has taken. Try again.';
                $_SESSION['msg_type'] = 'info';
            }
        }
        else{
            $sql_u = "UPDATE student SET username = '$username' WHERE student_id = '$student_id'";
            $result = mysqli_query($con, $sql_u); 

            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Student profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
    }
    //update student email
    if(!empty($email)){
        $my_query = mysqli_query($con, "SELECT * FROM student WHERE email='$email' ");
        if(mysqli_num_rows($my_query) > 0){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'This email already has taken. Try again.';
                $_SESSION['msg_type'] = 'info';
            }
        }
        else{
            $sql_e = "UPDATE student SET email = '$email' WHERE student_id = '$student_id'";
            $result = mysqli_query($con, $sql_e); 

            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Student profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
        }
    }
    //update student profile image
    if(!empty($image)){
        $sql_i = "UPDATE student SET image='images/$image' WHERE student_id='$student_id'";
        if($query = $con->query($sql_i)){
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Student profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }
            if($image != ""){
                move_uploaded_file($_FILES["image"]["tmp_name"], $target);
            }
        }
    }
}

//fetch student data
if(isset($_SESSION['student_id'])) {	
	$student_id = $_SESSION['student_id'];
	$sql = "SELECT * FROM student WHERE student_id = '$student_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
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
                            <h2 class="page-header">Student Profile Setting</h2>
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
                                                            <th>Student ID</th>
                                                            <td><input type="text" class="form-control" value="<?php echo $result['student_id'];?>" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <td><input type="text" name="name" id="name" class="form-control" pattern="[A-Za-z ]{3,}" value="<?php echo $result['student_name'];?>" placeholder="ZhenMeiLi"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Login Username</th>
                                                            <td><input type="text" name="username" id="username" class="form-control"  placeholder="<?php echo $result['username'];?>"></td>
                                                        </tr>
                                                        <?php
                                                            $sql = "SELECT * FROM course WHERE course_id='$result[course_id]'";
                                                            $query = $con->query($sql);
                                                            $rss = mysqli_fetch_array($query);
                                                        ?>
                                                        <tr>
                                                            <th>Course Name</th>
                                                            <td><input type="text" class="form-control" value="<?php echo $rss['course_name'];?>" readOnly></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td><input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="<?php echo $result['email'];?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Contact Number</th>
                                                            <td><input type="text" name="contact" id="contact" class="form-control" pattern="^[0][0-9]{9,10}" value="<?php echo $result['phone'];?>" placeholder="0123456789"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profile Picture</th>
                                                            <td><input type="file" name="image" id="image" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td><input type="text" class="form-control" value="<?php echo $result['status']?>" readOnly></td>
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
