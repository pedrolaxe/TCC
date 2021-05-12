<?php

session_start();
include 'includes/functions.php';
global $con;

# CONFIGURANDO AUTORIZAÇÃO DE ACESSO PARA 'FALSE'
$_SESSION['auth'] = false;
$_SESSION['auth_super'] = false;

# SELECIONANDO COLABORADORES PARA SABER SE EXISTE ALGUM ADMINISTRADOR
$query  = "SELECT * FROM COLABORADOR WHERE tipo='administrador'";

$q = $con->query($query);
if($q->rowCount() == 0){
  header("Location: " . LINK_SITE . "cadastro.php");
}
$q = $con->prepare($query);
$q->execute();
if($q->rowCount() == 0){
 header("Location: " . LINK_SITE . "cadastro.php");

}

# TENTATIVA DE LOGIN PARA A PAGINA DO ADMIN OU FUNCIONARIO
if (isset($_POST['submit'])) {
  $db_login = '';

  # LOGIN E SENHA
  $login = $_POST['login'];
  $senha = $_POST['senha'];

  # MELHORAR A SEGURANÇA ?
  $senha = md5($senha);

  $query = "SELECT * FROM COLABORADOR WHERE login = '{$login}'";
  $result = $con->query($query);

  if (!$result) {
    die("Query Failed");
  } else {

    # MOSTRAR TODAS AS COLUNAS DE TODA A TABELA
    foreach($result as $row) {
      $user_id  = $row['id_colaborador'];
      $db_login = $row['login'];
      $db_senha = $row['senha'];
      $tipo     = $row['tipo'];
    }

    # VERIFICANDO SE LOGIN E SENHA ESTÃO IGUAIS AS DO DB
    if ($login !== $db_login || $senha !== $db_senha) {
      echo '
      <div class="alert alert-primary" role="alert">
        Usuário ou senha Incorreto!
      </div>';

      # DANDO PERMISSÃO E REDIRECIONANDO O USUÁRIO
    } else {
      $_SESSION['user_id']         = $user_id;
      $_SESSION['login']        = $db_login;
      $_SESSION['auth_super']   = true;
      $_SESSION['tipo_usuario'] = $tipo;

      header("location: " . LINK_SITE . "admin/comandas.php?user_id=" . $user_id);
      
    }
  }
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

  <style type="text/css">

    .btn-outline-primary {
    border: .2em solid;
  }

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
  <main class="form-signin">
    <form action="index.php" method="POST">
      <h1>Login</h1>

      <label for="inputEmail" class="visually-hidden">Login</label>
      <input name="login" type="text" id="inputEmail" class="form-control" placeholder="Login" autocomplete="off" required autofocus>
      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input name="senha" type="password" id="inputPassword" class="form-control" placeholder="Senha" required>

      <button name="submit" class="w-100 btn btn-lg btn-outline-primary" type="submit">Entrar</button>
    </form>

    <a href="forgot_pw.php"><button class="w-100 btn btn-lg btn-outline">Recuperar Senha</button></a>
  </main>
</body>

</html>