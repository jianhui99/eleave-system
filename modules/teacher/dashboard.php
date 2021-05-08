<?php

//check connect
require_once '../../database/db_connection.php';
session_start();
//check if user is not login.
if(empty($_SESSION['teacher_id'])){
    header('location:index');
    exit();
}


//fetch teacher data
if(isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];
    $sql = "SELECT * FROM teacher WHERE teacher_id = '$teacher_id'";
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
        <div class="row">
            <!-- title -->
            <div class="col-lg-12">
                <h2 class="page-header">Dashboard</h2>
            </div>
            <!-- title -->
            <div class="col-lg-12 user_box">
                <img src="../../<?php echo $result['image']; ?>">
                <div class="user_data">
                    <h2><?php echo $result['teacher_name']; ?></h2>
                    <span style="background-color:lightgreen;" class="badge">Teacher</span>
                    <p>Login at: <?php echo $result['login_at']; ?> </p>
                </div>
            </div>
        </div>
        <hr>
        <!-- latest leave -->
        <div>
            <!-- leave record-->
            <div class="toggle">
                            <!-- Toggle leave records -->
                            <a href="#" title="Title of Toggle" class="toggle-trigger">Student List</a>
                            <!-- Toggle Content to display -->
                            <div class="toggle-content">
                                <div class="container">
                                    <input id="myInput" type="text" class="form-control" placeholder="Type something to search..">
                                    <br>
                                    <table class="table table-bordered table-striped" id="dataTables_student">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Student name</th>
                                                <th>Course name</th>
                                                <th>Phone number</th>
                                                <th>Gender</th>
                                                <th>Available leave balance</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                            <?php
                                                $sql = "SELECT * FROM student WHERE status = 'Active'";
                                                $query = $con->query($sql);
                                                while($rows = mysqli_fetch_array($query)){

                                                    $sqls = "SELECT * FROM course WHERE course_id = '$rows[course_id]'";
                                                    $querys = $con->query($sqls);
                                                    $res = $querys->fetch_array();

                                                    echo "<tr>";
                                                    echo "<td>$rows[student_name]</td>";
                                                    echo "<td>$res[course_name]</td>";
                                                    echo "<td>$rows[phone]</td>";
                                                    echo "<td>$rows[gender]</td>";
                                                    echo "<td>$rows[available_leave_times]</td>";
                                                    echo "<td>$rows[status]</td>";
                                                    echo "</tr>";
                                                }
                                        
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- .toggle-content (end) -->
                        </div><!-- .toggle (end) -->

        </div>
        <!-- latest leave -->
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

    //jQuery filters
    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
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
</script>