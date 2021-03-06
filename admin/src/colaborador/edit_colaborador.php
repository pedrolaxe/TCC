<?php

session_start();
include "../../../includes/functions.php";

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

  <!-- BOOTSTRAP CORE CSS -->
  <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- CSS -->
  <link href="<?= LINK_SITE; ?>assets/css/form.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= LINK_SITE; ?>assets/css/main.css" media="screen" />

  <style type="text/css">
    
  .btn-outline {
    border: .2em solid black !important;
  }

  .btn-outline:hover {
    border: .2em solid white;
    background-color: black;
    color: white;
  }

  .form-signin input {
    margin-bottom: 15px;
  }

  button {
    margin-top: 10px;
  }

  </style>



</head>

<body class="text-center">

  <?php include '../../../includes/header_admin.php'; ?>

  <main class="form-signin">
    <form action="edit_colaborador.php?id_colaborador=<?php echo $_GET['id_colaborador'] ?>" method="POST">

      <?php

      if (isset($_GET['cpfValido']) && $_GET['cpfValido'] == 'false') {
        echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Insira um CPF válido</center></div>';
      }

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


      if(isset($_GET['usuario_existe'])) {
        if($_GET['usuario_existe']) {
          echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Usuário Já Existe!</center></div>';
        }
      }

      if (isset($_POST['submit'])) {
          $idf        = anti_injection($_POST['id_user']);
          $login      = anti_injection($_POST['login']);
          $email      = anti_injection($_POST['email']);
          // $senha      = anti_injection($_POST['senha']);
          // $conf_senha = anti_injection($_POST['conf_senha']);
          $nome       = anti_injection($_POST['nome']);
          $cpf        = anti_injection($_POST['cpf']);
          $rg         = anti_injection($_POST['rg']);
          $tel        = anti_injection($_POST['telefone']);


          // if( empty($login) || empty($email) || empty($senha) || empty($conf_senha) ){
          //   $link_atual = LINK_SITE."admin/src/colaborador/edit_colaborador.php?id_colaborador=".$idf."";
          //   header("Location: ".$link_atual."&error=1");
          // } 

          if( empty($login) || empty($email) || empty($nome) ){
            $link_atual = LINK_SITE."admin/src/colaborador/edit_colaborador.php?id_colaborador=".$idf."";
            header("Location: ".$link_atual."&error=1");
          } 

          // elseif($senha != $conf_senha){
          //   $link_atual = LINK_SITE."admin/src/colaborador/edit_colaborador.php?id_colaborador=".$idf."";
          //   header("Location: ".$link_atual."&error=2");
          // }

          // if($senha == $conf_senha && !empty($login) && !empty($email) && !empty($senha) && !empty($conf_senha) ){
          //   alterar_colaborador($idf, $login, $email, $senha, $nome, $cpf, $rg, $tel);
          // } 

          if(!empty($login) && !empty($email)){
            alterar_colaborador($idf, $login, $email, $nome, $cpf, $rg, $tel);
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
                $nome  = $row['nome_colaborador'];
                $cpf   = $row['cpf'];
                $rg    = $row['rg'];
                $tel   = $row['telefone'];
            }
        }
      } catch(Expression $e) {}
        
      ?>

      <h1 style="font-size: 46px; text-align: center; margin-top: -10px">Editar Colaborador</h1>
      
      <label for="inputEmail" style="float:left;margin-bottom: 0.2em;margin-left: 0.2em" class="">Login</label>
      <input type="text" id="inputEmail" class="form-control" name="login" placeholder="Login" value="<?=$login; ?>" required autofocus>
<!--       <label for="inputPassword" class="">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
      <label for="inputPassword" class="">Confirmação Senha</label>
      <input type="password" id="inputPassword" class="form-control" name="conf_senha" placeholder="Confirmação de Senha" required> -->
      <label for="inputEmail" style="float:left;margin-bottom: 0.2em;margin-left: 0.2em" class="">Email</label>
      <input type="email" id="inputEmail" class="form-control" name="email" value="<?=$email; ?>" placeholder="Email" required>

      <label for="inputEmail" style="float:left;margin-bottom: 0.2em;margin-left: 0.2em" class="">Nome</label>
      <input type="text" id="" class="form-control" name="nome" placeholder="Nome" value="<?=$nome; ?>" autocomplete="off" required> 
      <label for="inputEmail" style="float:left;margin-bottom: 0.2em;margin-left: 0.2em" class="">CPF</label>
      <input type="text" id="cpf" class="form-control" name="cpf" placeholder="CPF" value="<?=$cpf; ?>" autocomplete="off" required>
      <label for="inputEmail" style="float:left;margin-bottom: 0.2em;margin-left: 0.2em" class="">RG</label>
      <input type="text" id="text" class="form-control" name="rg" placeholder="RG" value="<?=$rg; ?>" autocomplete="off">
      <label for="inputEmail" style="float:left;margin-bottom: 0.2em;margin-left: 0.2em" class="">Telefone</label>
      <input type="text" id="phone" class="form-control" name="telefone" placeholder="Telefone" value="<?=$tel; ?>" autocomplete="off">

      <input type="hidden" name="tipo" value="colaborador">
      <input type="hidden" name="id_user" value="<?=$id_colaborador; ?>">



      <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Salvar</button>
    </form>


    <a href="<?= LINK_SITE; ?>admin/src/colaborador/alterar_senha_colaborador.php?id_colaborador=<?php echo $_GET['id_colaborador'] ?>"><button class="w-100 btn btn-lg btn-outline">Alterar Senha</button></a>


    <a href="<?= LINK_SITE; ?>admin/src/colaborador/colaboradores.php"><button class="w-100 btn btn-lg btn-outline">Voltar</button></a>
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