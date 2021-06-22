<?php

include 'includes/functions.php';

# SE HOUVER ADMINISTRADOR REDIRECIONAR PARA O INDEX
$query = "SELECT * FROM colaborador WHERE tipo='administrador'";
$q = $con->prepare($query);
$q->execute();
if ($q->rowCount() > 0) {
  header("Location: " . LINK_SITE . "index.php");
}
# CADASTRO DO ADMIN
if(isset($_POST['submit'])) {
  cadastro_colaborador();
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
  <?php include 'includes/head.php' ?>

  <!-- Bootstrap core CSS -->
  <link href="<?=LINK_SITE;?>css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS -->
  <link href="assets/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css" media="screen" />
</head>

<body class="text-center">
  <main class="form-signin">
    <form action="cadastro.php" method="POST">

      <?php

      if (isset($_GET['cpfValido']) && $_GET['cpfValido'] == 'false') {
        echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Insira um CPF válido</center></div>';
      }

      if (isset($_GET['senhaDif']) && $_GET['senhaDif'] == 'false') {
        echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert">Senhas Diferentes!</div>';
      }

      ?>

      <h1>Cadastro Gerente</h1>

      <label for="inputEmail" class="visually-hidden">Login</label>
      <input type="text" id="inputEmail" class="form-control" name="login" value="<?php echo $login ?>" placeholder="Login" autocomplete="off" required autofocus>

      <label for="inputPassword" class="visually-hidden">Senha</label>
      <input type="password" id="inputPassword" class="form-control" name="senha" placeholder="Senha" required>

      <label for="inputPassword" class="visually-hidden">Confirmação Senha</label>
      <input type="password" id="inputPassword" class="form-control" name="conf_senha" placeholder="Confirmação de Senha" required>

      <label for="inputEmail" class="visually-hidden">Email</label>
      <input type="email" id="inputEmail" class="form-control" name="email" value="<?php echo $email ?>" autocomplete="off" placeholder="Email" required>

      <label for="inputEmail" class="visually-hidden">Nome</label>
      <input type="text" id="inputNome" class="form-control" name="nome" value="<?php echo $nome ?>" autocomplete="off" placeholder="Nome" required>

      <label for="inputEmail" class="visually-hidden">CPF</label>
      <input type="text" id="cpf" class="form-control" name="cpf" value="<?php echo $cpf ?>" autocomplete="off" placeholder="CPF">

      <label for="inputEmail" class="visually-hidden">RG</label>
      <input type="text" id="rg" class="form-control" name="rg" value="<?php echo $rg ?>" autocomplete="off" placeholder="RG">

      <label for="inputEmail" class="visually-hidden">Telefone</label>
      <input type="text" id="phone" class="form-control" name="telefone" value="<?php echo $tel?>" autocomplete="off" placeholder="Telefone">

      <input type="text" id="" class="form-control" name="tipo" value="administrador" hidden>

      <br>

      <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Entrar</button>
    </form>
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

</script>

</html>
