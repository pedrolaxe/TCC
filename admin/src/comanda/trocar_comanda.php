<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

if (isset($_GET['id'])) {
  $id = $_GET['id']; 
}

if (isset($_POST['submit'])) {
  trocar_comanda();
} 

?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Comanda</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="../../../assets/css/form.css" rel="stylesheet">
</head>

<body class="text-center">

<?php 

  include '../../../includes/header_admin.php'; 

  # CASO O USUARIO ESCOLHA A MESMA COMANDA
  if (isset($_GET['changed'])) {

    $changed = $_GET['changed'];
    if($changed) {
      // MELHORAR MENSAGEM
      echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Não Pode Mudar Para A Mesma Comanda</center></div>';
    } 
  }

  if (isset($_GET['ja_existe']) && $_GET['ja_existe'] == true && !empty($_GET['nome_comanda'])) {
      echo '<div style="width:15em; margin:0 auto;" class="alert alert-warning" role="alert"><center>A Comanda Já Existe, Tem Certeza Que Deseja Trocar?</center></div>';

      echo 

      '

        <main class="form-signin">
          <form action="trocar_comanda.php?ja_existe=true" method="post">
            <h1>Trocar de Comanda</h1>
            <input name="id" value="'.$id.'" hidden>
            <br>
            <label for="inputEmail" class="visually-hidden">Trocar Comanda</label>
            <input name="nome" type="text" value="'.$_GET['nome_comanda'].'" class="form-control" placeholder="Trocar Para" autocomplete="off" required autofocus hidden>
            <br>
            <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Tenho Certeza</button>
            <br><br>
          </form>
          <a href="comanda.php?id='.$id.'"><button class="w-100 btn btn-lg btn-outline-dark">Voltar</button></a>
        </main>

      ';
    
  } else {

    echo 

    '

      <main class="form-signin">
        <form action="trocar_comanda.php" method="post">
          <h1>Trocar de Comanda</h1>
          <input name="id" value="'.$id.'" hidden>
          <br>
          <label for="inputEmail" class="visually-hidden">Trocar Comanda</label>
          <input name="nome" type="text" class="form-control" placeholder="Trocar Para" autocomplete="off" required autofocus>
          <br>
          <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name="submit">Trocar Comanda</button>
          <br><br>
        </form>
        <a href="comanda.php?id='.$id.'"><button class="w-100 btn btn-lg btn-outline-dark">Voltar</button></a>
      </main>


    ';

  }

?>
    
</body>
</html>
