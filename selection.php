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
$message = "";
$request = "";

//See if this person has an open session
if(!isset($_SESSION['user_pk'])) {
	$user = $_SESSION['user'];
	$user_pk = $_SESSION['user_pk'];
	
	//See if the user is requesting anything
	if(isset($_REQUEST['cmd'])) {
		$request = $_REQUEST['cmd'];
		
		if($request == "logout") {
			unset($_SESSION['user_pk']);
			header("Location: http://174.34.170.64/signin.php");
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
  

<div class="container" bgcolor="#FFFFFFF">
<center>
<div class="vessel">
  <form accept-charset="UTF-8" action="/profiles" class="form-horizontal" id="vessels_form" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="Wfmr4E6zD+a2qbdV3bdlAUxSKPdDsYoj/exCbQX+KGg=" /></div>
  <h1>Setup Project: <span>Project 1</span><input html="{:value=&gt;&quot;Project 1&quot;, :placeholder=&gt;&quot;Project 1&quot;}" id="profile_title" name="profile[title]" size="30" type="text" />
    <input type="text" placeholder="Orihect 1" value="Project 1"></h1>
      <table border=0 class="vesselOptions goods">
        <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="vlc" /></span>
              VLC
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="ruby" /></span>
              Ruby
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="php5" /></span>
              PHP
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="vim" /></span>
              vim
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="chromium-browser" /></span>
              Chrome
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="git" /></span>
              Git
            </td>

          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="valac" /></span>
              Valac
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="wunderlist" /></span>
              Wunderlist
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="googleearth" /></span>
              Googleearth
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="crashplan" /></span>
              Crashplan
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="g++" /></span>
              G++
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="python" /></span>
              Python
            </td>
      </table>
      <div id="buildVessel" class="proceed">
        <button class="btn btn-large btn-success" type="button">Build Project</button>
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