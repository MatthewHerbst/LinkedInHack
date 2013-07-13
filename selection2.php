<?php
//Start session
session_start();

//Handle database connections
include "db.php";

//Connect to the database
connectDB();

//Variables
$user = "";
$user_pk = "";
$errorMsg = "";
$request = "";
$savedGroups = array();

//See if this person has an open session
if(isset($_SESSION['user_pk'])) {
	$user = $_SESSION['user'];
	$user_pk = $_SESSION['user_pk'];
	
	//Get the user's saved groups
	$savedGroups = getPackageGroups($user);
	
	//See if the user is requesting anything
	if(isset($_REQUEST['cmd'])) {
		$request = $_REQUEST['cmd'];
		
		//See if the user is requesting to logout
		if($request == "logout") {
			unset($_SESSION['user_pk']);
			
			//Send the user to the home screen
			header("Location: http://174.34.170.64/bootstrap.php");
		}
		
		//See if the user is requesting to load a saved group
		if($request == "loadGroup") {
			
		}
		
		//See if the user is requesting to save a new group
			//Make sure to update the list of saved groups
	}
} else { //If they don't, send them to the sign in page
	header("Location: http://174.34.170.64/signin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Your Wingman</title>
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
		   <div class="nav-collapse collapse">
            <form class="navbar-form pull-right" method='post' action='selection.php'>
              <button type="submit" class="btn">Logout</button>
			  <input type='hidden' name='cmd' value='logout' />
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  

<div class="container" bgcolor="#FFFFFFF">
<center>
<div class="vessel">
  <form accept-charset="UTF-8" action="process.php" class="form-horizontal" id="vessels_form" method="post">
<div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="Wfmr4E6zD+a2qbdV3bdlAUxSKPdDsYoj/exCbQX+KGg=" /></div>
  <h2>Setup Project:
    <input type="text"  value="ProjectX"></h2>
	<input type='hidden' name='id' value='<?php echo uniqid(); ?>'>
      <table border=0 class="vesselOptions goods">
	  <?php
		$packages = getPackages();
		$columnInterval = count($packages) / 4;
	  ?>
	  <tr>
	  <?php
		for($i = 0; $i < $columnInterval * 1; ++$i) {
			echo "
			<td>
              <span class='servicebox'><input id='profile_apps_' name='packages[]' type='checkbox' value='" . $packages[$i][0] . "' /></span>
              " . $packages[$i][1] . "
            </td>";
		}
	  ?>
      </tr>
      <tr>
      <?php
		for($i = columnInterval; $i < $columnInterval * 2; ++$i) {
			echo "
			<td>
              <span class='servicebox'><input id='profile_apps_' name='packages[]' type='checkbox' value='" . $packages[$i][0] . "' /></span>
              " . $packages[$i][1] . "
            </td>";
		}
	  ?> 
      </tr>
      <tr>
      <?php
		for($i = columnInterval * 2; $i < $columnInterval * 3; ++$i) {
			echo "
			<td>
              <span class='servicebox'><input id='profile_apps_' name='packages[]' type='checkbox' value='" . $packages[$i][0] . "' /></span>
              " . $packages[$i][1] . "
            </td>";
		}
	  ?> 
      </tr>
      <tr>
      <?php
		for($i = columnInterval * 3; $i < count($packages); ++$i) {
			echo "
			<td>
              <span class='servicebox'><input id='profile_apps_' name='packages[]' type='checkbox' value='" . $packages[$i][0] . "' /></span>
              " . $packages[$i][1] . "
            </td>";
		}
	  ?>       
	  </tr>
      </table>
      <div id="buildVessel" class="proceed">
        <input type='submit' class="btn btn-large btn-success" value="Build Project">
      </div>
</form></div>

    </div> 
    </center>
  </div><!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap-transition.js"></script>
    <script src="/js/bootstrap-alert.js"></script>
    <script src="/js/bootstrap-modal.js"></script>
    <script src="/js/bootstrap-dropdown.js"></script>
    <script src="/js/bootstrap-scrollspy.js"></script>
    <script src="/js/bootstrap-tab.js"></script>
    <script src="/js/bootstrap-tooltip.js"></script>
    <script src="/js/bootstrap-popover.js"></script>
    <script src="/js/bootstrap-button.js"></script>
    <script src="/js/bootstrap-collapse.js"></script>
    <script src="/js/bootstrap-carousel.js"></script>
    <script src="/js/bootstrap-typeahead.js"></script>
    <script src='https://cdn.firebase.com/v0/firebase.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="/assets/app.js?body=1" type="text/javascript"></script>
  </body>
</html>
