<?php
$config['db_name'] = 'money';
$config['db_hostname'] = 'localhost';
$config['db_username'] = 'root';
$config['db_password'] = 'kurtiscarsch';

$config['site_name'] = "I Owe You";
$config['organization_name'] = "";
$config['site_address'] = "localhost/ioweyou"; //no trailing slash
$config['style']="basic";

//lock configuration
	//the time in seconds a user must wait before trying again; otherwise they get locked out (count not increased)
	$config['lock_time_initial'] = array('checkuser' => 5, 'checkadmin' => 5, 'register' => 20, 'root' => 10, 'peer' => 10, 'reset' => 60, 'reset_check' => 60);
	//the time that overloads last
	$config['lock_time_overload'] = array('checkuser' => 60*2, 'checkadmin' => 60*2, 'register' => 60*2, 'root' => 60*2, 'peer' => 60*2, 'reset' => 60*2, 'reset_check' => 60*2);
	//the number of tries a user has (that passes the lock_time_initial test) before being locked by overload
	$config['lock_count_overload'] = array('checkuser' => 12, 'checkadmin' => 12, 'register' => 12, 'root' => '12', 'peer' => 12, 'reset' => 12, 'reset_check' => 12);
	//if a previous lock found less than this many seconds ago, count++; otherwise old entry is replaced
	$config['lock_time_reset'] = 60;
	//max time to store locks in the database; this way we can clear old locks with one function
	$config['lock_time_max'] = 60*5;

//format used to display the current time
$config['time_dateformat'] = 'D, d M Y H:i:s';

//PAGE CONFIG
$config['page_display'] = array('index', 'register');
$config['page_display_names'] = array('Home', 'Register');


$config['page_display_online'] = array('index', 'add', 'groups' ,'logout');
$config['page_display_names_online'] = array('Home', 'Add Purchase', 'My Groups', 'Logout');
