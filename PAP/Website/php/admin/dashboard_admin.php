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
    <title>Dashboard de administrador</title>
</head>

<body>

    <?php




















    header("Refresh: 30");
    include "../DB_connection/config.php"; 

    $sql1 = "SELECT * FROM bug";
    $r1 = mysqli_query($conn, $sql1);
    $num_rows = mysqli_num_rows($r1);

    $sql2 = "SELECT * FROM users";
    $r2 = mysqli_query($conn, $sql2);
    $num_rows2 = mysqli_num_rows($r2);

    $sql3 = "SELECT * from avaliação where estrelas >2";
    $r3 = mysqli_query($conn, $sql3);
    $num_rows3 = mysqli_num_rows($r3);

    $sql4 = "SELECT * FROM percursos";
    $r4 = mysqli_query($conn, $sql4);
    $num_rows4 = mysqli_num_rows($r4);

    $sql5 = "SELECT * FROM local";
    $r5 = mysqli_query($conn, $sql5);
    $num_rows5 = mysqli_num_rows($r5);

    $sql6 = "SELECT * FROM estadia";
    $r6 = mysqli_query($conn, $sql6);
    $num_rows6 = mysqli_num_rows($r6);

    $sql7 = "SELECT * FROM restaurante";
    $r7 = mysqli_query($conn, $sql7);
    $num_rows7 = mysqli_num_rows($r7);


    ?>

            <table border="2">
                <tr>
                    <th>Numero de Bugs por Corrigir</th>
                    <th>Numero de Utilizadores registrados nesta plataforma</th>
                    <th>Numero Avaliações Positivas (+ de 3 estrelas)</th>
                </tr>




                    <tr>
                        <td><?php echo "$num_rows "; ?></td>
                        <td><?php echo "$num_rows2 "; ?></td>
                        <td><?php echo "$num_rows3 "; ?></td>
                    </tr>

            </table>
            <br><br><br>
            <table border="2">
                <tr>
                <th>Numero de Percursos existentes</th>
                <th>Numero de Locais existentes</th>
                <th>Numero de Locais para estadiar existentes</th>
                <th>Numero de restaurantes existentes</th>
                </tr>




                    <tr>
                        <td><?php echo "$num_rows4 "; ?></td>
                        <td><?php echo "$num_rows5 "; ?></td>
                        <td><?php echo "$num_rows6 "; ?></td>
                        <td><?php echo "$num_rows7 "; ?></td>
                    </tr>


            </table>


</body>

</html>