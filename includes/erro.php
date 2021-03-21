<!DOCTYPE html>
<html>
<head>
	<title>Erro</title>
  <link rel="icon" href="assets/img/logo.jpg">
  
  <?php include '../includes/head.php' ?>

<style>
.container {
  height: 200px;
  position: relative;
  /*border: 3px solid green;*/
}

.vertical-center {
  margin: 0;
  position: absolute;
  top: 30vh;

}

h1 { font-size: 64px }
</style>
</head>

<body>

<!-- Header and Nav Content -->
<?php include 'header.php'; ?>

<div class='container'>
<div class="vertical-center">

<h2 class="my-0 fw-bold"><i>Aconteceu Algo de Errado, Contate o Administrador!</i></h2>
<br><br>
<button class="btn-lg btn-primary" onclick="goBack()">Voltar</button>
</div>


</div>
</body>

<script>
function goBack() {
  window.history.back();
}
</script>

</html>