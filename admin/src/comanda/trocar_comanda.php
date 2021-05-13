<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

if (isset($_GET['id'])) {
  $id = $_GET['id']; 
}

if (isset($_GET['changed'])) {

  $changed = $_GET['changed'];
  if($changed) {
    // MELHORAR MENSAGEM
    echo "NÃO PODE MUDAR PARA A MESMA COMANDA";
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
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="../../../assets/css/form.css" rel="stylesheet">
</head>

<body class="text-center">

<?php include '../../../includes/header_admin.php'; ?>
    
<main class="form-signin">
  <form action='trocar_comanda.php' method='post'>
    <h1>Trocar de Comanda</h1>
    <input name="id" value="<?php echo $id ?>" hidden>
    <br>
    <label for="inputEmail" class="visually-hidden">Trocar Comanda</label>
    <input name="nome" type="text" class="form-control" placeholder="Trocar Para" autocomplete="off" required autofocus>
    <br>
    <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name='submit'>Trocar Comanda</button>
    <br><br>
  </form>
  <a href="comanda.php?id=<?php echo $id; ?>"><button class="w-100 btn btn-lg btn-outline">Voltar</button></a>
</main>
</body>
</html>
