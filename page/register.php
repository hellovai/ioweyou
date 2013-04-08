<h1>Registration</h1>

<p>Enter the information below to register a new account. If you have already registered an account, you can <a href="login.php">login</a>. Please do not register multiple accounts under the same name: if you forgot your password, you can <a href="reset.php">reset it</a>.</p><br><br>

<form action="register.php" method="post">
<table>
<tr>
	<td>Email</td>
	<td><input type="text" name="email"></td>
</tr>
<tr>
	<td>Full name<br />
		Enter your full name</td>
	<td><input type="text" name="name"></td>
</tr>
<tr>
	<td>Password</td>
	<td><input type="password" name="password"></td>
</tr>
<tr>
	<td>Confirm Password</td>
	<td><input type="password" name="password_confirm"></td>
</tr>

<tr>
	<td colspan="2">Acceptance of Use<br />
		By clicking register, I acknowledge all Terms and Conditions set by <?= $config['organization_name'] ?>.
	</td>
</tr>
<tr>
	<td colspan="2">
		<input type="submit" value="Register">
	</td>
</tr>
</table>
</form>
