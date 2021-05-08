
<?php

//check connect
require_once '../../database/db_connection.php';

session_start();
//check if user is not login.
if(empty($_SESSION['student_id'])){
	header('location:index.php');
	exit();
}


//fetch student data
if(isset($_SESSION['student_id'])) {	
	$student_id = $_SESSION['student_id'];
	$sql = "SELECT * FROM student WHERE student_id = '$student_id'";
	$query = $con->query($sql);
	$result = $query->fetch_array();
	$con->close();
}

$con = new PDO('mysql:host=localhost;dbname=e-leavesystem','root','');
$data = array();

$query = "SELECT * FROM applyleave WHERE student_id='$result[student_id]' AND status != 'Rejected'";
$statement = $con->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $rows){
	
    $data[] = array(
        'id'      => $rows['leave_id'],
        'title'   => [$rows['leave_type'],$rows['status']],
        'start'   => $rows['date_start'],
		'end'     => $rows['date_end'],
		'color'	  => $rows['status'] == 'Approved' ? '#50D050' : '#EBEB00',
		'textColor'=> 'black'
    );
}
echo json_encode($data);

?>