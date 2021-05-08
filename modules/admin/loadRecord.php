
<?php

session_start();
//check if user is not login.
if(empty($_SESSION['admin_id'])){
	header('location:index.php');
	exit();
}

$con = new PDO('mysql:host=localhost;dbname=e-leavesystem','root','');
$data = array();

$query = "SELECT * FROM applyleave WHERE status != 'Rejected'";
$statement = $con->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $rows){
    $data[] = array(
        'id'       => $rows['leave_id'],
        'title'    => [$rows['student_name'],$rows['leave_type']],
        'start'    => $rows['date_start'],
        'end'      => $rows['date_end'],
        'color'	   => $rows['status'] == 'Approved' ? '#50D050' : '#EBEB00',
        'textColor'=> 'black',
    );
}

echo json_encode($data);

?>