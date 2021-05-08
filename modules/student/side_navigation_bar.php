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
                    <a class="navbar-brand" href="Dashboard.php">School E-Leave System</a>
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
                            <i class="fa fa-user fa-fw"></i><?php echo $result['student_name']; ?> &nbsp;
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
                                <a href="Dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Leave Application <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="applyLeave">Apply Leave Application</a>
                                    </li>
                                    <li>
                                        <a href="viewLeaveStatus">View Leave Status</a>
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