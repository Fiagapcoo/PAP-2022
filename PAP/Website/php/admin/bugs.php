<link href="../../css/sidebar.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
<link href="../../css/inputs.css" rel="stylesheet">
<link href="../../css/tables.css" rel="stylesheet">
<link href="../../css/hbutton.css" rel="stylesheet">
<link href="../../css/fundo.css" rel="stylesheet">
<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php include '../side_nav_bar/side_admin.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bug</title>
</head>

<body>

    <?php




















    header("Refresh: 30");
    include "../DB_connection/config.php"; // Using database connection file here

    $records = mysqli_query($conn, "select * from bug"); // fetch data from database

    if (mysqli_num_rows($records) == 0) {

        echo "<h1 colspan='6' style='text-align:center;'>Não existem bugs reportados!</h1>";
    } else {
    ?>
        <div class=c>
            <table border="2">
                <tr>
                    <th>Descrição Bug</th>
                    <th>Detalhes</th>
                    <th>Fake Report</th>
                    <th>Corrigido</th>
                </tr>
                <?php
                while ($data = mysqli_fetch_array($records)) {
                ?>



                    <tr>
                        <td><?php echo $data['desc_bug']; ?></td>
                        <td><a class="a" href="detalhes.php?id=<?php echo $data['ID_B']; ?>">Detalhes</a></td>
                        <td><a class="a" href="fakereport.php?id=<?php echo $data['ID_B']; ?>">Report</a></td>
                        <td><a class="a" href="delete.php?id=<?php echo $data['ID_B']; ?>">Já Corrigido</a></td>
                    </tr>

            <?php
                }
            }
            ?>
            </table>
        </div>

</body>

</html>