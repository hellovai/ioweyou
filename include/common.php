<?php
function string_begins_with($string, $search)
{
	return (strncmp($string, $search, strlen($search)) == 0);
}

function boolToString($bool) {
	return $bool ? 'true' : 'false';
}

function escape($str) {
	return mysql_real_escape_string($str);
}

function escapePHP($str) {
	return addslashes($str);
}

function chash($str) {
	return hash('sha512', $str);
}

function isAlphaNumeric($str) {
	return ctype_alnum($str);
}

function stripAlphaNumeric($str) {
	return preg_replace("/[^a-zA-Z0-9\s]/", "", $str);
}

function strcompare($string1, $string2) {
	return ($string1==$string2);
}

function uid($length) {
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$string = "";	

	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}

	return $string;
}

function toArray($str, $main_delimiter = ";", $sub_delimiter = ":") {
	$parts = explode($main_delimiter, $str);
	$array = array();
	
	foreach($parts as $part) {
		$part_array = explode($sub_delimiter, $part, 2);
		
		if(count($part_array) >= 2) {
			$key = trim($part_array[0]);
			$value = trim($part_array[1]);
			
			if($value == "false") $value = false;
			else if($value == "true") $value = true;
			
			$array[$key] = $value;
		}
	}
	
	return $array;
}

//returns an absolute path to the include directory, without trailing slash
function includePath() {
	$self = __FILE__;
	$lastSlash = strrpos($self, "/");
	return substr($self, 0, $lastSlash);
}

//returns a relative path to the oneapp/ directory, without trailing slash
function basePath() {
	$commonPath = __FILE__;
	$requestPath = $_SERVER['SCRIPT_FILENAME'];
	
	//count the number of slashes
	// number of .. needed for include level is numslashes(request) - numslashes(common)
	// then add one more to get to base
	$commonSlashes = substr_count($commonPath, '/');
	$requestSlashes = substr_count($requestPath, '/');
	$numParent = $requestSlashes - $commonSlashes + 1;
	
	$basePath = ".";
	for($i = 0; $i < $numParent; $i++) {
		$basePath .= "/..";
	}
	
	return $basePath;
}

function timeString($time = -1) {
	global $config;
	
	if($time == -1) $time = time();
	return date($config['time_dateformat'], $time);
}

 //returns true=ok, false=notok
function one_mail($subject, $body, $to) {
	$config = $GLOBALS['config'];
	$from = filter_email($config['mail_username']);
	$subject = filter_name($subject);
	$to = filter_email($to);
	
	if(isset($config['mail_smtp']) && $config['mail_smtp']) {
		require_once "Mail.php";

		$host = $config['mail_smtp_host'];
		$port = $config['mail_smtp_port'];
		$username = $config['mail_username'];
		$password = $config['mail_password'];
		$headers = array ('From' => $from,
						  'To' => $to,
						  'Subject' => $subject,
						  'Content-Type' => 'text/html');
		$smtp = Mail::factory('smtp',
							  array ('host' => $host,
									 'port' => $port,
									 'auth' => true,
									 'username' => $username,
									 'password' => $password));

		$mail = $smtp->send($to, $headers, $body);

		if (PEAR::isError($mail)) {
			return false;
		} else {
			return true;
		}
	} else {
		$headers = "From: $from\r\n";
		$headers .= "To: $to\r\n";
		$headers .= "Content-type: text/html\r\n";
		return mail($to, $subject, $body, $headers);
	}
}

function validName($name) {
	//need a method
	return true;
}

function validPass($pass) {
	//need a method
	if(strlen($pass) < 6) {
		return false;
	}
	return true;
}

//returns true of false(use as boolean)
function validEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//changes date to work with two components and year, -1: present
function to_date($month, $year) {
	if($year == -1) {
		return -1;
	}
	return ($year * 100 + $month);
}

