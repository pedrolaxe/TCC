<?php

session_start();
include '../../../includes/functions.php';

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

isset($_GET['login'])? $login = $_GET['login'] : $login = '';
isset($_GET['email'])? $email = $_GET['email'] : $email = '';
isset($_GET['nome'])?  $nome  = $_GET['nome']  : $nome  = '';
isset($_GET['cpf'])?   $cpf   = $_GET['cpf']   : $cpf   = '';
isset($_GET['rg'])?    $rg    = $_GET['rg']    : $rg    = '';
isset($_GET['tel'])?   $tel   = $_GET['tel']   : $tel   = '';

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

        if (isset($_GET['cpfValido']) && $_GET['cpfValido'] == 'false') {
          echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Insira um CPF válido</center></div>';
        }

        if (isset($_GET['senhaDif']) && $_GET['senhaDif'] == 'false') {
          echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert">Senhas Diferentes!</div>';
        }

        if (isset($_GET['usuario']) && $_GET['usuario'] == 'true') {
          echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Usuário Já Existe!</center></div>';
        }

      ?>

      <h1>Cadastro de Colaborador</h1>

      <label for="inputEmail" class="visually-hidden">Login</label>
      <input type="text" id="inputEmail" class="form-control" name="login" placeholder="Login" autocomplete="off" value="<?php echo $login ?>" required autofocus>
      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
      <label for="inputPassword" class="visually-hidden">Confirmação Senha</label>
      <input type="password" id="inputPassword" class="form-control" name="conf_senha" placeholder="Confirmação de Senha" required>
      <label for="inputEmail" class="visually-hidden">Email</label>
      <input type="email" id="inputEmail" class="form-control" name="email" autocomplete="off" placeholder="Email" value="<?php echo $email ?>" required>

      <br>

      <input type="text" id="" class="form-control" name="nome" value="<?php echo $nome ?>" placeholder="Nome" autocomplete="off" required>      
      <input type="text" id="cpf" class="form-control" name="cpf" value="<?php echo $cpf ?>" placeholder="CPF" autocomplete="off" required>
      <input type="text" id="text" class="form-control" name="rg" value="<?php echo $rg ?>" placeholder="RG" autocomplete="off">
      <input type="text" id="phone" class="form-control" name="telefone" value="<?php echo $tel ?>" placeholder="Telefone" autocomplete="off">




      <input type="text" class="form-control" name="tipo" value="colaborador" hidden>

      <br>

      <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Criar</button>
    </form>
    <br>
    <a href="../../painel.php"><button class="w-100 btn btn-lg btn-outline">Voltar</button></a>
    <br><br>
  </main>
</body>

<!-- Mascara -->
<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/jquery.maskedinput-1.1.4.pack.js"/></script>

<script type="text/javascript">

  $(document).ready(function(){
    $("#cpf").mask("999.999.999-99");
  });

  $(document).ready(function(){
    $("#phone").mask("(99) 99999-9999");
  });

  // $(document).ready(function(){
  //   $("#rg").mask("99.999.999-9");
  // });

</script>


</html>