<?php

include 'includes/db.php';

session_start();
$_SESSION['auth'] = false;
$_SESSION['auth_super'] = false;

$query  = "SELECT * FROM USUARIO";
$result = mysqli_query($con, $query);

// SE NÃO HOUVER ADMINISTRADOR REDIRECIONAR PARA O CADASTRO
if ($result && mysqli_num_rows($result)) {
// SE HOUVER ADMIN CONTINUA NA PAGINA

} else {
  header("Location: ".LINK_SITE."cadastro.php");
}


if (isset($_POST['submit'])) {

  $db_login = '';

  # email como login
  $login = mysqli_real_escape_string($con, $_POST['login']);
  $senha = mysqli_real_escape_string($con, $_POST['senha']);

  $senha = md5($senha);

  # Encript for INSERT PAGES
  // $hashFormat = "$2y$10$";
  // $salt = "iusesomecrazystrings22";

  // $hashF_and_salt = $hashFormat . $salt;

  // $password = crypt($password, $hashF_and_salt);


  $query = "SELECT * FROM usuario WHERE login = '{$login}'";

  $result = mysqli_query($con, $query);

  if (!$result) {
    die("Query Failed");
  } else {


    # Mostrar todas as colunas de toda a tabela
    while ($row = mysqli_fetch_array($result)) {

      $db_login = $row['login'];
      $db_senha = $row['senha'];
      $tipo     = $row['tipo'];
    }

    # VERIFICANDO SE BATE A SENHA DO DB COM A ESCRITA
    if ($login !== $db_login || $senha !== $db_senha) {
      echo '<div class="alert alert-primary" role="alert">
      Usuário ou senha Incorreto!
    </div>';
      // header("location: index.php");

    } else {

      $_SESSION['login'] = $db_login;
      if ($tipo == 'administrador') {
        $_SESSION['auth_super'] = true;
        header("location: ".LINK_SITE."admin/mesas.php");
      } else {
        $_SESSION['auth'] = true;
        header("location: ".LINK_SITE."mesas.php");
      }
      // header("location: add_user.php");

    }
  }
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
  <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
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
    <form action="index.php" method="POST">

      <h1 style="font-size: 64px">Login</h1>

      <br>

      <!-- <i class="fas fa-10x fa-user-lock" style="color:#88BDBC"></i> -->

      <!-- <br><br><br> -->
      <!-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> -->
      <label for="inputEmail" class="visually-hidden">Login</label>
      <input name="login" type="text" id="inputEmail" class="form-control" placeholder="Login" required autofocus>
      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input name="senha" type="password" id="inputPassword" class="form-control" placeholder="Senha" required>
      <!-- <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Lembrar
      </label>
    </div> -->
      <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>

      <br><br>
      <!-- <p class="mt-5 mb-3 text-muted">&copy; 2021</p> -->
    </form>
    <a href="forgot_pw.php"><button class="w-100 btn btn-lg btn-outline-secondary">Esqueci a Senha</button></a>
  </main>

  <script type="text/javascript">
    // ==UserScript==
    // @name        Wordswithfriends, Block javascript alerts
    // @match       http://wordswithfriends.net/*
    // @run-at      document-start
    // ==/UserScript==

    addJS_Node(null, null, overrideSelectNativeJS_Functions);

    function overrideSelectNativeJS_Functions() {
      window.alert = function alert(message) {
        console.log(message);
      }
    }

    function addJS_Node(text, s_URL, funcToRun) {
      var D = document;
      var scriptNode = D.createElement('script');
      scriptNode.type = "text/javascript";
      if (text) scriptNode.textContent = text;
      if (s_URL) scriptNode.src = s_URL;
      if (funcToRun) scriptNode.textContent = '(' + funcToRun.toString() + ')()';

      var targ = D.getElementsByTagName('head')[0] || D.body || D.documentElement;
      targ.appendChild(scriptNode);
    }
  </script>

</body>

</html>