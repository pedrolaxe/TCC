<?php

session_start();
include "../../includes/functions.php";

autorizacao();

if (isset($_POST['submit'])) {
  insert_comanda();
} else { }

?>

<!DOCTYPE html>
<html>

<head>
  <title>Add Comanda</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="../../assets/css/form.css" rel="stylesheet">
</head>

<body class="text-center">
<?php include '../../includes/header.php'; ?>
    
<main class="form-signin">
  <form action='add_comanda.php' method='post'>
    <h1>Nova comanda</h1>
    <br>
    <label for="inputEmail" class="visually-hidden">Numero da Comanda</label>
    <input name="numero" type="number" class="form-control" placeholder="Número da comanda" autocomplete="off" required autofocus>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name='submit'>Abrir Comanda</button>
    <br><br>
  </form>
</main> 
</body>
</html>
