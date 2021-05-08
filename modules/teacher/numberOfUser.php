<?php

// get the number of all registered admin
$sqls = "SELECT count(admin_id) AS total FROM admin WHERE status='Active'";
$querys = $con->query($sqls);
$values = mysqli_fetch_assoc($querys);
$num_rows_admin = $values['total'];

// get the number of all registered teacher
$sqls = "SELECT count(teacher_id) AS total FROM teacher WHERE status='Active'";
$querys = $con->query($sqls);
$values = mysqli_fetch_assoc($querys);
$num_rows_teacher = $values['total'];

// get the number of all registered student
$sqls = "SELECT count(student_id) AS total FROM student WHERE status='Active'";
$querys = $con->query($sqls);
$values = mysqli_fetch_assoc($querys);
$num_rows_student = $values['total'];

// get the number of all apply leave
$sqls = "SELECT count(leave_id) AS total FROM applyleave WHERE status='Pending'";
$querys = $con->query($sqls);
$values = mysqli_fetch_assoc($querys);
$num_rows_leave_pending = $values['total'];

// get the number of all apply leave
$sqls = "SELECT count(leave_id) AS total FROM applyleave WHERE status='Approved'";
$querys = $con->query($sqls);
$values = mysqli_fetch_assoc($querys);
$num_rows_leave_approved = $values['total'];

// get the number of all apply leave
$sqls = "SELECT count(course_id) AS total FROM course WHERE status='Active'";
$querys = $con->query($sqls);
$values = mysqli_fetch_assoc($querys);
$num_rows_course = $values['total'];

?>