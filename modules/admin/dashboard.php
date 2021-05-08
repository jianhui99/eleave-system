<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

// Include autoload.php file
require '../../phpmailer/vendor/autoload.php';
$mail = new PHPMailer(true);

//check connect
require_once '../../database/db_connection.php';

session_start();
//check if user is not login.
if(empty($_SESSION['admin_id'])){
	header('location:index');
	exit();
}

// fetch user data from database
include("numberOfUser.php");

//fetch admin data
if(isset($_SESSION['admin_id'])) {	
	$admin_id = $_SESSION['admin_id'];
	$sql = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
}

if(isset($_POST['update_balance'])){
    if(isset($_POST["check"])){
        $sid = $_POST["check"];
        foreach($sid as $value){
            $sqls = "UPDATE student SET available_leave_times = 3 WHERE email = '$value'";
            $querys = $con->query($sqls);
    
            $s = "SELECT * FROM student WHERE email = '$value'";
            $q = $con->query($s);
            // while($r = mysqli_fetch_array($q)){
            //     $content = "$r[student_name], your leave balance update request has been approved."."<br>".
            //     "Leave Balance: $r[available_leave_times]"."<br>".
            //     "Process by $result[admin_name]. "."<br>"."<br>".
    
            //     "Department Office (Academic Unit)"."<br>"."<br>".  
            //     "JH UNIVERSITY COLLEGE"."<br>".  
            //     "No 1, Lorong 1, Taman Sentosa,"."<br>".  
            //     "33300 Gerik, Perak, Malaysia."."<br>".  
            //     "Tel: 05-7911 444"."<br>".  
            //     "Fax: 05-7911 001"."<br>".
            //     "E-mail: department@jh.edu.my"."<br>".  
            //     "Link: <a href='http://localhost/E-leaveSystem/modules/student/index.php'>Login as student</a>"."<br>";
    
            //     try {
            //         $mail->isSMTP();
            //         $mail->Host = 'smtp.gmail.com';
            //         $mail->SMTPAuth = true;
            //         $mail->Username = 'jianhui5939@gmail.com';
            //         $mail->Password = 'jian123hui';
            //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            //         $mail->Port = 587;
    
            //         // Email from which you want to send the email
            //         $mail->setFrom("jianhui5939@gmail.com", "Department  Office(Academic Unit)");
            //         // Recipient Email where you want to receive emails
            //         $mail->addAddress($value);
            //         $mail->isHTML(true);
            //         $mail->Subject = '[Vocational Programme] Leave Balance Status';
            //         $mail->Body = $content;
            //         $mail->send();
            //         $mail->ClearAllRecipients();
            //         $mail->ClearAttachments();
    
            //     }catch(Exception $e) {
            //         echo "<script type='text/javascript'>alert(\"$mail->ErrorInfo.\");</script>";
            //     }        
            // }
        }
        if(mysqli_affected_rows($con) > 0){
            $_SESSION['message'] = "Student's leave balance request approved successfully.";
            $_SESSION['msg_type'] = "success";
        }else{
            $_SESSION['message'] = "No records updated.";
            $_SESSION['msg_type'] = "info";
        }
    }else{
        $_SESSION['message'] = "No records updated.";
        $_SESSION['msg_type'] = "info";
    }
     

}

