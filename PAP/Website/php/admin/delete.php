<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php

include "../DB_connection/config.php";

$id = $_GET['id'];

$del = mysqli_query($conn, "delete from bug where ID_B = '$id'");

if ($del) {
    header("location:bugs.php"); //redireciona para a tablea dos bugs
    exit;
} else {
?>
    <script>
        window.alert("Erro ao eliminar o Bug");
    </script>
<?php
    header("location:bugs.php");
    exit;
}
?>