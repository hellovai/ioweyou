<?php
include("include/common.php");
include("config.php");
include("include/db_connect.php");
include("include/session.php");

if(isset($_SESSION['user_id'])) {
	
	get_page("view_detail");
} else {
	get_page("index_login");
}
?>
