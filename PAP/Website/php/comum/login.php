<link href="../../css/a.css" rel="stylesheet">
<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php

include '../side_nav_bar/navbar.php';
include '../DB_connection/config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$sql = "SELECT * FROM users WHERE username = '$username' ";
	$result = mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$admin = '55';
		$admin = $row['admin'];
		if ($admin == '55') {
			echo "<script>alert('Algo correu mal')</script>";
		} else if ($admin == '1') {
			$_SESSION['username'] = $row['username'];
			header("Location: ../admin/dashboard_admin.php");
		} else if ($admin == '0') {
			$_SESSION['username'] = $row['username'];
			header("../php/user/Estadia.php");
		} else if ($admin == '77') {
			echo "<script>alert('Aceda ao seu dispostivo movel e siga os paços sugeridos para ativar a sua conta');</script>";
		}
	}
}


if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);




	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$admin = '55';
		$admin = $row['admin'];
		if ($admin == '55') {
			echo "<script>alert('Algo correu mal')</script>";
		} else {
			if ($admin == '1') {
				$_SESSION['username'] = $row['username'];
				header("Location: ../admin/dashboard_admin.php");
			} else if ($admin == '0') {
				$_SESSION['username'] = $row['username'];
				header("Location: ../user/Estadia.php");
			} else if ($admin == '77') {
				echo "<script>alert('Aceda ao seu dispostivo movel e siga os paços sugeridos para ativar a sua conta');</script>";
			}
	} 
}else {
	echo "<script>alert('verifique o email e a password')</script>";
}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">



	<title>Formulario de login</title>
</head>

<body>
	<?php include 'navbar.php' ?>
	<div class="wrap-login100">
		<div class="container">
			<form action="" method="POST" class="login-email">
				<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
				<div class="input-group">
					<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
				</div>
				<div class="input-group">
					<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
				</div>
				<div class="input-group">
					<button name="submit" class="btn">Login</button>
				</div>
			</form>
		</div>
	</div>
</body>

</html>