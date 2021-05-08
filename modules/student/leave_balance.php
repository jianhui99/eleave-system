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


?>
<!-- import navigation bar -->
<?php require_once "side_navigation_bar.php"; ?>