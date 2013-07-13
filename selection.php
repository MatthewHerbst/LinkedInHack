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
<center>
<div class="vessel">
  <form accept-charset="UTF-8" action="/profiles" class="form-horizontal" id="vessels_form" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="Wfmr4E6zD+a2qbdV3bdlAUxSKPdDsYoj/exCbQX+KGg=" /></div>
  <h1>Setup Project: <span>Project 1</span><input html="{:value=&gt;&quot;Project 1&quot;, :placeholder=&gt;&quot;Project 1&quot;}" id="profile_title" name="profile[title]" size="30" type="text" />
    <input type="text" placeholder="Orihect 1" value="Project 1"></h1>
      <table border=0 class="vesselOptions goods">
        <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="Google_Apps" /></span>
              Google_Apps
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="HipChat" /></span>
              HipChat
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="Yammer" /></span>
              Yammer
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="github" /></span>
              GitHub
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="droplr" /></span>
              Droplr
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="alfred" /></span>
              Alfred
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="dropbox" /></span>
              Dropbox
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="virtualbox" /></span>
              Virtualbox
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="notational_velocity" /></span>
              Notational velocity
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="wunderlist" /></span>
              Wunderlist
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="googleearth" /></span>
              Googleearth
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="crashplan" /></span>
              Crashplan
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="chrome" /></span>
              Chrome
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="vlc" /></span>
              Vlc
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="things" /></span>
              Things
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="textmate" /></span>
              Textmate
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="sublime_text_2" /></span>
              Sublime text 2
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="spotify" /></span>
              Spotify
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="sparrow" /></span>
              Sparrow
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="skype" /></span>
              Skype
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="screen" /></span>
              Screen
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="rdio" /></span>
              Rdio
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="onepassword" /></span>
              Onepassword
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="minecraft" /></span>
              Minecraft
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="handbrake" /></span>
              Handbrake
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="caffeine" /></span>
              Caffeine
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="airfoil" /></span>
              Airfoil
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="imagemagick" /></span>
              Imagemagick
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="gitx" /></span>
              Gitx
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="clojure" /></span>
              Clojure
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="csshx" /></span>
              Csshx
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="vagrant" /></span>
              Vagrant
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="postgresql" /></span>
              Postgresql
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="mysql" /></span>
              Mysql
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="cassandra" /></span>
              Cassandra
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="mongodb" /></span>
              Mongodb
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="java" /></span>
              Java
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="python" /></span>
              Python
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="zsh" /></span>
              Zsh
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="zeromq" /></span>
              Zeromq
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="xquartz" /></span>
              Xquartz
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="wget" /></span>
              Wget
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="sysctl" /></span>
              Sysctl
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="swig" /></span>
              Swig
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="sudo" /></span>
              Sudo
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="solr" /></span>
              Solr
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="scons" /></span>
              Scons
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="riak" /></span>
              Riak
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="redis" /></span>
              Redis
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="qt" /></span>
              Qt
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="phantomjs" /></span>
              Phantomjs
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="nodejs" /></span>
              Nodejs
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="nginx" /></span>
              Nginx
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="memcached" /></span>
              Memcached
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="macvim" /></span>
              Macvim
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="iterm2" /></span>
              Iterm2
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="heroku" /></span>
              Heroku
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="erlang" /></span>
              Erlang
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="emacs" /></span>
              Emacs
            </td>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="elasticsearch" /></span>
              Elasticsearch
            </td>
          </tr>
          <tr>
            <td>
              <span class="servicebox"><input id="profile_apps_" name="profile[apps][]" type="checkbox" value="colloquy" /></span>
              Colloquy
            </td>
          </tr>
      </table>
      <div id="buildVessel" class="proceed">
        <button class="btn btn-large btn-success" type="button">Build Vessel</button>
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