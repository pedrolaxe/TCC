<?php

session_start();
include "../../includes/functions.php";

autorizacao();

if (isset($_POST['submit'])) {
  insert_mesa();
} else { }

?>

<!DOCTYPE html>
<html>

<head>
  <title>Add Mesa</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="../../assets/css/form.css" rel="stylesheet">
</head>

<body class="text-center">
<?php include '../../includes/header.php'; ?>
    
<main class="form-signin">
  <form action='add_mesa.php' method='post'>
    <h1>Nova Mesa</h1>
    <br>
    <label for="inputEmail" class="visually-hidden">Numero da Mesa</label>
    <input name="numero" type="number" class="form-control" placeholder="Número da Mesa" autocomplete="off" required autofocus>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name='submit'>Abrir Mesa</button>
    <br><br>
  </form>
</main> 
</body>
</html>
