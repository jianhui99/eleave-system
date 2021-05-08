<?php

$filename = $_REQUEST['desc'];
if ($filename == "") $filename = "***";
$path = "../../reference/$filename";

if(file_exists($path)){
	header('Content-Description: File transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Length: '.filesize($path));
	readfile($path);
	exit;
}
else{
	echo "<script>alert('No reference document.')</script>";
    header('location:viewPending.php');
}

?>