if(isset($_POST['reject_balance'])){
    if(isset($_POST["check"])){
        $sid = $_POST["check"];
        foreach($sid as $value){
            $s = "SELECT * FROM student WHERE email = '$value'";
            $q = $con->query($s);
            while($r = mysqli_fetch_array($q)){
                $content = "$r[student_name], your leave balance request has been rejected."."<br>".
                "Leave Balance: $r[available_leave_times]"."<br>".
                "Process by $result[admin_name]. "."<br>"."<br>".
    
                "Department Office (Academic Unit)"."<br>"."<br>".  
                "JH UNIVERSITY COLLEGE"."<br>".  
                "No 1, Lorong 1, Taman Sentosa,"."<br>".  
                "33300 Gerik, Perak, Malaysia."."<br>".  
                "Tel: 05-7911 444"."<br>".  
                "Fax: 05-7911 001"."<br>".
                "E-mail: department@jh.edu.my"."<br>".  
                "Link: <a href='http://localhost/E-leaveSystem/modules/student/index.php'>Login as student</a>"."<br>";
    
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'jianhui5939@gmail.com';
                    $mail->Password = 'jian123hui';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
    
                    // Email from which you want to send the email
                    $mail->setFrom("jianhui5939@gmail.com", "Department  Office(Academic Unit)");
                    // Recipient Email where you want to receive emails
                    $mail->addAddress($value);
                    $mail->isHTML(true);
                    $mail->Subject = '[Vocational Programme] Leave Balance Status';
                    $mail->Body = $content;
                    $mail->send();
                    $mail->ClearAllRecipients();
                    $mail->ClearAttachments();
    
                }catch(Exception $e) {
                    echo "<script type='text/javascript'>alert(\"$mail->ErrorInfo.\");</script>";
                }        
            }
        }
        if(mysqli_affected_rows($con) > 0){
            $_SESSION['message'] = "Student's leave balance request rejected successfully.";
            $_SESSION['msg_type'] = "success";
        }else{
            $_SESSION['message'] = "No records updated.";
            $_SESSION['msg_type'] = "info";
        }
    }else{
        $_SESSION['message'] = "No records updated.";
        $_SESSION['msg_type'] = "info";
    }
     

}

?>

