<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}


if (isset($_GET['id'])) {
  $id = $_GET['id']; 
}

if (isset($_POST['submit'])) {
  insert_desconto();
} 

?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Mesa</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="../../../assets/css/form.css" rel="stylesheet">
</head>

<body class="text-center">

<?php include '../../../includes/header_admin.php'; ?>
    
<main class="form-signin">
  <form action='desconto.php' method='post'>
    <h1>Desconto</h1>
    <input name="id" value="<?php echo $id ?>" hidden>
    <br>
    <label for="inputEmail" class="visually-hidden">Desconto</label>
    <input name="desconto" type="text" class="form-control" placeholder="Desconto (Ex: 10.50)" autocomplete="off" required autofocus>
    <br>
    <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name='submit'>Gerar Desconto</button>
    <br><br>
  </form>
  <a href="comanda.php?id=<?php echo $id; ?>"><button class="w-100 btn btn-lg btn-outline">Voltar</button></a>
</main>
</body>
</html>
