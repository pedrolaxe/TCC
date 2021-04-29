<?php

include '../../../includes/functions.php';

if (isset($_POST['submit'])) {
  cadastro_colaborador();
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
  <link href="<?=LINK_SITE;?>assets/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/main.css" media="screen" />
</head>

<body class="text-center">
  <main class="form-signin">
    <form action="add_colaborador.php" method="POST">

      <h1>Cadastro de Colaborador</h1>

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

      <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Criar</button>
    </form>
    <a href="../../painel.php"><button class="w-100 btn btn-lg btn-outline-secondary">Voltar</button></a>
  </main>
</body>
</html>