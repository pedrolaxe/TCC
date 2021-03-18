<?php

session_start();

include "../../includes/functions.php";

autorizacao();

if (isset($_GET['id'])) {

  $id = $_GET['id']; 

}

if (isset($_GET['changed'])) {

  $changed = $_GET['changed'];
  if($changed) {
    // MELHORAR MENSAGEM
    echo "NÃO PODE MUDAR PARA A MESMA MESA";
  } 

}


// if (isset($_POST['id'])) {

//   $id = $_POST['id']; 

// } 

if (isset($_POST['submit'])) {

  trocar_mesa();

} 



?>

<!DOCTYPE html>
<html>
  <head>
  <title>Add Mesa</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <?php include '../../includes/head.php'; ?>

  <!-- Custom styles for this template -->
  <link href="../../assets/css/form.css" rel="stylesheet">

  </head>
  <body class="text-center">

  <?php include '../../includes/header.php'; ?>
    
<main class="form-signin">
  <form action='trocar_mesa.php' method='post'>
    <h1>Trocar de Mesa</h1>
    <input name="id" value="<?php echo $id ?>" hidden>
    <br>
    <label for="inputEmail" class="visually-hidden">Nome do Cliente</label>
    <input name="numero" type="number" class="form-control" placeholder="Trocar Para" autocomplete="off" required autofocus>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name='submit'>Trocar Mesa</button>
    <br><br>
  </form>
</main>


    
  </body>
</html>