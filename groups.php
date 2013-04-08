<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_SESSION['user_id'])) {
	$message = "";
	if(isset($_POST['action'])) {
		if ($_POST['action'] == "add") {
			$val = add_group($_SESSION['user_id'], $_POST['email']);
			if($val == 0) {
				$message = "Success!";
			} else if($val == -1) {
				$message = "This person has not yet signed up! Invite them!";
			} else if($val == -2) {
				$message = "You have already sent a request to this person!";
			} else if($val == -3) {
				$message = "You already have this person added!";
			} else if($val == -4) {
				$message = "You have a request from this person!";
			}
		} else if ($_POST['action'] == "approve") {
			approve_group($_SESSION['user_id'], $_POST['id']);
		} else if ($_POST['action'] == "deny") {
			deny_group($_SESSION['user_id'], $_POST['id']);
		}
	}
	
	$pending = pending_group($_SESSION['user_id']);
	
	get_page("add_group", array("message" => $message, "pending" => $pending));
} else {
	get_page("index_login");
}
?>
