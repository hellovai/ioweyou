<form action="groups.php" method="post">
	<label>Email</label><input type="text" name="email" value=""><br />
	<button name="action" value="add">Add</button>
</form>

<ul>
<? foreach($pending as $id => $info) { 
	$name = $info['name'];
	$email = $info['email'];
?>
	<li><form action="groups.php" method="post"><input type="hidden" value="<?= $id ?>" name="id"><?= $name ?> ( <?= $email ?> )
	<button name="action" value="approve">Approve</button>
	<button name="action" value="deny">Deny</button>
	</form>
	</li>
<? } ?>
</ul>
