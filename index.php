<?php

session_start();
include 'includes/functions.php';

# CONFIGURANDO AUTORIZAÇÃO DE ACESSO PARA 'FALSE'
$_SESSION['auth'] = false;
$_SESSION['auth_super'] = false;

# SELECIONANDO USUARIOS PARA SABER SE EXISTE ALGUM ADMINISTRADOR
$query  = "SELECT * FROM USUARIO";
$result = mysqli_query($con, $query);

# SE NÃO HOUVER ADMINISTRADOR REDIRECIONAR PARA O CADASTRO
if ($result && mysqli_num_rows($result)) {

# SE HOUVER ADMIN CONTINUA NA PAGINA
} else {
  header("Location: ".LINK_SITE."cadastro.php");
}

# TENTATIVA DE LOGIN PARA A PAGINA DO ADMIN OU FUNCIONARIO
if (isset($_POST['submit'])) {
  logar();
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Sistema Restaurante</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include 'includes/head.php' ?>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/signin.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css" media="screen" />
</head>

<body class="text-center">
  <main class="form-signin">
    <form action="index.php" method="POST">
      <h1>Login</h1>

      <label for="inputEmail" class="visually-hidden">Login</label>
      <input name="login" type="text" id="inputEmail" class="form-control" placeholder="Login" required autofocus>
      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input name="senha" type="password" id="inputPassword" class="form-control" placeholder="Senha" required>

      <button name="submit" class="w-100 btn btn-lg btn-outline-primary" type="submit">Entrar</button>
    </form>

    <a href="forgot_pw.php"><button class="w-100 btn btn-lg btn-outline-secondary">Recuperar Senha</button></a>
  </main>
</body>
</html>