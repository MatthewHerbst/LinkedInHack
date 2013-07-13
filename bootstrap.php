<?php
//Start session
session_start();

//Handle database connections
include "db.php";

//Connect to the database
connectDB();

//Login variables
$user = "";
$user_pk = "";
$errorMsg = "";
$message = "";
$request = "";

//Check if a command is coming from browser


//See if this person has an open session
if(isset($_SESSION['user_pk'])) {
	$user = $_SESSION['user'];
	$user_pk = $_SESSION['user_pk'];
}

//See if the user is requesting anything
if(isset($_REQUEST['cmd'])) {
	$request = $_REQUEST['cmd'];
	
	//Check if they are asking to logout
	if($request == "logout") {
		unset($_SESSION['user_pk']);
	} else if($request == "Login") {
		$u = $_REQUEST['username'];
		$p = $_REQUEST['password'];
		
		//Ensure both a username and a password were entered
		if(empty($u)) {
			$errorMsg = "Please enter a username";
		} else if(empty($p)) {
			$errorMsg = "Please enter a password";
		} else {
			$pk = validateUser($u, $p);
			if($pk > 0) {
				$_SESSION['user'] = $u;
				$_SESSION['user_pk'] = $pk;
				$user = $u;
				$user_pk = $pk;
				$message = "Welcome " . $user;
			}
			else {
				$errorMsg = "Invalid User/Password";
			}
		}
	} else if($request == "Register") {
		$u = $_REQUEST['new_username'];
		$p = $_REQUEST['new_password'];
		
		//Ensure both a username and a password were entered
		if(empty($u)) {
			$errorMsg = "Please enter a username";
		} else if(empty($p)) {
			$errorMsg = "Please enter a password";
		} else {
			//See if that username is already taken
			if(checkUserExist($u)) {
				$errorMsg = "Username " . $user . " already exists.";
			} else {
				$added = addUser($u, $p); //Returns 1 if succesful or an error message otherwise
				if($added == 1) {
					$pk = validateUser($u, $p);
					$_SESSION['user_pk'] = $pk;
					$_SESSION['user'] = $u;
					$user = $u;
					$user_pk = $pk;
					$message = "Welcome. Thanks for registering" . $user . "!";
				} else {
					$errorMsg = $added;
				}
			}
		}
	}
} else {
	//Do nothing
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Our cool app!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link href="/css/bootstrap.css" rel="stylesheet">
	<style type="text/css">
		body {
			padding-top: 30px;
			padding-bottom: 30px;
		}
	</style>
	<link href="/css/bootstrap-responsive.css" rel="stylesheet">
</head>

<body bgcolor="#EEEEEE">

    <div class="container">

		<!-- Main hero unit -->
		<div class="hero-unit">
			<center> 
				<h1>Wingman</h1>
			</br>
				<p>Gets you set up.</p>
				<!-- <p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p> -->
			</center>
		</div>

		<!-- One row with 3 columns, each taking the width of 4 items (a row can have up to 12 columns) -->
		<div class="row">
			<div class="span4">
				<a href='/Windowsows.php'> <img src="/img/windows2.png" alt="Windows" width="300" height="300"> </a>
			</div>
			<div class="span4">
				<a href='/apple.php'> <img src="/img/apple.gif" alt="Mac" width="225" height="225">
			</div>
			<div class="span4">
				<a href='/ubuntu.php'> <img src="/img/ubuntu.png" alt="Ubuntu" width="300" height="300">
			</div>
		</div>
	</div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

</body>
</html>
