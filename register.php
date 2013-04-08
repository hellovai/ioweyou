<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_SESSION['user_id'])) {
	$debt = get_debt($_SESSION['user_id']);
	$pending = get_pending($_SESSION['user_id']);
	get_page("index", array("debt" => $debt, "pending" => $pending));
} else if(isset($_POST['email']) && isset($_POST['name'])) {
	$result = register_user($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirm']);
	if($result == 0) {
		get_page("message", array("title" => "Registration successful", "message" => "Your account has been created."));
	} else if($result == 1) {
		get_page("register", array("error" => "Error: Your name is invalid."));
	} else if($result == 2) {
		get_page("register", array("error" => "Error: Your email is invalid."));
	} else if($result == 3) {
		get_page("register", array("error" => "Error: Your password is invalid."));
	} else if($result == 4) {
		get_page("register", array("error" => "Error: Passwords do not match."));
	} else if($result == 5) {
		get_page("register", array("error" => "Error: Email in use."));
	} else {
		get_page("register", array("error" => "Internal Error($result)! Try again."));
	}
} else {
	get_page("register", array());
}

?>
