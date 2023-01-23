<?php include '../side_nav_bar/side_admin.php' ?>
<?php include '../DB_connection/config.php'; ?>
<link href="../../css/style.css" rel="stylesheet">
<link href="../../css/inputs.css" rel="stylesheet">
<link href="../../css/fundo.css" rel="stylesheet">
<link href="../../css/sidebar.css" rel="stylesheet">
<link href="../../css/a.css" rel="stylesheet">
<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Administrador</title>
</head>

<body>
    <form action="" method="POST">
        <div class = "a">
            Username:<input type='text' name="username" required placeholder="username"><br>
            Email <input type='email' name="email" required placeholder="email"> <br>
            Password<input type='password' name="pass1" required placeholder="password"><br>
            Repetir Password<input type='password' name="pass2" required placeholder="Repetir password"><br>
            Idade <input type='number' min=4 max=300 name='idade' required placeholder="idade"><br>
            Permissão de administrador<select name="perm_admin" required style="border: none; border-bottom: 4px solid lightblue;">
                <option value="erro" selected>Escolha uma opção</option>
                <option value="Admin">Administrador</option>
                <option value="User">Utilizador</option>
            </select><br>
            <input type="submit" name='sub'>
        </div>


    </form>
</body>

</html>
<?php









if (isset($_POST['sub'])) {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    echo "$pass1 && $pass2";

    if ($pass1 == $pass2) {

        $pass2 = md5($_POST['pass2']);

        $username = $_POST['username'];
        echo "$username  ";
        $email = $_POST['email'];
        echo "$email  ";
        $idade = $_POST['idade'];
        echo "$idade  ";
        $admin = $_POST['perm_admin'];
        echo "$admin  ";

        if ($admin == 'erro') {
?> <script>
                window.alert("Escolha a permissão de utilizador");
            </script> <?php
                    } else if ($admin == 'Admin') {
                        $adm = '1';
                    } else if ($admin == 'User') {
                        $adm = '0';
                    }
                    echo "$adm  ";


                    $sql = "INSERT INTO users (id, username, email, password, idade, admin, fakereport) VALUES (NULL, '$username', '$email', '$pass2', '$idade', '$adm,', '0')";

                    if (mysqli_query($conn, $sql)) {
                        ?>
            <script>
                window.alert("O utilizador foi inserido");
            </script>
        <?php
                    } else {
        ?>
            <script>
                window.alert("O utilizador não foi inserido");
            </script>
        <?php
                    }
                } else {
        ?> <script>
            window.alert("As palavaras passes não coincidem")
        </script> <?php
                }
            }
                    ?>