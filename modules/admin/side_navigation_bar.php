<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>School E-Leave System</title>
        <link rel="shortcut icon" type="image/png" href="../../images/logo.png">
        <!-- Bootstrap Core CSS -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../css/custom.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard">School E-Leave System</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- /.top navigation bar -->
                <ul class="nav navbar-right navbar-top-links">
                    <!-- user -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i><?php echo $result['admin_name']; ?> &nbsp;
                            <span class="userPicture"><img src="../../<?php echo $result['image']; ?>"></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="userProfile"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li>
                                <a href="userChangePassword"><i class="fa fa-gear fa-fw"></i> Change Password</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user -->
                </ul>
                <!-- /.top navigation bar -->

                <!-- side navigation bar -->
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <?php
                                if($result['admin_id'] == 1) :?>
                                <li>
                                <a href="#"><i class="fa fa-user-plus"></i> Admin <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="addAdmin">Add New Admin</a>
                                    </li>
                                    <li>
                                        <a href="viewAdmin">View Current Admin</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>    
                            <?php endif ?>
                            <li>
                                <a href="#"><i class="fa fa-briefcase"></i> Teacher <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="addTeacher">Add New Teacher</a>
                                    </li>
                                    <li>
                                        <a href="viewTeacher">View Current Teacher</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-child"></i> Student <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="addStudent">Add New Student</a>
                                    </li>
                                    <li>
                                        <a href="viewStudent">View Current Student</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-book"></i> Course <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="addCourse">Add New Course</a>
                                    </li>
                                    <li>
                                        <a href="viewCourse">View Current Course</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-calendar-plus-o"></i> Leave Type <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="addLeaveType">Add New Leave Type</a>
                                    </li>
                                    <li>
                                        <a href="viewLeaveType">View Current Leave Type</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-calendar"></i> Leave Application <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="viewPending">View Pending Leave</a>
                                    </li>
                                    <li>
                                        <a href="#">Report<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="leave_record">Leave Report</a>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- side navigation bar -->
            </nav>