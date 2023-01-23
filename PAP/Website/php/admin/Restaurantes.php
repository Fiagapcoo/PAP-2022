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

        <form class="c" action="" method="POST" enctype="multipart/form-data">

            Nome Restaurante:<input type="text" name="Rest_n" placeholder="Nome do restaurante" required><br>
            Cidade do Restaurante:<input type="text" name="Cidade_res" placeholder="Cidade do local" required><br>
            Telefone Restaurante:<input type="text" name="res_tel" placeholder="telefone restaurante" required><br>
            Preço_medio_refeição:<input type="number" min=1 name="preco_med_refeicao" placeholder="Preço medio por refeição" required>€<br>
            Latitude do inicio do Local:<input type="text" name='lat' placeholder="Latitude do local" required><br>
            Longitude do inicio do Local:<input type="text" name='lon' placeholder="Longitude do local" required><br><br>
            Imagem:<input type="file" id='fileToUpload' name="the_file" onchange="mostrarImagem()" accept=".png, .jpeg, .jpg" required /><br>

            <img src="" id="yourImgTag" class="b" style="display: none;">

            <br><input type="submit" style="margin-bottom: 0%; margin-top: auto;" name='sub'><br>
    </div>

    </form>

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
$uploadDirectory = "/Restaurantes/";
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

    $Rest_n = $_POST['Rest_n'];
    $cidade = $_POST['Cidade_res'];
    $res_tel = $_POST['res_tel'];
    $preco_med_refeicao = $_POST['preco_med_refeicao'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    //acabar o Insert
    $sql1 = "INSERT INTO restaurante (Nome_res, cidade_res, telefone_res, preço_med_refeição, ID_res, Latitude_N, Longitude_O, img_res) VALUES ('$Rest_n', '$cidade', '$res_tel', '$preco_med_refeicao', NULL, '$lat', '$lon', '$fileName');";
    if (mysqli_query($link, $sql1)) {
?><script>
            window.alert("O local foi adicionado com sucesso");
        </script><?php
                }
            } else {
                foreach ($errors as $error) {
                    echo"<script>alert('". $error . "These are the errors');</script>";
                }
            }
            
        }
                    ?>
