<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_SESSION['user_id'])) {
	$message = "";
	if(isset($_POST['action'])) {
		if($_POST['action'] == "add") {
			$shared = $_POST['share'];
			$amt = $_POST['amount'] / count($shared);
			foreach($shared as $id) {
				if($id != -1) {
					add_purchase($_SESSION['user_id'],$id, $amt, $_POST['desc']);
					$message = "Success!";
				}
			}
		}
	}
	$group = get_group($_SESSION['user_id']);
	get_page("add_purchase", array("group" => $group, "message" => $message));
} else {
	get_page("index_login");
}
?>
