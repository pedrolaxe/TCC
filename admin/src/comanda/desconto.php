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

if (isset($_GET['total'])) {
  $total = $_GET['total']; 
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

<?php include '../../../includes/header_admin.php'; 

  # CAPTURAR ERRO CASO O USUARIO USE VIRGULA EM VEZ DE PONTO NO DESCONTO OU USE CARACTERES INVÁLIDOS
  if (isset($_GET['erro_desconto']) && $_GET['erro_desconto'] == true) {

    $erro_desconto = $_GET['erro_desconto'];
    if($erro_desconto) {
      echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Use Ponto e Não Virgula</center></div>';
    } 
  }

  if (isset($_GET['desconto_alto']) && $_GET['desconto_alto'] == true) {

    $desconto_alto = $_GET['desconto_alto'];
    if($desconto_alto) {
      echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Desconto Não Pode Ser Maior Que O Total</center></div>';
    } 
  }

  if (isset($_GET['desconto_negativo']) && $_GET['desconto_negativo'] == true) {

    $desconto_alto = $_GET['desconto_negativo'];
    if($desconto_alto) {
      echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Desconto Não Pode Ser Negativo</center></div>';
    } 
  }

?>
    
<main class="form-signin">
  <form action='desconto.php' method='post'>
    <h1>Desconto</h1>
    <input name="id" value="<?php echo $id ?>" hidden>
    <br>
    <label for="inputEmail" class="visually-hidden">Desconto</label>
    <input name="desconto" type="text" class="form-control" placeholder="Desconto" autocomplete="off" required autofocus>
    <input name="total" value="<?php echo $total ?>" type="text" class="form-control" hidden>

    <br>

    <div class="form-check" style="margin-bottom: 0.5em">
      <input name="descontoCheckBox" value="nominal" style="height:1em !important;" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
      <label style="float:left;" class="form-check-label" for="flexRadioDefault1">
        Nominal
      </label>
    </div>
    <div class="form-check">
      <input name="descontoCheckBox" value="percentual" style="height:1em !important" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
      <label style="float:left" class="form-check-label" for="flexRadioDefault2">
        Percentual
      </label>
    </div>


    <br>
    <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name='submit'>Gerar Desconto</button>
    <br><br>
  </form>
  <a href="comanda.php?id=<?php echo $id; ?>"><button class="w-100 btn btn-lg btn-outline-dark">Voltar</button></a>
</main>
</body>
</html>
