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

//See if this person has an open session
if(isset($_SESSION['user_pk'])) {
	$user = $_SESSION['user'];
	$user_pk = $_SESSION['user_pk'];
	
	//See if the user is requesting anything
	if(isset($_REQUEST['cmd'])) {
		$request = $_REQUEST['cmd'];
		
		//See if the user is requesting to logout
		if($request == "logout") {
			unset($_SESSION['user_pk']);
			
			//Send the user to the home screen
			header("Location: http://174.34.170.64/bootstrap.php");
		}
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
            <ul class="nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Saved Projects <b class="caret"></b></a>
                <ul class="dropdown-menu">
				  <?php
				    $savedProjects = getSavedProjects($user);
					
					foreach($savedProjects as $project) {
						echo "<li><a href='#'>" . $project[1] . "</a></li>";
					}
				  ?>
				  <!--
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
				  -->
                </ul>
              </li>
            </ul>
            <form class="navbar-form pull-right">
              <button type="submit" class="btn">Logout</button>
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
        <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="vlc" /></span>
              VLC
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="ruby" /></span>
              Ruby
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="php5" /></span>
              PHP
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="vim" /></span>
              Vim
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="chromium-browser" /></span>
              Chrome
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="git" /></span>
              Git
            </td>

          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="valac" /></span>
              Valac
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="nodejs" /></span>
              Node.js
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="sublime" /></span>
              Sublime Text
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="mongodb" /></span>
              Mongodb
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="g++" /></span>
              G++
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="packages[]" type="checkbox" value="python" /></span>
              Python
            </td>
      </table>
      <div id="buildVessel" class="proceed">
        <input type='submit' class="btn btn-large btn-success" value="Build Project">
		<input type='submit' class="btn btn-large btn-success" value="Save Project">
      </div>
</form></div>

    </div> 
    </center>
  </div><!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