function print_date($number) {
	if ($number == -1) {
		return "Present";
	}
	$month = $number % 100;
	$year = ($number - $month)/100;
	if ($month == 0) {
		$name="";
	} else if ($month == 1) {
		$name="Jan ";
	} else if ($month == 2) {
		$name="Feb ";
	} else if ($month == 3) {
		$name="March ";
	} else if ($month == 4) {
		$name="April ";
	} else if ($month == 5) {
		$name="May ";
	} else if ($month == 6) {
		$name="June ";
	} else if ($month == 7) {
		$name="July ";
	} else if ($month == 8) {
		$name="Aug ";
	} else if ($month == 9) {
		$name="Sept ";
	} else if ($month == 10) {
		$name="Oct ";
	} else if ($month == 11) {
		$name="Nov ";
	} else if ($month == 12) {
		$name="Dec ";
	} else if ($month == 13) {
		$name="Spring ";
	} else if ($month == 14) {
		$name="Summer ";
	} else if ($month == 15) {
		$name="Fall ";
	} else if ($month == 16) {
		$name="Winter ";
	}
	
	return $name . $year;
}

function write_type($number) {
	if ($number == -1) {
		return "Education";
	} else if ($number == -2) {
		return "Experience";
	} else if ($number == -3) {
		return "Award";
	} else if ($number == -4) {
		return "No bullet";
	} else if ($number == -5) {
		return "Bulleted";
	} else {
		return false;
	}
}

//..............
//PAGE FUNCTIONS
//..............

function getStyle() {
	if(isset($_SESSION['style'])) {
		return stripAlphaNumeric($_SESSION['style']);
	} else {
		$config = $GLOBALS['config'];
		return stripAlphaNumeric($config['style']);
	}
}

function get_page($page, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	$timeString = timeString();
	
	//figure out what pages need to be displayed
	if(isset($_SESSION['user_id'])) {
		$page_display = $config['page_display_online'];
		$page_display_names = $config['page_display_names_online'];
	} else {
		$page_display = $config['page_display'];
		$page_display_names = $config['page_display_names'];
	}
	
	$basePath = basePath();
	
	$style = getStyle();
	$stylePath = $basePath . "/style/$style";
	$style_page_include = "$stylePath/page/$page.php";
	$page_include = $basePath . "/page/$page.php";
	
	//update page display to include .php
	for($i = 0; $i < count($page_display); $i++) {
		if(strpos($page_display[$i], '.') === FALSE) {
			$page_display[$i] .= '.php';
		}
	}
	
	if(file_exists("$stylePath/header.php")) {
		include("$stylePath/header.php");
	}
	
	if(file_exists($style_page_include)) {
		include($style_page_include);
	} else {
		include($page_include);
	}
	
	if(file_exists("$stylePath/footer.php")) {
		include("$stylePath/footer.php");
	}
}

function get_page_advanced($page, $context, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	$timeString = timeString();
	
	//figure out what pages need to be displayed
	if($context != "user") {
		$context = "user"; //this should never happen
	}
	
	$page_display = $config[$context . '_page_display'];
	$page_display_names = $config[$context . '_page_display_names'];
	
	$side_display = $config[$context . '_side_display'];
	$side_display_names = $config[$context . '_side_display_names'];
	
	//update page and side display to include .php
	for($i = 0; $i < count($side_display); $i++) {
		if(strpos($side_display[$i], '.') === FALSE) {
			$side_display[$i] .= '.php';
		}
	}
	
	for($i = 0; $i < count($page_display); $i++) {
		if(strpos($page_display[$i], '.') === FALSE) {
			$page_display[$i] .= '.php';
		}
	}
	
	$basePath = basePath();
	
	$style = getStyle();
	$stylePath = $basePath . "/instyle/$style";
	$style_page_include = "$stylePath/$context/$page.php";
	$page_include = $basePath . "/page/$context/$page.php";
	
	if(file_exists("$stylePath/header.php")) {
		include("$stylePath/header.php");
	}
	
	if(file_exists($style_page_include)) {
		include($style_page_include);
	} else {
		include($page_include);
	}
	
	if(file_exists("$stylePath/footer.php")) {
		include("$stylePath/footer.php");
	}
}


