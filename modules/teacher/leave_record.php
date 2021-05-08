<?php
//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['teacher_id'])){
	header('location:index.php');
	exit();
}
// fetch user data from database
include("numberOfUser.php");

//fetch admin data
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

<!-- fullcalendar css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css">
<!-- jquery js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- jquery-ui js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- moment js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
<!-- fullcalendar js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
        
        
<script>
    $(document).ready(function(){
    var calendar = $("#calendar").fullCalendar({
        editable:true,
        header:{
            left:'prev, next today',
            center:'title',
            right:'month'
        },
        events: 'loadRecord.php',
        selectable: false,
        selectHelper: true,
        displayEventTime: false
    });
}); 
</script>

<!-- wrapper -->
<div id="page-wrapper">
                <!-- Content -->
                <div class="container-fluid">
                    <!-- title -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">Calendar</h2>
                        </div>
                    </div>
                    <!-- title -->
                    <!-- leave record -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <center><h3>Student Leave Records</h3></center>
                                    <hr>
                                    <h3>Total Approved : <span style="color: #50D050;"><?php echo $num_rows_leave_approved ?></span></h3>
                                    <h3>Total Pending : <span style="color: #EBEB00;"><?php echo $num_rows_leave_pending ?></span></h3>
                                    <br>
                                    <div class="container">
                                        <div id="calendar">
                                            <!-- fullcalendar -->
                                        </div>
                                        <br>
                                    </div>
                                                
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- leave record -->
                </div>   
                <!-- Content -->
            </div>
            <!-- wrapper -->

    
        <!-- jQuery -->
        <!-- <script src="../../js/jquery.min.js"></script> -->

        <!-- Bootstrap Core JavaScript -->
        <script src="../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../js/startmin.js"></script>

    </body>
</html>
