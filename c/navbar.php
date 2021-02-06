<?php
	require_once("../dbconfig.php");
	if(!session_id())//if session_id is not found
	{
		session_start();
	}
	
	if(isset($_SESSION['id']) != session_id() )
	{
		header("../login.php");
    }
    $sqlr = "SELECT * FROM tb_user WHERE user_id = '".$_SESSION['user_id']."';";
    $resultr = mysqli_query($conn, $sqlr);

    $rowr = mysqli_fetch_array($resultr);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CBS</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
</head>

<body id="page-top">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark" id="mainNav">
        <div class="container"><a class="navbar-brand" href="main.php">CBS</a><button data-toggle="collapse" data-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-align-justify"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive" style="text-shadow: 0px 0px;">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="main.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="carlist.php">CAR LIST</a></li>
                    <li class="nav-item"><a class="nav-link" href="aboutus.php">ABOUT US</a></li>
                    <li class="nav-item"><a class="nav-link" href="contactus.php">Contact US</a></li>
                    <li class="nav-item"><a class="nav-link" href="bookings/read.php">YOUR BOOKINGS</a></li>
                    <li class="nav-item"></li>
                </ul>
            </div>

            <div class="nav-item dropdown no-arrow">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small"><?php echo $rowr["username"]; ?></span><i class="fa fa-user"></i></a>
                <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                    <a class="dropdown-item" href="account/view.php?id=<?php echo $_SESSION['user_id']; ?>">
                            <i class="fa fa-id-badge fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile
                    </a>
                    <a class="dropdown-item" href="account/password.php?id=<?php echo $_SESSION['user_id']; ?>">
                            <i class="fa fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../logout.php">
                            <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout
                    </a>
                </div>
            </div>
      
        </div>
    </nav>