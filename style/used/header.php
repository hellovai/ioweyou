<html>
<head>
<title><?= $config['site_name'] ?></title>
<?
if(isset($redirect)) {
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=' . $redirect . '">';	
}
?>

<link href="<?= $stylePath ?>/css/main.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="message">
<?
if(isset($error)) {
	echo "<div id=\"error\"><p>$error</p></div>";
} else if(isset($success)) {
	echo "<div id=\"error\"><p>$success</p></div>";
} else if(isset($warn)) {
	echo "<div id=\"error\"><p>$warn</p></div>";
} else if(isset($info)) {
	echo "<div id=\"error\"><p>$info</p></div>";
}
?>
</div>
<h1>Welcome to <?= $config['site_name']?>!</h1>
<p>Menu</p>
<ul>
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<li><a href=' . $page_display[$i] . '>' . $page_display_names[$i] . '</a></li>';
}
?>
</ul>
<hr />
<?
if(isset($message) ) {
	if($message != "") {
		echo $message . "<br />";
	}
}
?>
