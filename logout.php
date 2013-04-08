<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_SESSION['user_id'])) {
	session_unset();
	get_page("index_login");
} else {
	get_page("index_login");
}
?>
