<form action="add.php" method="post">
	<label>Amount</label><input type="text" name="amount" value=""><br />
	<label>Description</label><textarea name="desc" ></textarea><br />
	<label>Split between</label><br />
	<input type="checkbox" value="-1" name="share[]" checked>Me<br />
	<?foreach($group as $user) {
		$inf = get_userInfo($user);
		?>
		<input type="checkbox" value="<?= $user ?>" name="share[]" ><?= $inf['name'] ?>, <?= $inf['email'] ?><br />
		<?
	} ?>
	<br />
	<button name="action" value="add">Add</button>
</form>
