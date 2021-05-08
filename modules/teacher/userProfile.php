    <?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['teacher_id'])){
    header('location:index');
    exit();
}

//update teacher profile
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $image = $_FILES['image']['name'];
    $target = "../../images/".basename($image);
    $teacher_id = $_SESSION['teacher_id'];

    if(!empty($name) && !empty($username) && !empty($email) && !empty($contact)){
        $sql = "UPDATE teacher SET teacher_name='$name', username='$username', email='$email', phone='$contact' WHERE teacher_id='$teacher_id'";
        if($query = $con->query($sql)){
            if(!empty($image)){
                $sql = "UPDATE teacher SET image='images/$image' WHERE teacher_id='$teacher_id'";
                $query = $con->query($sql);
            }
            if(mysqli_affected_rows($con) > 0 ){
                $_SESSION['message'] = 'Teacher profile has been updated success.';
                $_SESSION['msg_type'] = 'success';
            }else{
                $_SESSION['message'] = 'No records updated.';
                $_SESSION['msg_type'] = 'info';
            }
        }
        if($image != ""){
            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
        }
    }
}

//fetch teacher data
if(isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];
    $sql = "SELECT * FROM teacher WHERE teacher_id = '$teacher_id'";
    $query = $con->query($sql);
    $result = $query->fetch_array();
    // $con->close();
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
                <h2 class="page-header">Teacher Profile Setting</h2>
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
                                            <th>Teacher ID</th>
                                            <td><input type="text" class="form-control" value="<?php echo $result['teacher_id'];?>" disabled></td>
                                        </tr>
                                        <tr>
                                            <th>Teacher Name</th>
                                            <td><input type="text" name="name" id="name" class="form-control" pattern="[A-Za-z ]{3,}" value="<?php echo $result['teacher_name'];?>" placeholder="ZhenMeiLi"></td>
                                        </tr>
                                        <tr>
                                            <th>Login Username</th>
                                            <td><input type="text" name="username" id="username" class="form-control" value="<?php echo $result['username'];?>" placeholder="ZhenMeiLi123"></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $result['email'];?>" placeholder="yourEmail@gmail.com"></td>
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
                                            <th>Education Level</th>
                                            <td><input type="text" class="form-control" value="<?php echo $result['education']?>" readOnly></td>
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