<!-- import navigation bar -->
<?php require_once "side_navigation_bar.php"; ?>
            <!-- wrapper -->
            <div id="page-wrapper">
                <!-- Content -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- title -->
                        <div class="col-lg-12">
                            <h2 class="page-header">Dashboard</h2>
                        </div>
                        <!-- title -->
                        <div class="col-lg-12 user_box">
                            <img src="../../<?php echo $result['image']; ?>">
                            <div class="user_data">
                                <h2><?php echo $result['admin_name']; ?></h2>
                                <?php if($result['username'] == 'superadmin'):?>
                                    <span style="background-color:gold;" class="badge">Super Admin</span>
                                <?php else :?>
                                    <span style="background-color:red;" class="badge">Admin</span>
                                <?php endif ?> 
                                <p>Login at: <?php echo $result['login_at']?></p>
                            </div>
                        </div>
                        <!-- data box -->
                        <div class="col-lg-3 col-md-6 col-xs-4 dataBox">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="images/admin.png" width="75px">
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $num_rows_admin ?></div>
                                            <div>Total Admins</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="viewAdmin">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-xs-4 dataBox">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <img src="images/teacher.png" width="75px">
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $num_rows_teacher ?></div>
                                            <div>Total Teachers</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="viewTeacher">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-xs-4 dataBox">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <img src="images/student.png" width="75px">
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $num_rows_student ?></div>
                                            <div>Total Students</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="viewStudent">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-xs-4 dataBox">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <img src="images/course.png" width="75px">
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $num_rows_course ?></div>
                                            <div>Total Courses</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="viewCourse">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-xs-4 dataBox">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <img src="images/leave.png" width="75px">
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $num_rows_leave_pending ?></div>
                                            <div>Total Pending</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="viewPending">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- data box -->
                    </div>
                    <hr>
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
                    <!-- latest leave -->                    
                    <div class="toggle">
                        <a href="#" title="Title of Toggle" class="toggle-trigger">Latest Leave Application</a>
                        <div class="toggle-content">
                            <div class="container">
                                <!-- show a pop up modal when call delete function -->
                                <?php include('../../popupmodal/popupmodal_leave_process.php')?>
                                <!-- show a pop up modal when call delete function -->
                                <!-- row -->
                                <div class="row">
                                    <div class="col-lg-12">
                                       <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="thead-light">           
                                                        <br>            
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Student Name</th>
                                                            <th>Leave Type</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Posting date</th>
                                                            <th>Action</th>
                                                        </tr>                
                                                    </thead>            
                                                    <tbody id="myTable">
                                                        <?php
                                                            $sql = "SELECT * FROM applyleave WHERE status='Pending' ORDER BY leave_id DESC LIMIT 3";
                                                            $query = $con->query($sql);
                                                            while($row = mysqli_fetch_array($query)){

                                                            $sql_name = "SELECT * FROM student WHERE student_id = '$row[student_id]'";
                                                            $query_name = $con->query($sql_name);
                                                            $result_name = mysqli_fetch_array($query_name);

                                                            $id = $row['leave_id'];
                                                            $from = substr("$row[date_start]",0,-9);
                                                            $to = substr("$row[date_end]",0,-9);

                                                            echo "<tr>";
                                                            echo "<td>$id</td>";
                                                            echo "<td>$result_name[student_name]</td>";
                                                            echo "<td>$row[leave_type]</td>";
                                                            echo "<td>$from</td>";
                                                            echo "<td>$to</td>";
                                                            echo "<td>$row[date_post]</td>";
                                                            echo "<td><button type='button' id='viewBtn' class='btn btn-info'>View</button></td>";
                                                            echo "</tr>";
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>    
                                            </div>            
                                        </div>             
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                    <!-- latest leave -->
                    <!-- leave balance -->
                    <div class="toggle">
                        <a href="#" title="Title of Toggle" class="toggle-trigger">Student Leave Balance</a>
                        <div class="toggle-content">
                            <div class="container">
                            <br>
                            <p><strong>Notice</strong>: An email notification will be sent after the leave balance is updated.</p>
                                    <form method="POST" >
                                        <table class="table table-bordered table-striped" id="dataTables_student">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Student ID</th>
                                                    <th>Student name</th>
                                                    <th>Available leave balance</th>
                                                    <th><input type="checkbox" id="check_all">&nbsp;All</th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $sql = "SELECT * FROM student";
                                                $query = $con->query($sql);
                                                while($rows = mysqli_fetch_array($query)){
                                                    echo "<tr>";
                                                    echo "<td>$rows[student_id]</td>";
                                                    echo "<td>$rows[student_name]</td>";
                                                    echo "<td>$rows[available_leave_times]</td>";
                                                    if($rows["available_leave_times"] == 0){
                                                        $val = "$rows[email]";
                                                        echo "<td><input type='checkbox' class='check_item' name='check[]' value='$val'></td>";
                                                    }else{
                                                        echo "<td><input type='checkbox' disabled></td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </table>
                                        <button class='btn btn-danger pull-right' name='reject_balance' id='reject_balance' onclick="return confirm('Are you sure you want to reject?')">Reject</button>
                                        <button class='btn btn-info pull-right' name='update_balance' id='update_balance'>Approve</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <!-- leave balance -->
                </div>
                <!-- content  -->
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

<script>

$(document).ready(function(){
    $(document).on('click','#viewBtn',function(){
        window.location.href = "viewPending";
    });
});

$(document).ready(function($) { 
    // Find the toggles and hide their content
    $('.toggle').each(function(){
        $(this).find('.toggle-content').hide();
    });
    // When a toggle is clicked, show the content
    $('.toggle a.toggle-trigger').click(function(){
        var el = $(this), parent = el.closest('.toggle');

        if( el.hasClass('active') )
        {
            parent.find('.toggle-content').slideToggle();
            el.removeClass('active');
        }
        else
        {
            parent.find('.toggle-content').slideToggle();
            el.addClass('active');
        }
        return false;
    });
});

//multiple select
$('#check_all').change(function () {
    $('.check_item').prop('checked',this.checked);
});

$('.check_item').change(function () {
 if ($('.check_item:checked').length == $('.check_item').length){
  $('#check_all').prop('checked',true);
 }
 else {
  $('#check_all').prop('checked',false);
 }
});
</script>