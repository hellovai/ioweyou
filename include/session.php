<?php
session_start();

if (!isset($_SESSION['initiated'])) {
	session_regenerate_id();
	$_SESSION['initiated'] = true;
}

if(isset($_SESSION['HTTP_USER_AGENT'])) {
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
		session_unset();
	}
} else {
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
}

if(isset($_SESSION['site_name'])) {
	if($_SESSION['site_name'] != $config['site_name']) {
		session_unset();
	}
} else {
	$_SESSION['site_name'] = $config['site_name'];
}

if(isset($_REQUEST['style'])) {
	$_SESSION['style'] = preg_replace('/[^A-Za-z0-9_\-]/', '_', $_REQUEST['style']);
}

if(!isset($_SESSION['style']) || $_SESSION['style'] == "") {
	$_SESSION['style'] = preg_replace('/[^A-Za-z0-9_\-]/', '_', $config['style']);
}
?>