//this is called from pages to include another page
function page_advanced_include($target, $context, $args = array()) {
	//let pages use some variables
	extract($args);
	$config = $GLOBALS['config'];
	$timeString = timeString();
	
	if($context != "user") {
		$context = "user"; //this should never happen
	}
	
	$basePath = basePath();
	
	$style = getStyle();
	$stylePath = $basePath . "/instyle/$style";
	$style_page_include = "$stylePath/$context/$target.php";
	$page_include = $basePath . "/page/$context/$target.php";
	
	if(file_exists($style_page_include)) {
		include($style_page_include);
	} else {
		include($page_include);
	}
}

function style_function($name) {
	$basePath = basePath();
	$style = getStyle();
	$stylePath = $basePath . "/instyle/$style";
	
	if(file_exists($stylePath . "/include.php")) {
		include_once($stylePath . "/include.php");
		
		if(function_exists($style . "_" . $name)) {
			return $style . "_" . $name;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function page_exists($page) {
	return file_exists("page/" . $page . ".php");
}

//----------------------||
//----LOGIN FUNCTION----||
//----------------------||

//returns user_id, or FALSE on failure
function getUserId($email) {
	$email = escape($email);
	$result = mysql_query("SELECT id FROM users WHERE email = '$email'");
	
	if($row = mysql_fetch_array($result)) {
		return $row[0];
	} else {
		return FALSE;
	}
}

//returns 0: success, 1: name failed, 2: email failed, 3: invalid password, 4: passwords do not match, 5: email in use, 6: other error
function register_user($name, $email, $password, $confirm_pass) {
	if(!validName($name)) {
		return 1;
	}
	if(!validEmail(strtolower($email))) {
		return 2;
	}
	if(!validPass($password)) {
		return 3;
	}
	if(!strcompare($password, $confirm_pass)) {
		return 4;
	}
	$name = escape($name);
	$email = escape(strtolower($email));
	$pass = chash(escape($password));
	
	//verify that email is not in use
	$result = mysql_query("SELECT id FROM users WHERE email='" . $email . "'") or die(mysql_error());
	
	if(mysql_num_rows($result) > 0) {
		return 5;
	}
	
	$time = time();
	$auth = uid(20);
	$query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
	$success_flag = mysql_query($query) or die(mysql_error()) or die(mysql_error());
	
	/********************************************
		Send an email with 
			username
			description
			link to authorize (need a function)
			unsubscribe option
	********************************************/
	
	if(!$success_flag) {
		return 6;
	}
	return 0;
}

//returns true on success, or -1 for in correct password
function check_login($user_id, $password) {
	
	$result = mysql_query("SELECT password FROM users WHERE id='" . $user_id . "'");
	
	if($row = mysql_fetch_array($result)) {
		if(chash($password) == $row['password']) {
			return true;
		} else {
			return -1;
		}
	} else {
		return -1;
	}
}

//return 0: success, -1: email not valid, -2: invalid password
function login($email, $password) {
	$user_id = getUserId(strtolower($email));
	if($user_id === FALSE) {
		return -1;
	}
	if( check_login($user_id, $password) !== true ) {
		return -2; 
	}
	return 0;
}

//----------------------||
//----------------------||
//----------------------||

//returns array(name, email): success; -1: user does not exist
function get_userInfo($user_id) {
	$user_id = escape($user_id);
	$query = "SELECT name, email FROM users WHERE id=$user_id";
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array ($result) ){
		$info['name'] = $row[0];
		$info['email'] = $row[1];
		return $info;
	} else {
		return -1;
	}
}

//returns array of all pending transactions the user has to accept
//check is variable, to see requests that you have to accept, check = self, to see requests you submitted to others
function get_pending($user_id, $check="self") {
	$user_id = escape($user_id);
	
	if($check == "other") {
		$recv = "user_submit";
		$send = "user_view";
	} else {
		$send = "user_submit";
		$recv = "user_view";
	}
	
	$query = "SELECT id, $send, amount, description FROM purchases WHERE status=0 AND $recv='$user_id'";
	$result = mysql_query($query); 
	
	$pending = array();
	
	while($row = mysql_fetch_array($result)) {
		$id = $row[0];
		$user = $row[1];
		$amount = $row[2];
		$desc = $row[3];
		$pending[$id] = array($user, $amount, $desc);
	}
	
	return $pending;
}


//returns array of [user_id] => money_owed (negative implies you owe them)
function get_debt($user_id, $check = "owe") {
	$user_id = escape($user_id);
	
	if($check == "owe") {
		$query = "SELECT user_submit, amount FROM purchases WHERE status=1 AND user_view='$user_id'";
	} else {
		$query = "SELECT user_view, amount FROM purchases WHERE status=1 AND user_submit='$user_id'";
	}
	
	$result = mysql_query($query);
	
	$money = array();
	
	while($row = mysql_fetch_array($result) ) {
		if(array_key_exists('user_submit', $row)) {
			$comp_id = $row['user_submit']; 
		} else if(array_key_exists('user_view', $row)) {
			$comp_id = $row['user_view'];
		}
		if(array_key_exists(abs($comp_id), $money) ) {
			$money[abs($comp_id)] += $row['amount']*$comp_id/abs($comp_id);
		} else {
			$money[abs($comp_id)] = $row['amount']*$comp_id/abs($comp_id);
		}
	}
	
	return $money;
}

function add_purchase ($user_submit, $user_view, $amount, $desc) {
	$user_submit = escape($user_submit);
	$user_view = escape($user_view);
	$amount = escape($amount);
	$desc = escape($desc);
	
	$query = "INSERT INTO purchases (user_submit, user_view, amount, description, status) VALUES ('$user_submit', '$user_view', '$amount', '$desc', '0')";
	
	mysql_query($query);
}

function update_purchase ($id, $do) {
	$id = escape($id);	
	if ($do == "approve") {
		$val = 1;
	} else if ($do == "deny") {
		$val = -1;
	}	
	$query = "UPDATE purchases SET status='$val' WHERE id='$id'";
	mysql_query($query);
}

function get_group($user_id) {
	$user_id = escape($user_id);
	$group = array();
	
	
	$query = "SELECT user_one FROM groups WHERE user_two='$user_id' AND status='1'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		array_push($group, $row[0]);
	}
	
	$query = "SELECT user_two FROM groups WHERE user_one='$user_id' AND status='1'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		array_push($group, $row[0]);
	}
	
	return $group;
}

