<?php
include '../../../includes/functions.php';

if (isset($_POST['submit'])) {
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

  <?php include '../../../includes/head.php' ?>
  <!-- Bootstrap core CSS -->
  <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="<?=LINK_SITE;?>assets/css/signin.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/main.css" media="screen" />


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
  </style>

</head>

<body class="text-center">

  <?php include '../../../includes/head.php' ?>

  <main class="form-signin">
    <form action="add_funcionario.php" method="POST">

      <h1 style="font-size: 2.5em">Cadastro Funcionário</h1>

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
      <input type="text" id="" class="form-control" name="tipo" placeholder="Email" value="funcionario" hidden>

      <br>

      <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Criar</button>
      <!-- <p class="mt-5 mb-3 text-muted">&copy; 2021</p> -->
    </form>
    <br>
    <a href="../../config.php"><button class="w-100 btn btn-lg btn-outline-secondary">Voltar</button></a>
  </main>



</body>

</html>