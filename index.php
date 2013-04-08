<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_SESSION['user_id'])) {
	if(isset($_POST['action'])) {
		if($_POST['action'] == "approve" || $_POST['action'] == "deny") {
			update_purchase($_POST['id'], $_POST['action']);
		}
	}
	
	$userInfo = get_userInfo($_SESSION['user_id']);
	$debt = get_debt($_SESSION['user_id']);
	$due = get_debt($_SESSION['user_id'], "other");
	$pending = get_pending($_SESSION['user_id']);
	
	$comm_key = array_intersect(array_keys($debt), array_keys($due));
	
	foreach($comm_key as $user_iden) {
		$val = $debt[$user_iden] - $due[$user_iden];
		if($val > 0) {
			$debt[$user_iden] = $val;
			unset($due[$user_iden]);
		} else if ($val < 0) {
			$due[$user_iden] = -1*$val;
			unset($debt[$user_iden]);
		} else {
			unset($due[$user_iden]);
			unset($debt[$user_iden]);
		}
	}
	
	
	get_page("index", array("name" => $userInfo['name'], "due" => $due, "debt" => $debt, "pending" => $pending));
} else if(isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
	$result = login($_REQUEST['email'], $_REQUEST['password']);
	
	if($result == 0) {
		$_SESSION['user_id'] = getUserId($_REQUEST['email']);
		$userInfo = get_userInfo($_SESSION['user_id']);
		get_page("index", array("name" => $userInfo['name'], "redirect" => "index.php"));
	} else {
		get_page("index_login", array("error" => "Error: Invalid Information!"));
	}
} else {
	get_page("index_login");
}
?>
