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

//fetch admin data
if(isset($_SESSION['admin_id'])) {	
	$admin_id = $_SESSION['admin_id'];
	$sql = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
}

if(isset($_POST['rejectBtn'])){
    if(isset($_POST["check"])){
        $leave_id = $_POST['check'];
        foreach($leave_id as $value){
            $sql = "UPDATE applyleave SET status='Rejected', remark='Kindly check your reference(*certificate) or leave balance.',process_by='$result[admin_id]' WHERE leave_id='$value'";
            $query = $con->query($sql);

            //using leave id fetch student_id
            $s = "SELECT * FROM applyleave WHERE leave_id = '$value'";
            $q = $con->query($s);
            $r = $q->fetch_array();

            //using student_id fetch student email
            $sql_student = "SELECT * FROM student WHERE student_id='$r[student_id]'";
            $query_student = $con->query($sql_student);
            $rows_student = $query_student->fetch_array();

            $sqq = "SELECT * FROM student WHERE email='$rows_student[email]'";
            $qqq = $con->query($sqq);
            while($rrr = mysqli_fetch_array($qqq)){
                $from = substr("$r[date_start]",0,-9);
                $to = substr("$r[date_end]",0,-9);

                $content = "$rrr[student_name], your $r[leave_type] from $from to $to has been $r[status]."."<br>".
                "Remark: $r[remark]"."<br>".
                "<a href='http://localhost/E-leaveSystem/modules/student/index.php'>Login as student</a>"."<br>"."<br>".
                "Process by Mr/Miss $result[admin_name]. "."<br>".
                "Department Office (Academic Unit)"."<br>".  
                "JH UNIVERSITY COLLEGE"."<br>".  
                "No 1, Lorong 1, Taman Sentosa,"."<br>".  
                "33300 Gerik, Perak, Malaysia."."<br>".  
                "Tel: 05-7911 444"."<br>".  
                "Fax: 05-7911 001"."<br>".
                "E-mail: department@jh.edu.my"."<br>";
    
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
                    $mail->addAddress($rrr['email']);
                    $mail->isHTML(true);
                    $mail->Subject = '[Vocational Programme] Leave Application Status';
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
            $_SESSION['message'] = "Leave Record has been process success.";
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

if(isset($_POST['approveBtn'])){
    
    if(isset($_POST["check"])){
        $leave_id = $_POST['check'];
        foreach($leave_id as $value){
            $sql = "UPDATE applyleave SET status='Approved', remark='Your leave balance has been deducted, it is prohibited to apply new leave when the leave balance is used up.',process_by='$result[admin_id]' WHERE leave_id='$value'";
            $query = $con->query($sql);
            
            //using leave id fetch student id.
            $sql_get_student = "SELECT * FROM applyleave WHERE leave_id = $value";
            $query_get_student= $con->query($sql_get_student);
            $r_student = mysqli_fetch_array($query_get_student);

            //using student_id fetch leave balance
            $sql_get_balance = "SELECT * FROM student WHERE student_id = '$r_student[student_id]'";
            $query_get_balance = $con->query($sql_get_balance);
            $rs = mysqli_fetch_array($query_get_balance);

            //calculate leave balance
            $leave_balance = $rs['available_leave_times'];
            $count = $leave_balance - 1;

            //using leave id to fetch student id.
            $sql_get_sid = "SELECT * FROM applyleave WHERE leave_id = $value";
            $query_get_sid = $con->query($sql_get_sid);

            //using student_id update leave balance 
            while($r = mysqli_fetch_array($query_get_sid)){
                $s = "UPDATE student SET available_leave_times='$count' WHERE student_id='$r[student_id]'";
                $q = $con->query($s);
            }

            //using leave_id fetch applyleave data
            $sql_get_applyleave = "SELECT * FROM applyleave WHERE leave_id = '$value'";
            $query_get_applyleave = $con->query($sql_get_applyleave);
            $result_get_applyleave = $query_get_applyleave->fetch_array();

            //using applyleave data fetch student_id
            $sql_student = "SELECT * FROM student WHERE student_id='$result_get_applyleave[student_id]'";
            $query_student = $con->query($sql_student);
            $rows_student = $query_student->fetch_array();

            //using student_id fetch student email
            $sqq = "SELECT * FROM student WHERE email='$rows_student[email]'";
            $qqq = $con->query($sqq);
            while($rrr = mysqli_fetch_array($qqq)){
                $from = substr("$result_get_applyleave[date_start]",0,-9);
                $to = substr("$result_get_applyleave[date_end]",0,-9);

                $content = "$rrr[student_name], your $result_get_applyleave[leave_type] from $from to $to has been $result_get_applyleave[status]."."<br>".
                "Remark: $result_get_applyleave[remark]"."<br>"."<br>".
                "Process by Mr/Miss $result[admin_name]. "."<br>".
                "Department Office (Academic Unit)"."<br>".  
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
                    $mail->addAddress($rrr['email']);
                    $mail->isHTML(true);
                    $mail->Subject = '[Vocational Programme] Leave Application Status';
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
            $_SESSION['message'] = "Leave Record has been process success. ";
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
                    <!-- title -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">Current Pending Leave Records</h2>
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
                    <!-- student record -->
                    <!-- show a pop up modal when call delete function -->
                    <?php include('../../popupmodal/popupmodal_leave_process.php')?>
                    <!-- show a pop up modal when call delete function -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <input id="myInput" type="text" class="form-control" placeholder="Type something to search..">
                                    <br>
                                    <form method="post">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table id="dataTables_student" class="table table-bordered table-striped" >
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <td>ID</td>
                                                            <td>Student Name</td>
                                                            <td>Course</td>
                                                            <td>Leave Type</td>
                                                            <td>Reason</td>
                                                            <td>Reference</td>
                                                            <td>From</td>
                                                            <td>To</td>
                                                            <td>Total days</td>
                                                            <td>Leave Balance</td>
                                                            <td><input type="checkbox" id="check_all">&nbsp;All</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                    <?php
                                                            $sql = "SELECT * FROM applyleave WHERE status='Pending'";
                                                            $query = $con->query($sql);
                                                            while($row = mysqli_fetch_array($query)){
                                                                $sqlcourse = "SELECT * FROM course WHERE course_id = '$row[course_id]'";
                                                                $querycourse = $con->query($sqlcourse);
                                                                $resultcourse = mysqli_fetch_array($querycourse);

                                                                $sql_name = "SELECT * FROM student WHERE student_id = '$row[student_id]'";
                                                                $query_name = $con->query($sql_name);
                                                                $result_student = mysqli_fetch_array($query_name);


                                                                $id = $row['leave_id'];
                                                                $from = substr("$row[date_start]",0,-9);
                                                                $to = substr("$row[date_end]",0,-9);
                                                                $email = $result_student["email"];

                                                                echo "<tr>";
                                                                echo "<td width='5%'>$id</td>";
                                                                echo "<td>$result_student[student_name]</td>";
                                                                echo "<td width='8%'>$resultcourse[course_name]</td>";
                                                                echo "<td width='10%'>$row[leave_type]</td>";
                                                                echo "<td width='10%'> $row[leave_reason]</td>";
                                                                if(!empty($row['document'])){
                                                                    echo "<td><a href='document.php?desc=$row[document]' class='btn btn-primary'>Download</a></td>";
                                                                }else{
                                                                    echo "<td>No reference</td>";
                                                                }
                                                                echo "<td>$from</td>";
                                                                echo "<td>$to</td>";
                                                                echo "<td width='8%'>$row[total_days]</td>";
                                                                echo "<td width='10%'>$result_student[available_leave_times]</td>";
                                                                echo "<td><input type='checkbox' class='check_item' name='check[]' value='$id'></td>";
                                                                echo "</tr>";
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table> 
                                                <button class='btn btn-danger pull-right' name='rejectBtn' id='rejectBtn' onclick="return confirm('Are you sure you want to reject?')">Reject</button>
                                                <button class='btn btn-info pull-right' name='approveBtn' id='approveBtn'>Approve</button> 
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- student record -->
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
<script>

//jQuery filters
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
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