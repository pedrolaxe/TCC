<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

if(isset($_GET['usuario_existe'])) {
  if($_GET['usuario_existe']) {
    echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Usuário Já Existe!</center></div>';
  }
}

if (isset($_POST['submit'])) {
    $idf        = anti_injection($_POST['id_user']);
    $login      = anti_injection($_POST['login']);
    $email      = anti_injection($_POST['email']);
    $senha      = anti_injection($_POST['senha']);
    $conf_senha = anti_injection($_POST['conf_senha']);

    if( empty($login) || empty($email) || empty($senha) || empty($conf_senha) ){
      $link_atual = LINK_SITE."admin/src/colaborador/edit_colaborador.php?id_colaborador=".$idf."";
      header("Location: ".$link_atual."&error=1");
    } elseif($senha != $conf_senha){
      $link_atual = LINK_SITE."admin/src/colaborador/edit_colaborador.php?id_colaborador=".$idf."";
      header("Location: ".$link_atual."&error=2");
    }

    if($senha == $conf_senha && !empty($login) && !empty($email) && !empty($senha) && !empty($conf_senha) ){
      alterar_colaborador($idf, $login, $email, $senha);
    } 
}

# SELECIONAR colaborador PARA SER ALTERADO
try {
  if (isset($_GET['id_colaborador'])) {
      $id_colaborador = $_GET['id_colaborador'];

      $query  = "SELECT * FROM colaborador WHERE id_colaborador = $id_colaborador";
      $result = $con->query($query);

      foreach($result as $row) {
          //$id    = $row['id_func'];
          $login = $row['login'];
          $email = $row['email'];
          $tipo  = $row['tipo'];
      }
  }
} catch(Expression $e) {}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sistema Restaurante</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php' ?>

  <!-- BOOTSTRAP CORE CSS -->
  <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- CSS -->
  <link href="<?= LINK_SITE; ?>assets/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= LINK_SITE; ?>assets/css/main.css" media="screen" />
</head>

<body class="text-center">
  <main class="form-signin">
    <form action="edit_colaborador.php" method="POST">

      <?php

      if(@$_GET['error']==1){
        echo '
        <div class="alert alert-primary" role="alert">
          Os dados não foram preenchidos corretamente!
        </div>';
      } elseif(@$_GET['error']==2){
        echo '
        <div class="alert alert-danger" role="alert">
          Senhas Diferentes!
        </div>
        <br>';
      }
        
      ?>

      <h1 style="font-size: 2.0em">Editar Funcionário</h1>
      <br>
      <label for="inputEmail" class="visually-hidden">Login</label>
      <input type="text" id="inputEmail" class="form-control" name="login" placeholder="Login" value="<?=$login; ?>" required autofocus>
      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
      <label for="inputPassword" class="visually-hidden">Confirmação Senha</label>
      <input type="password" id="inputPassword" class="form-control" name="conf_senha" placeholder="Confirmação de Senha" required>
      <label for="inputEmail" class="visually-hidden">Email</label>
      <input type="email" id="inputEmail" class="form-control" name="email" value="<?=$email; ?>" placeholder="Email" required>
      <input type="hidden" name="tipo" value="colaborador">
      <input type="hidden" name="id_user" value="<?=$id_colaborador; ?>">

      <br>

      <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Salvar</button>
    </form>
    <br>
    <a href="<?= LINK_SITE; ?>admin/src/colaborador/colaboradores.php"><button class="w-100 btn btn-lg btn-outline-secondary">Voltar</button></a>
  </main>
</body>
</html>