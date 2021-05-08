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


if(isset($_POST['delete'])){
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM applyleave WHERE leave_id='$id'";
    $query = $con->query($sql);
    
    if(mysqli_affected_rows($con) > 0){
        $_SESSION['message'] = "Leave Record has been deleted success.";
        $_SESSION['msg_type'] = "success";
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
                            <h2 class="page-header">View Leave Application Record</h2>
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
                    <!-- view leave record -->
                    <!-- show pop up modal when call delete function -->
                    <?php include('../../popupmodal/popupmodal_student.php')?>
                    <!-- show pop up modal when call delete function -->
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
                                                <table class="table table-bordered table-striped" id="dataTables_leave">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>ID</th>
                                                            <!-- <th>Student Name</th> -->
                                                            <th>Course</th>
                                                            <th>Leave Type</th>
                                                            <th>Reason</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Total days</th>
                                                            <th>Reference</th>
                                                            <th>Remark</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                    <?php
                                                        $sql = "SELECT * FROM applyleave WHERE student_id = '$result[student_id]'";
                                                        $query = $con->query($sql);
                                                        while($rows = mysqli_fetch_array($query)){
                                                            $sql_course = "SELECT * FROM course WHERE course_id = '$rows[course_id]'";
                                                            $query_course = $con->query($sql_course);
                                                            $result_course = mysqli_fetch_array($query_course);

                                                            $sql_name = "SELECT * FROM student WHERE student_id = '$result[student_id]'";
                                                            $query_name = $con->query($sql_name);
                                                            $result_name = mysqli_fetch_array($query_name);

                                                            $id = $rows['leave_id'];
                                                            $from = substr("$rows[date_start]",0,-9);
                                                            $to = substr("$rows[date_end]",0,-9);
                                                            
                                                            echo "<tr>";
                                                            echo "<td>$id</td>";
                                                            // echo "<td>$result_name[student_name]</td>";
                                                            echo "<td>$result_course[course_name]</td>";
                                                            echo "<td style='width:10%;'>$rows[leave_type]</td>";
                                                            echo "<td style='width:10%;'>$rows[leave_reason]</td>";
                                                            echo "<td>$from</td>";
                                                            echo "<td>$to</td>";
                                                            echo "<td style='width:8%;'>$rows[total_days]</td>";
                                                            if($rows["document"] !=''){
                                                                echo "<td style='width:10%;'>$rows[document]</td>";
                                                            }else{
                                                                echo "<td>No reference</td>";
                                                            }
                                                            if($rows['remark'] != ''){
                                                                echo "<td style='width:13%;'>$rows[remark]</td>";
                                                            }else{
                                                                echo "<td>-</td>";
                                                            }
                                                            if($rows['status'] == 'Approved'){
                                                                echo "<td><span style='color:green; font-weight:bold;'>$rows[status]</span></td>";
                                                            }else if($rows['status'] == 'Rejected'){
                                                                echo "<td><span style='color:red; font-weight:bold;'>$rows[status]</span></td>";
                                                            }else{
                                                                echo "<td><span style='color:#FDD017; font-weight:bold;'>$rows[status]</span></td>";
                                                            }
                                                            
                                                            if($rows['status'] == 'Approved'){
                                                                echo "<td>-</td>";
                                                            }else{
                                                                echo "<td style='width:12%;'>
                                                                        <a href='applyLeave.php?editid=$id' class='btn btn-info'>Edit</a>
                                                                        <button type='button' class='btn btn-danger deletebtn'>Delete</button>
                                                                    </td>";
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>    
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- view leave record -->
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

//show popup modal for delete and get data where select
$(document).ready(function(){
    $('.deletebtn').on('click', function(){
        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        console.log(data);
        $('#delete_id').val(data[0]);
    });
});

</script>