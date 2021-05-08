<?php
$server = "localhost";
$dbname = "e-leavesystem";
$username = "root";
$password = "";
//create connection
$con = new mysqli($server, $username,$password ,$dbname);

//check connection
if($con->connect_error){
	die("Connection failed: " . $con->connect_error);
}
else{
	 //echo "Connection Successfully.";
}

