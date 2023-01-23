<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php 
include '../DB_connection/config.php';
session_start();
session_destroy();
header("Location: ../comum/login.php");

?>