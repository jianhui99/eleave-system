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

if(isset($_POST['request_balance'])){
    $_SESSION['message'] = "Your leave balance update request has been sent successfully.";
    $_SESSION['msg_type'] = "success";
    require_once "../../phpmailer/student-leave-balance.php";
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
                                <h2><?php echo $result['student_name']; ?></h2>
                                <span style="background-color:skyblue;" class="badge">Student</span>
                                <p>Login at: <?php echo $result['login_at']; ?> </p>
                            </div>
                        </div>                     
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
                    <div>
                        <!-- leave record-->
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

                        <div class="toggle">
                            <a href="#" title="Title of Toggle" class="toggle-trigger">Leave Records</a>
                            <div class="toggle-content">
                                <div class="container">
                                    <br>
                                    <div id="calendar">
                                        <!-- fullcalendar -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- leave record-->
                    </div>
                        <!-- leave balance -->
                        <div class="toggle">
                            <a href="#" title="Title of Toggle" class="toggle-trigger">Leave Balance</a>
                            <div class="toggle-content">
                                <div class="container">
                                <br>
                                <p><strong>Notice</strong>: A new leave balance can only be requested when the leave balance is used up.</p>
                                    <form method="post">
                                        <table class="table table-bordered table-striped" id="dataTables_student">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Student name</th>
                                                    <th>Available leave balance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $sql = "SELECT * FROM student WHERE student_id = '$student_id'";
                                                $query = $con->query($sql);
                                                while($rows = mysqli_fetch_array($query)){
                                                    echo "<tr>";
                                                    echo "<td>$rows[student_name]</td>";
                                                    echo "<td>$rows[available_leave_times]</td>";
                                                    if($rows["available_leave_times"] == 0){
                                                        echo "<td style='width:15%;'><button class='btn btn-warning' name='request_balance' id='request_balance'>Request</button></td>";
                                                    }else{
                                                        echo "<td style='width:15%;'><button class='btn btn-warning' name='request_balance' id='request_balance' disabled>Request</button></td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                        
                                            ?>
                                        </table>
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
        <!-- <script src="../../js/jquery.min.js"></script> -->

        <!-- Bootstrap Core JavaScript -->
        <script src="../../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../../js/startmin.js"></script>

    </body>
</html>
<script>

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
</script>