<?php
session_start();

unset( $_SESSION['teacher_id'] );
session_destroy();

header('location:index?logout=success');

exit();
