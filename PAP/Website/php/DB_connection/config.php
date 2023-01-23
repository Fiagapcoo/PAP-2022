<!--add a icon to the browser tab-->
<link rel="shortcut icon" href="conhece_portugal.php" type="image/x-icon">
<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "pap";

$conn = mysqli_connect($server, $user, $pass,$database);

if (!$conn) {
    die("<script>alert('A ligação falhou, tenta outravez.')</script>");
}

?>