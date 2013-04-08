<h1>Welcome <?= $name ?></h1>

<div>
<h2>Collect</h2>
	<ul>
	<? foreach($due as $id => $info) {
		$name = get_userInfo($id);
		$name = $name['name'];
		$amt = $info;
		?>
		<li><a href="view_detail.php?id=<?= $id ?>"><?= $name ?> $<span><?= money_format('%i', $amt) ?></span></a></li>
		<?
	}?>
	</ul>
</div>

<div>
<h2>Owe</h2>
	<ul>
	<? foreach($debt as $id => $info) {
		$name = get_userInfo($id);
		$name = $name['name'];
		$amt = $info;
		?>
		<li><a href="view_detail.php?id=<?= $id ?>"><?= $name ?> $<span><?= money_format('%i', $amt) ?></span></a></li>
		<?
	}?>
	</ul>
</div>
<div>
<h2>Pending</h2>
	<ul>
	<? foreach($pending as $id => $info) {
		$name = get_userInfo($info[0]);
		$name = $name['name'];
		$amt = $info[1];
		?>
		<li><form action="index.php" method="post"><input type="hidden" name="id" value="<?= $id ?>" ><?= $name ?> <span>$<?= money_format('%i', $amt) ?></span><button name="action" value="deny">Deny</button><button name="action" value="approve">Approve</button></form></li>
		<?
	}?>
	</ul>
</div>
