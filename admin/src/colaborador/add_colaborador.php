<?php

session_start();
include '../../../includes/functions.php';

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sistema Restaurante</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php' ?>

  <!-- Bootstrap core CSS -->
  <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- CSS -->
  <link href="<?=LINK_SITE;?>assets/css/form.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/main.css" media="screen" />


  <style type="text/css">
    
         .btn-outline {
    border: .2em solid black !important;
  }

  .btn-outline:hover {
    border: .2em solid white;
    background-color: black;
    color: white;
  }

  </style>

</head>

<body class="text-center">

  <?php include '../../../includes/header_admin.php'; ?>

  <main class="form-signin">
    <form action="add_colaborador.php" method="POST">

      <?php 

        if (isset($_POST['submit'])) {
          cadastro_colaborador();
        } 
        
      ?>

      <h1>Cadastro de Colaborador</h1>

      <label for="inputEmail" class="visually-hidden">Login</label>
      <input type="text" id="inputEmail" class="form-control" name="login" placeholder="Login" autocomplete="off" required autofocus>
      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
      <label for="inputPassword" class="visually-hidden">Confirmação Senha</label>
      <input type="password" id="inputPassword" class="form-control" name="conf_senha" placeholder="Confirmação de Senha" required>
      <label for="inputEmail" class="visually-hidden">Email</label>
      <input type="email" id="inputEmail" class="form-control" name="email" autocomplete="off" placeholder="Email" required>

      <br>

      <input type="text" id="" class="form-control" name="nome" placeholder="Nome" autocomplete="off" required>      
      <input type="text" id="" class="form-control" name="cpf" placeholder="CPF" autocomplete="off">
      <input type="text" id="" class="form-control" name="rg" placeholder="RG" autocomplete="off">
      <input type="text" id="" class="form-control" name="telefone" placeholder="Telefone" autocomplete="off">




      <input type="text" class="form-control" name="tipo" value="colaborador" hidden>

      <br>

      <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Criar</button>
    </form>
    <br>
    <a href="../../painel.php"><button class="w-100 btn btn-lg btn-outline">Voltar</button></a>
    <br><br>
  </main>
</body>
</html>