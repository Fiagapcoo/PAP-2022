<link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
<?php
include '../side_nav_bar/navbar.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicação</title>
</head>
<body>

<section class="post-container">
  <span>
  <h2>Login</h2>
  <p>Este é o formulário utilizado para o utilizador entrar na aplicação. Quando ele efetua o login é escrito no ficheiro TXT o seu nome de utilizador afim de conseguir perceber <br> qual o utilizador que está na aplicação, para perceber a sua autonomia, permissões, etc.</p>
</span>

  <img src="img_app/Login.png" class="imgTag" />
</section>
<br><br><br>
<section class="post-container">
  <span>
  <h2>Registo</h2>
  <p>Este é o formulário para o utilizador se registar na plataforma. Quando o formulário é devidamente preenchido, o utilizador é inserido, mas têm que verificar o seu email a <br>fim< de conseguirutilizar as funcionalidades da aplicação </p>
</span>

  <img src="img_app/register.png" class="imgTag" />
</section>
<br><br><br>
<section class="post-container">
  <span>
  <h2>Recuperar Password</h2>
  <p>Quando o utilizador se esquece da password, existe um mecanismo para ele a alterar. O utilizador insere o seu nome de utilizador, e a palavra passe que deseja. <br>Posteriormente é lhe enviado um email com um codigo, para verificar que o utilizador que quer alterar a pass é o dono da conta em questão</p>
</span>

  <img src="img_app/esquecer_pass.png" class="imgTag1" />
</section>
<br><br><br>
<section class="post-container">
  <span>
  <h2>Verificação de email</h2>
  <p>Quando o utilizador se regista., temos que saber se o email que está a usar lhe pertence, logo enviamos um email para ele com um codigo para consegiurmos ativar a conta<br> que ele vai utilizar futuramente.</p>
</span>

  <img src="img_app/verificação email.png" class="imgTag" />
</section>
<br><br><br>
<section class="post-container">
  <span>
  <h2>Aplicação</h2>
  <p>Neste campo decidimos o local onde queremos ir de bicicleta. Se for uma bicicleta não eletrica vai dar o percurso mais rapido, senão, é dado o percurso que passa pelos postos<br> de abasteciemnto, para que não fique sem energia a meio da viagem</p>
</span>

  <img src="img_app/app.png" class="imgTag" />
</section>
<br><br><br>
<section class="post-container">
  <span>
  <p>Aqui estão presentes os locais que o utilizador vai passar até conseguir chegar ao local que escolheu, neste caso, Viseu</p>
</span>

  <img src="img_app/locais_para_ir_a_destino.png" class="imgTag2" />
</section>
<br><br><br>
<section class="post-container">
  <span>

  <p><br> <br><br>
    Aqui está presente o percurso com as paragens para abastecimento que o utilizador tem que fazer para chegar ao destino</p>
</span>

  <img src="img_app/percurso_destino.png" class="imgTag" />
</section>
</body>
</html>
<style>
section {
  display: flex
}
.imgTag{
    margin-left: 10%;
    width: auto;
    height: auto;
}
.imgTag1{
    margin-left: 13%;
    width: auto;
    height: auto;
}
.imgTag2{
    margin-left: 25%;
    width: auto;
    height: auto;
}
</style>