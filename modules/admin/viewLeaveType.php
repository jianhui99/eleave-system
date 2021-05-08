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
if(isset($_POST['delete'])){
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM leavetype WHERE leave_id='$id'";
    $query = $con->query($sql);
    
    if(mysqli_affected_rows($con) > 0){
        $_SESSION['message'] = "Leave Type Record has been deleted success.";
        $_SESSION['msg_type'] = "success";
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
                            <h2 class="page-header">Current Leave Type Records</h2>
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
                    <!-- leave type record -->
                    <!-- show a pop up modal when call delete function -->
                    <?php include('../../popupmodal/popupmodal_delete.php')?>
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
                                                <table class="table table-bordered table-striped" id="dataTables_leavetype">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Leave Type</th>
                                                            <th>Description</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                    <?php
                                                       
                                                            $sql = "SELECT * FROM leavetype";
                                                            $query = $con->query($sql);
                                                            while($row = mysqli_fetch_array($query)){
                                                                $id = $row['leave_id'];
                                                                echo "<tr>";
                                                                echo "<td>$id</td>";
                                                                echo "<td>$row[leave_name]</td>";
                                                                echo "<td>$row[leave_desc]</td>";
                                                                echo "<td>$row[status]</td>";
                                                                echo "<td><a href='addLeaveType.php?editid=$id' class='btn btn-info'>Edit</a>
                                                                <button type='button' class='btn btn-danger deletebtn'>Delete</button></td>";
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
                    <!-- leave type record -->
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