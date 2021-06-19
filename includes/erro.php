<!DOCTYPE html>
<html>
<head>
	<title>Erro</title>
  

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

<h2 class="my-0 fw-bold"><i>Aconteceu Algo de Errado, Contate o Gerente!</i></h2>
<br><br>
<a class="btn-lg btn-primary" href="../index.php">Voltar</a>
</div>


</div>
</body>

<script>
function goBack() {
  window.history.back();
}
</script>

</html>