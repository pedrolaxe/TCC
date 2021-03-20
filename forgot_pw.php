<?php 

session_start();
include 'includes/functions.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sistema Restaurante</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include 'includes/head.php' ?>
    
  <!-- CSS -->
  <link href="<?php LINK_SITE ?>assets/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php LINK_SITE ?>assets/css/main.css" media="screen" />
</head>

<body class="text-center">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include 'includes/head.php' ?>
    
  <main class="form-signin">
    <form action="index.php" method="POST">

      <h1>Recuperar Senha</h1>
      <br>

      <label for="inputEmail" class="visually-hidden">Email</label>
      <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>    
      <br>
      <button name="submit" class="w-100 btn btn-lg btn-outline-primary" type="submit">Enviar</button>
    </form>
    <a href="<?=LINK_SITE;?>"><button class="w-100 btn btn-lg btn-outline-secondary">Voltar</button></a>
  </main>   
</body>
</html>
