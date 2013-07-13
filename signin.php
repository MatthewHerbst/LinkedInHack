<?php
//Start session
session_start();

//Handle database connections
include "db.php";

//Connect to the database
connectDB();

//Login variables
$errorMsg = "";
$request = "";
$goingTo = "";

//Get where this person wants to go
if(isset($_REQUEST['os'])) {
	$goingTo = $_REQUEST['os'];
}

//See if this person has an open session
if(isset($_SESSION['user_pk'])) {
	header("Location: http://174.34.170.64/selection.php");
	
	//Check if the user wants to logout
	if(isset($_REQUEST['cmd'])) {
		if($_REQUEST['cmd'] == "logout") {
			unset($_SESSION['user_pk']);
		}
	}
} else { //They need to sign in or register
	//See if the user is requesting anything
	if(isset($_REQUEST['cmd'])) {
		$request = $_REQUEST['cmd'];
		
		//Get the entered username and password
		$u = $_REQUEST['username'];
		$p = $_REQUEST['password'];
		
		//Check if the user wants to login
		if($request == "login") {			
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else { //Check the entered username and password
				//Get the user's primary key (if they exist)
				$pk = validateUser($u, $p);
				if($pk != -1) {
					//User exists, initialize session variables
					$_SESSION['user'] = $u;
					$_SESSION['user_pk'] = $pk;
					
					//Send the user to the selection page
					header("Location: http://174.34.170.64/selection.php");
				} else {
					$errorMsg = "Invalid Username/Password";
				}
			} //Check if the user wants to register
		} else if($request == "register") {	
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else {
				//See if that username is already taken
				if(checkUserExist($u)) {
					$errorMsg = "Username " . $u . " already exists.";
				} else {
					$added = addUser($u, $p); //Returns 1 if succesful or an error message otherwise
					if($added == 1) {
						$pk = validateUser($u, $p);
						
						//Check if the validation returned valid
						if($pk != -1) {
							$_SESSION['user_pk'] = $pk;
							$_SESSION['user'] = $u;
							
							//Send the user to the selection page
							header("Location: http://174.34.170.64/selection.php");
						} else {
							$errorMsg = "Usernames and passwords must be alphanumeric";
						}
					} else {
						$errorMsg = $added;
					}
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in &middot; Wingman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
        margin-top: 100px;
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="bootstrap.php">Wingman</a>
        </div>
      </div>
    </div>
    <div class="container">
      <form class="form-signin" method='post' action='signin.php'>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" name="username" maxlength="30" id="username" placeholder="Username">
        <input type="password" class="input-block-level" name="password" maxlength="30" id="password" placeholder="Password">
        <!--<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
		<input type='hidden' name='cmd' value='login' />-->
		<script type="text/javascript">
		function loginOrRegister(type) {
			if(type == "login") {
				return "<input type='hidden' name='cmd' value='login' />";
			} else {
				return "<input type='hidden' name='cmd' value='register' />";
			}
		};
		</script>
        <button class="btn btn-large btn-primary" type="submit" onclick="loginOrRegister('login')">Sign in</button>
		<button class="btn btn-large btn-primary" type="submit" onclick="loginOrRegister('register')">Register</button>
      </form>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

  </body>
</html>
