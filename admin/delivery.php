<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Mesas</title>
  <link rel="icon" href="assets/img/logo.jpg">
  
  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>
</head>

<body>

<!-- HEADER AND NAV CONTENT -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <div class="row">
    <div class="col-4">
      <h1>Pedido</h1>
      <hr>
    
      <div class="progress" style="border: 1px solid black">
        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
      </div>
      <br>

      <form>
        <!-- DELIVERY OU BALCÃO -->
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            Delivery
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
          <label class="form-check-label" for="flexRadioDefault2">
            Balcão
          </label>
        </div>

        <br>

        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Telefone</label>
          <input type="tel" class="form-control" id="exampleInputEmail1" pattern="[0-9]{2}-[0-9]{5}-[0-9]{4}">
        </div>

        <input name="submit" type="submit" value="Procurar">
      </form>
    </div>
  </div>
</div>
</body>
</html>