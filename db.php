<?php
/***** Configuration ****************/
$USER = 'root';
$PASSWORD = 'hackathon2013';
$DB='hackathon';

$USER_TABLE = 'users';
$USERNAME_MAX_SIZE = 30;
$USERNAME_MIN_SIZE = 3;
$PASSWORD_MAX_SIZE = 30;
$PASSWORD_MIN_SIZE = 3;
$COMMENT_MAX_SIZE = 16777215;
$COMMENT_MIN_SIZE = 1;
/************** END CONFIGURATION *************/

/*
Connect to the database
*/
function connectDB() {
	global $USER;
	global $PASSWORD;
	global $DB;
	mysql_connect("localhost",$USER,$PASSWORD) || die("can not connect");
	mysql_select_db($DB);
}

/*
Validate a user - check the password - returns the primary key if successful
or 0 if failed.
*/
function validateUser($user, $password) {
	global $USER_TABLE;
	
	//Username can only be alphanumeric
	if(!ctype_alnum($user)) {
		return 0;
	}
	
	//Password can only be alphanumeric
	if(!ctype_alnum($password)) {
		return 0;
	}
	
	//Run the query on the database
	$query = "select pk, password from ". $USER_TABLE . " where username = '" . mysql_real_escape_string($user) . "'";
	$q = mysql_query($query);
	if(!$q) {
		return 0;
	}
	$r = mysql_fetch_array($q);
	if($r && $r['password'] != crypt($password, $user)) {
	    return 0;
	} else if ($r && $r['pk'] > 0) {
		return $r['pk'];
	} else {
		return 0;
	}
}

/*
Checks to see if a username is in the system
*/
function checkUserExist($user) {
	global $USER_TABLE;
	
	//Run the query on the database
	$sql = "select pk from ". $USER_TABLE . " where username = '" . mysql_real_escape_string($user) . "'";
	$q = mysql_query($sql);
	
	//Check if there was an error running the query
	if(mysql_error()) {
		print "Error checking if username " . $user . " exists. Please contact the site administrator.";
		return false;
	}
	
	//Check if the query has results
	if(!$q) {
		return false;
	}
	
	//Check query results
	$r = mysql_fetch_array($q);
	return ($r && $r['pk'] > 0);
}

/*
Add a new user to the system. Returns 1 if this succeeds, or the error message otherwise.
*/
function addUser($user, $password) {
	global $USER_TABLE;
	global $USERNAME_MAX_SIZE;
	global $PASSWORD_MAX_SIZE;
	global $USERNAME_MIN_SIZE;
	global $PASSWORD_MIN_SIZE;
	
	//Check username rules
	if(!ctype_alnum($user) || strlen($user) > $USERNAME_MAX_SIZE || strlen($user) < $USERNAME_MIN_SIZE) {
		return "Usernames may be between 3 and 30 characters and must be alphanumeric.";
	}
	
	//Check password rules
	if(!ctype_alnum($password) || strlen($password) > $PASSWORD_MAX_SIZE || strlen($password) < $PASSWORD_MIN_SIZE) {
		return "Passwords may be between 3 and 30 characters and must be alphanumeric.";
	}
	
	//Make username safe for db and hash the password
	$fixedUser = mysql_real_escape_string($user);
	$hashedPassword = crypt($password, $user);
	
	//Run the query on the database
	$sql = "insert into " . $USER_TABLE . " (username,password) values ('$fixedUser','$hashedPassword')";
	mysql_query($sql);
	if(mysql_error()) {
		return "Error adding user to table. Please contact the site administrator.";
	} else {
		return 1;
	}
}