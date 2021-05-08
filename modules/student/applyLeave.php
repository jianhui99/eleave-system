<?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['student_id'])){
	header('location:index');
	exit();
}

//fetch student data
if(isset($_SESSION['student_id'])) {	
	$student_id = $_SESSION['student_id'];
	$sql = "SELECT * FROM student WHERE student_id = '$student_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
}

//Process of applying leave
if(isset($_POST['submit'])){
    $leave_type = $_POST['leave_type'];
    $reason = mysqli_real_escape_string($con, $_POST['reason']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reference = $_FILES['document']['name'];
    $target = "../../reference/".basename($reference);
    $unique_id = $_POST['unique_id'];

    //calculate the total days
    $start = strtotime($start_date)/60/60/24;
    $end = strtotime($end_date)/60/60/24;
    $total = 1;
    $total += $end - $start ;

    if(isset($_GET['editid'])){
        if($end < $start){
            $_SESSION['message'] = 'Kindly check your end date.';
            $_SESSION['msg_type'] = 'info';
        }else{            
            if($result["available_leave_times"] == 0){
                $_SESSION['message'] = 'Your leave balance has been used up. Kindly request a new leave balance.';
                $_SESSION['msg_type'] = 'danger';
            }else{
                $sql = "UPDATE applyleave SET student_id ='$student_id',uid='$unique_id', course_id='$result[course_id]', leave_type ='$leave_type', leave_reason='$reason',date_start='$start_date',date_end='$end_date',document='$reference',total_days='$total',status='Pending',remark='' WHERE leave_id='$_GET[editid]'";
                $query = $con->query($sql);
                if(mysqli_affected_rows($con) > 0){
                    $_SESSION['message'] = "Leave Record updated successfully.";
                    $_SESSION['msg_type'] = "success";
                    $_SESSION['update'] = "updated";
                    require_once "../../phpmailer/student-to-admin.php";
                }else{
                    $_SESSION['message'] = "No records updated.";
                    $_SESSION['msg_type'] = "info";
                }
            }
        }       
    }else{
        if($end < $start){
            $_SESSION['message'] = 'Kindly check your end date.';
            $_SESSION['msg_type'] = 'info';
            $_SESSION['reason'] = $reason;
        }else{
           if($result["available_leave_times"] == 0){
                $_SESSION['message'] = 'Your leave balance has been used up. Kindly request a new leave balance.';
                $_SESSION['msg_type'] = 'danger';
           }else{
                $sql = "INSERT INTO applyleave(student_id,uid,student_name,course_id,leave_type,leave_reason,date_start,date_end,document,total_days,status) VALUES('$student_id','$unique_id','$result[student_name]','$result[course_id]','$leave_type','$reason','$start_date 12:00:00','$end_date 12:00:00','$reference','$total','Pending')";
                $query = $con->query($sql);
                if(mysqli_affected_rows($con) > 0){
                    $_SESSION['message'] = 'Leave Application has been successfully submitted. ';
                    $_SESSION['msg_type'] = 'success';
                    require_once "../../phpmailer/student-to-admin.php";

                    if($reference != ""){
                        move_uploaded_file($_FILES["document"]["tmp_name"], $target);
                    }
                }else{
                    echo mysqli_error($con);
                }
           }
        }
    }
    
}

// show data when user edit
if(isset($_GET['editid'])){
    $_SESSION['title'] = "Edit Leave Application";
    $sql="SELECT * FROM applyleave WHERE leave_id='$_GET[editid]' ";
	$query = $con->query($sql);
    $rows = mysqli_fetch_array($query);
    $r = $rows['leave_reason'];
    $reference = $rows['document'];
    $from = substr("$rows[date_start]",0,-9);
    $to = substr("$rows[date_end]",0,-9);
}else{
    $_SESSION['title'] = "Add New Leave Application";
    if(isset($_SESSION['reason'])){
        $r = $_SESSION['reason'];
        unset($_SESSION['reason']);
    }else{
        $r = '';
    }
    $reference = '';
    $from = date("Y-m-d");
    $to = date("Y-m-d");
    
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
                            <h2 class="page-header">Apply Leave Application</h2>
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
                    <!-- apply leave form -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><?php echo $_SESSION['title'];?></h3>
                                    <br>
                                    <?php
                                        $sqlcourse = "SELECT * FROM course WHERE course_id = '$result[course_id]'";
                                        $querycourse = $con->query($sqlcourse);
                                        $resultcourse = mysqli_fetch_array($querycourse);
                                    ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <input type="hidden" name="unique_id" id="unique_id" value="<?php                        
                                                            date_default_timezone_set("Asia/Kuala_Lumpur");
                                                            echo date('Y-m-d H:i:s'); //Returns IST
                                                        ?>">
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <td><input type="text" class="form-control" value="<?php echo $result['student_name']?>" readOnly></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Course</th>
                                                            <td><input type="text" class="form-control" value="<?php echo $resultcourse['course_name']?>" readOnly></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Leave type</th>
                                                            <td>
                                                                <select class="form-control" id="leave_type" name="leave_type" required>
                                                                    <option value="" disabled selected>Choose option</option>
                                                                    <option value="Sick leave">Sick leave</option>
                                                                    <option value="Casual leave">Casual leave</option>
                                                                    <option value="Bereavement leave">Bereavement leave</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Reason</th>
                                                            <td>
                                                                <textarea class="form-control textarea" rows="4" cols="65" name="reason" id="reason" placeholder="Enter your reason here" required><?php echo $r?></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>From</th>
                                                            <td>
                                                                <input type="date" name="start_date" id="start_date" class="form-control" min="<?php echo date("Y-m-d"); ?>" max="2021-12-30" value="<?php echo $from?>" required>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>To</th>
                                                            <td>
                                                                <input type="date" name="end_date" id="end_date" class="form-control" min="<?php echo date("Y-m-d"); ?>" max="2021-12-30" value="<?php echo $to?>" required>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Reference(*Certificate)</th>
                                                            <td><input type="file" class="form-control" name="document" id="document" value="<?php echo $reference?>"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>    
                                                <button type="submit" name="submit" id="submit" class="btn btn-info pull-right">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- apply leave form -->
                </div>   
                <!-- Content -->
            </div>
            <!-- wrapper -->

        <!-- jQuery -->
        <script src="../../js/jquery.min.js"></script>
        <!-- Moment Plugin Javascript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../js/startmin.js"></script>

    </body>
</html>
