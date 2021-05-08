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
    $desc = $_POST['description'];
    $status = $_POST['select'];

    if(isset($_GET['editid'])){
        $sql = "UPDATE course SET course_name='$name', course_desc='$desc',status='$status' WHERE course_id='$_GET[editid]'";
        $query = $con->query($sql);
        if(mysqli_affected_rows($con) > 0){
            $_SESSION['message'] = "Course record updated successfully.";
            $_SESSION['msg_type'] = "success";
        }else{
            $_SESSION['message'] = "No records updated.";
            $_SESSION['msg_type'] = "info";
        } 
        
    }else{
        $sql = "INSERT INTO course(course_name,course_desc,status)VALUES('$name','$desc','$status')";
        if($query = $con->query($sql)){
            $_SESSION['message'] = "New Course has been added successfully.";
            $_SESSION['msg_type'] = "success";
            $con->close();
        }else{
            echo mysqli_error($con);
        } 
    }
}
// show data when user edit
if(isset($_GET['editid'])){
    $_SESSION['title'] = "Edit Course";
    $sql="SELECT * FROM course WHERE course_id='$_GET[editid]' ";
	$query = $con->query($sql);
    $rows = mysqli_fetch_array($query);

    $name = $rows['course_name'];
    $description = $rows['course_desc'];
    $status = $rows['status'];
}else{
    $_SESSION['title'] = "Add New Course";
    $name = '';
    $description = '';
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
                            <h2 class="page-header">Courses Setting</h2>
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
                    <!-- add course form -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><?php echo $_SESSION['title']; ?></h3>
                                    <br>
                                    <form method="post">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Course Name</th>
                                                            <td><input type="text" class="form-control" name = "name" id="name" value="<?php echo $name?>" placeholder="Enter Course name" autofocus required></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Description</th>
                                                            <td><textarea class="form-control textarea" rows="4" cols="65" name="description" id="description" placeholder="Enter description here" required ><?php echo $description ?></textarea></td>
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
                    <!-- add course form -->
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
