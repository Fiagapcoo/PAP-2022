<link href="../../css/tables.css" rel = "stylesheet">
<link href="../../css/style.css" rel = "stylesheet">
<link href="../../css/sidebar.css" rel = "stylesheet">
<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php
include "../side_nav_bar/side_admin.php";
include "../DB_connection/config.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string
$query3 = mysqli_query($conn, "SELECT desc_bug FROM bug WHERE ID_B = '$id'"); // select query


$desc = $query3->fetch_array();
$desc2 = strval($desc[0]);


$query4 = mysqli_query($conn, "SELECT data FROM bug WHERE ID_B = '$id'"); // select query


$desc3 = $query4->fetch_array();
$desc4 = strval($desc3[0]);
?>
<table border="2">

    <tr>
        <th>Descrição do bug</th>
        <th>Data do report</th>
    </tr>
    <tr>
        <td><?php echo "$desc2"; ?></td>
        <td><?php echo "$desc4"; ?></td>
    </tr>
</table>
