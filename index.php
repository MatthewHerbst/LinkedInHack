<?php
//Start session
session_start();

//Handle database connections
include "db.php";

//Connect to the database
connectDB();

//Login variables
$user_pk="";
$user = "";
$errorMsg = "";
$message = "";
$request="";

//Check if a command is coming from browser
if(isset($_REQUEST['cmd'])) {
	$request=$_REQUEST['cmd'];
}

if($request == "logout") {
	unset($_SESSION['user_pk']);
}

//See if this person has been here before
if(isset($_SESSION['user_pk'])) {
	$user_pk = $_SESSION['user_pk'];
	$user = $_SESSION['user'];

	//They have a session - see if they are asking anything
	if($request == "add") {
		/*
		$comment = $_REQUEST['comment'];
		$add = add($comment, $user_pk);
		if($add != 1) {
			$errorMsg = $add;
		}
		*/
	}
} else { //The user has not logged in
	if(isset($_REQUEST['cmd'])) {
		//See if they are asking to login
		if($_REQUEST['cmd'] == 'login') {
			$u = $_REQUEST['username'];
			$p = $_REQUEST['password'];
			
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else {
				$pk = validateUser($u, $p);
				if ($pk > 0) {
					$_SESSION['user_pk'] = $pk;
					$_SESSION['user'] = $u;
					$user = $u;
					$user_pk = $pk;
					$message = "Welcome " . $user;
				}
				else {
					$errorMsg = "Invalid User/Password";
				}
			}
		} elseif($_REQUEST['cmd'] == 'register') { //See if they are asking to register
			$u = $_REQUEST['new_username'];
			$p = $_REQUEST['new_password'];
			
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else {
				if(checkUserExist($u)) {
					$errorMsg = "Username " . $user . " already exists.";
					print '<script type="text/javascript">'; 
					print 'alert("Username already exists")'; 
					print '</script>'; 
				} else {
					$added = addUser($u, $p);
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
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="author" content="Matthew Herbst">
	<meta charset="utf-8">
	<title>Our cool title!</title>
	<!--<link rel="stylesheet" type="text/css" href="styles/style.css">-->
</head>
<body>
	<div id="header">Our Page!!</div>
	<div id="loginError">
		<?php print $errorMsg; ?>
	</div>
	<div id="login">
		Please Login:
		<form method='post' action='index.php'>
			<label id='login_username'>Name</label><input type='text' name='username' maxlength="30" id='username'/>
			<label id='login_password'>Password</label><input type='password' name='password' maxlength="30" id='password'/>
			<input type='submit' value='Login'/>
			<input type='hidden' name='cmd' value='login' />
		</form>
		<br />
		Not a member? Register now!
		<form method='post' action='index.php'>
			<label id='new_user'>Name</label><input type='text' name='new_username' maxlength="30" id='new_username'/>
			<label id='new_pass'>Password</label><input type='password' name='new_password' maxlength="30" id='new_password'/>
			<input type='submit' value='Register' />
			<input type='hidden' name='cmd' value='register' />
		</form>
	<div>
	<div id="windows"></div>
	<div id="mac"></div>
	<div id="linux"></div>
	<div id="footer">	</div>
</body>
</html>