//returns 0: request sent; -1: person has not yet signed up; -2: request already sent; -3: person is in your group; -4: request recieved
function add_group($user_id, $user_email) {
	$user_id = escape($user_id);
	$other = getUserId($user_email);
	
	if($other === false) {
		return -1;
	}
	
	$query = "SELECT status FROM groups WHERE user_one='$user_id' AND user_two='$other'";
	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] == 0 ) {
			return -2;
		} else {
			return -3;
		}
	}
	
	$query = "SELECT status FROM groups WHERE user_two='$user_id' AND user_one='$other'";
	$result = mysql_query($query);
	if($row = mysql_fetch_array($result)) {
		if($row[0] == 0 ) {
			return -4;
		} else {
			return -3;
		}
	}
	
	$query = "INSERT INTO groups (user_one, user_two, status) VALUES ('$user_id', '$other', '0')";
	mysql_query($query);
	return 0;
}

function approve_group($user_id, $other) {
	$user_id = escape($user_id);
	$other = escape($other);
	
	$query = "UPDATE groups SET status=1 WHERE user_two='$user_id' AND user_one='$other'";
	mysql_query($query);
}

function deny_group($user_id, $other) {
	$user_id = escape($user_id);
	$other = escape($other);
	
	$query = "DELETE FROM groups WHERE user_two='$user_id' AND user_one='$other'";
	mysql_query($query);
}

function pending_group($user_id) {
	$user_id = escape($user_id);
	$query = "SELECT user_one FROM groups WHERE user_two='$user_id' AND status=0";
	$result = mysql_query($query);
	$pending = array();
	
	while($row = mysql_fetch_array($result)) {
		$id = $row[0];
		$pending[$id] = get_userInfo($id);
	}
	return $pending;
}
?>


