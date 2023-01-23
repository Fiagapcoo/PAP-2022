<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php

include "../DB_connection/config.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string

$del = mysqli_query($conn,"SELECT id from bug WHERE ID_B = '$id'"); // delete query

if($del)
{
    //obter o valor do ID do utilizador
    $tot = $del->fetch_array();
    $quantity = strval($tot[0]);

    $query = mysqli_query($conn, "SELECT fakereport from users where id = '$quantity'");

    $tot2 = $query ->fetch_array();
    $quantity2 = intval($tot2[0]);
    $quantity2=$quantity2 + 1;

    $updatde = mysqli_query($conn,"UPDATE users SET fakereport = '$quantity2' WHERE users.id = $quantity");
    $delete = mysqli_query($conn,"delete from bug where ID_B = '$id'"); // delete query

    if ($quantity2>2){
        $updatde = mysqli_query($conn,"UPDATE users SET admin = '51' WHERE users.id = $quantity");
    }

    header("location:bugs.php"); //redireciona para a pagina bos bugs
    exit;	



    
    
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>