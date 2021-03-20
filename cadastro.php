<?php

include 'includes/functions.php';

# SELECIONANDO USUARIOS PARA SABER SE EXISTE ALGUM ADMINISTRADOR
$query  = "SELECT * FROM usuario";
$result = mysqli_query($con, $query);

# SE HOUVER ADMINISTRADOR REDIRECIONAR PARA O INDEX
if($result && mysqli_num_rows($result)) {
  header("Location: ".LINK_SITE."index.php");
} 

# CADASTRO DO ADMIN
if(isset($_POST['submit'])) {
  cadastro_usuario();
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sistema Restaurante</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
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

  <!-- CSS -->
  <link href="assets/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css" media="screen" />
</head>

<body class="text-center">
    
  <main class="form-signin">
    <form action="cadastro.php" method="POST">

      <h1>Cadastro</h1>

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

      <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Entrar</button>
    </form>
  </main>
</body>
</html>
