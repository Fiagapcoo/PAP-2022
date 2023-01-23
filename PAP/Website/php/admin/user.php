<link href="style.css">
<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php include 'navbar_admin.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar admin</title>
</head>
<body>
    Username<input type="text" name = "username" placeholder="username" required>
    <br>
    Email<input type="email" name = "email" placeholder="email" required>
    <br>
    idade<input type="number" name = "idade" placeholder="idade" required min="1" max="140">
    <br>
    Admin <input type="checkbox" name = "admin">
    <br>
    Password<input type="password" name = "password" placeholder="password" id = "pass1" required>
    <br>
    Reapeat Password<input type="password" name = "password2" placeholder="password"id = "pass2" required>
    <br>
    <input type = "submit" name = "sub" onclick="a()">
</body>
</html>
<script>
    function a(){
        alert ("a");
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2.").value;
        alert(pass1);
        alert(pass2);
        if(pass1==pass2){
            alert("entra para mysql");
        }else{
            alert("não entra");
        }
    }
</script>
