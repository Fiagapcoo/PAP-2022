<link href="../../css/sidebar.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
<link href="../../css/inputs.css" rel="stylesheet">
<link href="../../css/a.css" rel="stylesheet">
<link href="../../css/fundo.css" rel="stylesheet">
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
    <div class='a'>
        <form class='c' action="" method="POST" enctype="multipart/form-data">

            Nome Local estadia:<input type="text" name="est_n" placeholder="Nome do local de estadia" required><br>
            Cidade do Local de estadia:<input type="text" name="Cidade_est" placeholder="Cidade do local de estadia" required><br>
            Telefone Local Estadia:<input type="text" name="est_tel" placeholder="telefone local de estadia" required><br>
            Preço medio por noite:<input type="number" min=0 name="preco_med_noite" placeholder="Preço medio por noite" required>€<br>
            Latitude do Local de Estadia:<input type="text" name='lat' placeholder="latitude do local de estadia" size="24" required><br>
            Latitude do Local de Estadia:<input type="text" name='lon' placeholder="longitude do local de estadia" size="24" required><br><br>
            Imagem:<input type="file" id='fileToUpload' name="the_file" onchange="mostrarImagem()" accept=".png, .jpeg, .jpg" required /><br>
            <img src="" id="yourImgTag" class="b" style="display: none;"><br>
            <input type="submit" name='sub'><br>
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
    //retira imagem da tela
    function retirar() {
        document.getElementById("yourImgTag").style = "display: none;";
    }
</script>
<?php
$currentDirectory = getcwd();
$uploadDirectory = "/Estadia/";

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
    
        if ($didUpload) {
            echo "<script>alert('Ficheiro carregado com sucesso');</script>";
            $link = mysqli_connect("localhost", "root", "", "pap");   // estabelece ligação à base de dados
        
            $est_n = $_POST['est_n'];
            $cidade = $_POST['Cidade_est'];
            $est_tel = $_POST['est_tel'];
            $preco_med_noite = $_POST['preco_med_noite'];
            $lat = $_POST['lat'];
            $lon = $_POST['lon'];
            //acabar o Insert
            $sql1 = "INSERT INTO estadia (Nome_local, cidade_local, telefone_local, preco_med_noite, ID_local, Latitude_N, Longitude_O, img_est) VALUES ('$est_n', '$cidade', '$est_tel', '$preco_med_noite', NULL, '$lat', '$lon', '$fileName');";
            mysqli_query($link, $sql1);
            
        } else {
          echo "<script>alert('Algo correu mal, tente novamente!');</script>";
        }
      } else {
        foreach ($errors as $error) {
          echo "<script>alert('$error');</script>";
        }
      }
}
?>