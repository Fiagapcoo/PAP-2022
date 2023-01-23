<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php
include '../DB_connection/config.php';
include '../side_nav_bar/navbar.php';

error_reporting(0);

session_start();



if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$idade = $_POST['idade'];
	$pass = $_POST['password'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	if(strlen($pass)>=8){
		if ($password == $cpassword) {
				$sql = "SELECT * FROM users WHERE email='$email' OR username='$username'";
				$result = mysqli_query($conn, $sql);
				if (!$result->num_rows > 0) {
					$sql = "INSERT INTO users (id, username, email, password, idade, admin, fakereport, dist, autonomia) VALUES (NULL,'$username', '$email', '$password','$idade','77','0','0','0')";
					$result = mysqli_query($conn, $sql);
					if ($result) {
						echo "<script>alert('Foste registrado com sucesso.')</script>";
						$username = "";
						$email = "";
						$_POST['password'] = "";
						$_POST['cpassword'] = "";
					} else {
						echo "<script>alert('Ja estás registrado tenta fazer login.')</script>";
						header('location: ../comum/login.php');
					}
				} else {
					echo "<script>alert('Esse email ou nome de utiizador já estão a ser usados')</script>";
				}
			} else {
?>
				<script>
					window.alert("As passwords não coincidem.");
				</script>
<?php
			}
		} else {
			echo "<script>window.alert('A password tem de ter um minimo de 8 caracteres');</script>";
		}
	}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">



	<title>Formulario de registro</title>
</head>

<body>
	<?php include 'navbar.php' ?>

	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Nome de utilizador" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="number" placeholder="idade" min=11 max=210 name="idade" style="width: 190px;" value="<?php echo $idade; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Confirmar Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<input type="submit" name="submit" class="btn" value="Regista-te"></button>
			</div>
		</form>
	</div>
</body>

</html>