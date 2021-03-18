<?php

include 'includes/db.php';
include 'includes/functions.php';

$query  = "SELECT * FROM usuario";
$result = mysqli_query($con, $query);

// SE HOUVER ADMINISTRADOR REDIRECIONAR PARA O INDEX
if($result && mysqli_num_rows($result)) {
  header("Location: ".LINK_SITE."index.php");
} 


if(isset($_POST['submit'])) {

  cadastro_usuario();

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Sistema Restaurante</title>

    <?php include 'includes/head.php' ?>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    

    <!-- Bootstrap core CSS -->
<link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">


<!-- Custom styles for this template -->
<link href="assets/css/signin.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="assets/css/main.css" media="screen" />


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      button {
        border: 0 !important;
      }
    </style>

  </head>
  <body class="text-center">

    <?php include 'includes/head.php' ?>
    
<main class="form-signin">
  <form action="cadastro.php" method="POST">

    <h1 style="font-size: 64px">Cadastro Administrador</h1>

    <br>

    <!-- <i class="fas fa-10x fa-user-lock" style="color:#88BDBC"></i> -->

    <!-- <br><br> -->
    <!-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> -->
    <label for="inputEmail" class="visually-hidden">Login</label>
    <input type="text" id="inputEmail" class="form-control" name="login" placeholder="Login" required autofocus>
    <label for="inputPassword" class="visually-hidden">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
    <label for="inputPassword" class="visually-hidden">Confirmação Senha</label>
    <input type="password" id="inputPassword" class="form-control" name="conf_senha" placeholder="Confirmação de Senha" required>
    <label for="inputEmail" class="visually-hidden">Email</label>
    <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email" required>
    <input type="text" id="" class="form-control" name="tipo" placeholder="Email" value="administrador" hidden>

    <br>

    <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Entrar</button>
    <!-- <p class="mt-5 mb-3 text-muted">&copy; 2021</p> -->
  </form>
</main>


    
  </body>

</html>
