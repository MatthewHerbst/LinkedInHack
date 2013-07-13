<?php
/***** Configuration ****************/
$USER = 'root';
$PASSWORD = 'hackathon2013';
$DB='hackathon';

$USER_TABLE = 'users';
$SAVED_PACKAGES_TABLE = 'saved_package_groups';
$PACKAGE_TABLE = 'packages';
$USERNAME_MAX_SIZE = 30;
$USERNAME_MIN_SIZE = 3;
$PASSWORD_MAX_SIZE = 30;
$PASSWORD_MIN_SIZE = 3;
$GROUPNAME_MAX_SIZE = 30;
$GROUPNAME_MIN_SIZE = 1;
/************** END CONFIGURATION *************/

/*
Connect to the database
*/
function connectDB() {
	global $USER;
	global $PASSWORD;
	global $DB;
	mysql_connect("localhost", $USER, $PASSWORD) || die("can not connect");
	mysql_select_db($DB);
}

/*
Validate a user - check the password - returns the primary key if successful
or -1 if failed.
*/
function validateUser($user, $password) {
	global $USER_TABLE;
	
	//Username can only be alphanumeric
	if(!ctype_alnum($user)) {
		return -1;
	}
	
	//Password can only be alphanumeric
	if(!ctype_alnum($password)) {
		return -1;
	}
	
	//Run the query on the database
	$query = "select pk, password from ". $USER_TABLE . " where username = '" . mysql_real_escape_string($user) . "'";
	$q = mysql_query($query);
	if(!$q) {
		return -1;
	}
	$r = mysql_fetch_array($q);
	if($r && $r['password'] != crypt($password, $user)) {
	    return -1;
	} else if ($r && $r['pk'] > 0) {
		return $r['pk'];
	} else {
		return -1;
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
		print mysql_error();
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

/*
Creates a saved group of packages to be associated with a specific user.
Returns 1 if succes, or the error message otherwise.
*/
function createGroup($user, $groupName, $packages) {
	global $SAVED_PACKAGES_TABLE;
	global $GROUPNAME_MAX_SIZE;
	global $GROUPNAME_MIN_SIZE;
	
	//Check group name rules
	if(!ctype_alun($groupName) || strlen($groupName) > $GROUPNAME_MAX_SIZE || strlen($groupName) < $GROUPNAME_MIN_SIZE) {
		return "Project names must be at least 1 character, and no more than 30.";
	}
	
	//Make groupname safe for db
	$fixedGroupName = mysql_real_escape_string($groupName);
	
	//Serialize the array for storage in the database
	$serializedPackages = serialize($packages);
	
	//Run the query on the database
	$sql = "insert into " . $SAVED_PACKAGES_TABLE . " (username, groupname, packages) values('$user', '$fixedGroupName', '$serializedPackages')";
	mysql_query($sql);
	if(mysql_error()) {
		return "Error adding group to the database. Please contact site administrator";
	}
	
	return 1;
}

/*
Gets a list of package groups associated with a user
Returns an array of the data, or an error message if any
*/
function getPackageGroups($user) {
	global $SAVED_PACKAGES_TABLE;
	
	global $SAVED_PACKAGES_TABLE;
	
	//Run the queries on the database
	$sql = "select id, groupname from " . $SAVED_PACKAGES_TABLE . " where username='$user'";
	$names = mysql_query($sql);
	if(mysql_error()) {
		return "Error retrieving packages data for " . $user;
	}
	
	//Make the data useful
	$results = array();
	while($r = mysql_fetch_array($q)) {
		$temp = array($r[0], $r[1]);
		array_push($result, $temp);
	}
	return $result;
}

/*
Returns data from a package group saved by a user
*/
function getPackageData($packageID) {
	global $SAVED_PACKAGES_TABLE;
	
	//Run the query on the database
	$sql = "select packages from " . $SAVED_PACKAGES_TABLE . " where id='$packageID'";
	$q = mysql_query($sql);
	if(mysql_error()) {
		return "Error retrieving package data from group " . $packageID;
	}
	
	//TODO: should do a check on $q being null
	
	//Deserialize the data
	$deserializedPackages = unserialize($q);
	
	return $deserializedPackages;
}