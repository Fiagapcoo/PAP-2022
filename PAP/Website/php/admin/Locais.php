<link href="../../css/sidebar.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
<link href="../../css/inputs.css" rel="stylesheet">
<link href="../../css/tables.css" rel="stylesheet">
<link href="../../css/fundo.css" rel="stylesheet">
<link href="../../css/a.css" rel="stylesheet">
<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php include '../side_nav_bar/side_admin.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="a">
        <form class='c' action="" method="POST" enctype="multipart/form-data">

            Região do local<select name="Reg_loc" required style="border: none; border-bottom: 4px solid lightblue;">
                <option value="erro" selected>Escolha uma opção</option>
                <option value="Norte">Norte</option>
                <option value="Centro">Centro</option>
                <option value="Sul">Sul</option>
            </select><br>
            Cidade do local:<input type="text" name="Cidade_loc" placeholder="Cidade do local" required><br>
            Nome do local:<input type="text" name="nome_loc" placeholder="Nome do local" required><br>
            Tipo de turismo a que se relaciona:<select name="Reg" required style="border: none; border-bottom: 4px solid lightblue;">
                <option value="erro" selected>Escolha uma opção</option>
                <option value="T_S">Turismo de saúde</option>
                <option value="T_SP">Turismo de sol e praia</option>
                <option value="T_A">Turismo de aventura</option>
                <option value="T_D">Turismo de desporto</option>
                <option value="T_R">Turismo Rural</option>
                <option value="T_E">Ecoturismo</option>
                <option value="T_C">Turismo Cultural</option>
            </select>
            <br>
            Latitude do Local:<input type="text" name='lat' placeholder="latitude do local" required><br>
            Longitude do Local:<input type="text" name='lon' placeholder="longitude do local" required><br><br>
            Imagem:<input type="file" id='fileToUpload' name="the_file" onchange="mostrarImagem()" accept=".png, .jpeg, .jpg" required /><br>
            <img src="" id="yourImgTag" class="b" style="display: none;"><br>
            <input type="submit" name='sub'>



        </form>
    </div>
</body>

</html>
<script>
    function mostrarImagem() {
        // obter a imagem e mostra-la 17-29

        var input = document.getElementById("fileToUpload");
        var nome = input.value;
        if ((nome.includes(".png") || (nome.includes(".jpeg")) || (nome.includes(".jpg")))) {
            var fReader = new FileReader();
            fReader.readAsDataURL(input.files[0]);
            fReader.onloadend = function(event) {
                var img = document.getElementById("yourImgTag");
                img.src = event.target.result;
            }

            document.getElementById("yourImgTag").style.display = "block";
        } else {
            document.getElementById("inputFile").value = "";
            alert("formato incorreto");
            retirar();
        }
    }
    //retira imagem do ecrã
    function retirar() {
        document.getElementById("yourImgTag").style = "display: none;";
    }
</script>
<?php
$currentDirectory = getcwd();
$uploadDirectory = "/Locais/";
$errors = [];
$fileExtensionsAllowed = ['jpeg','jpg','png'];
$fileName = $_FILES['the_file']['name'];
$fileSize = $_FILES['the_file']['size'];
$fileTmpName  = $_FILES['the_file']['tmp_name'];
$fileType = $_FILES['the_file']['type'];
$fileExtension = strtolower(end(explode('.',$fileName)));
$uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 
if (isset($_POST['sub'])) {
    if ($fileSize > 409600) {
        $errors[] = "Ficheiro excede o tamanho maximo (400 kb)";
      }
    
      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
      }
        if ($didUpload) {
            echo "<script>alert('Ficheiro carregado com sucesso');</script>";

    $link = mysqli_connect("localhost", "root", "", "pap");

    // Check connection


    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $nome_reg = $_POST['Reg_loc'];
    $tipo_T = $_POST['Reg'];
    $cidade = $_POST['Cidade_loc'];
    $nome = $_POST['nome_loc'];
    //acabar o Insert
    $sql1 = "INSERT INTO local (Regiao, Cidade, Lugares_T, ID_Loc, Tipo_T, Latitude _N, Longitude_O , img_loc) VALUES ('$nome_reg', '$cidade', '$nome', NULL, '$tipo_T', '$lat','$lon', '$fileName');";
    if (mysqli_query($link, $sql1)) {
?><script>  
            window.alert("O local foi adicionado com sucesso");
        </script><?php
                } else {
                    ?><script>
            window.alert("Algo correu mal");
        </script><?php
                }
            } else {
                foreach ($errors as $error) {
                    echo"<script>alert('". $error . "These are the errors');</script>";
                }
            }
           } 
?>