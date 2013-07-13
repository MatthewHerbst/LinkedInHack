<?php
//Start session
session_start();

//Check if the user is asking something
if(isset($_REQUEST['cmd'])) {
	//See if the user wants to logout
	if($_REQUEST['cmd'] == "logout") {
		unset($_SESSION['user_pk']);
			
		//Send the user to the home screen
		header("Location: http://174.34.170.64/bootstrap.php");
	}
}


$data = $_POST['packages'];
$id   = $_POST['id'];

$manifest = '';

foreach($data as $package) {

    if(file_exists('./packages/')) {
	$read_file = file_get_contents('./packages/'.$package.'.pp');
	$manifest .= $read_file."\n\n";
    }
}

$puppet_file = './temp/'.$id.'.pp';

file_put_contents($puppet_file, $manifest);

$final_script = file_get_contents('installer');
$final_script = str_replace('{id}', $id, $final_script);

file_put_contents('./temp/'.$id, $final_script);

$final_file = "curl -s http://174.34.170.64/temp/$id > /tmp/wingscript; sudo bash /tmp/wingscript";

//print_r($final_file);

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
			padding-top: 100px;
			padding-bottom: 30px;
		}
	</style>
	<link href="/css/bootstrap-responsive.css" rel="stylesheet">
</head>

<body bgcolor="#EEEEEE">

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
			  <li><a href="selection.php">Build Projects</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Saved Projects <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <form class="navbar-form pull-right" method='post' action='selection.php'>
              <button type="submit" class="btn">Logout</button>
			  <input type='hidden' name='cmd' value='logout' />
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

		<!-- Main hero unit -->
		<div class="hero-unit" >
			<center> 
				<h1>You're one step away!</h1>
			</br>
				<p>Please run this command in your terminal</p>
			</br>
				<pre class="curl-tag" background="/img/witewall_3.png">
					<?php
						echo "<p text-align='center'>" . $final_file . "</p>";
					?>
				</pre>
			</center>
		</div>
	</div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

</body>
</html>