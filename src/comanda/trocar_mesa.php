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
    echo "NÃO PODE MUDAR PARA A MESMA comanda";
  } 
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
  <?php include '../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="../../assets/css/form.css" rel="stylesheet">
</head>

<body class="text-center">

<!-- HEADER AND NAV -->
<?php include '../../includes/header.php'; ?>
    
<main class="form-signin">
  <form action='trocar_comanda.php' method='post'>
    <h1>Trocar de Comanda</h1>
    <input name="id" value="<?php echo $id ?>" hidden>
    <br>
    <label for="inputEmail" class="visually-hidden">Nome do Cliente</label>
    <input name="numero" type="number" class="form-control" placeholder="Trocar Para" autocomplete="off" required autofocus>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name='submit'>Trocar Comanda</button>
    <br><br>
  </form>
</main>
</body>
</html>
