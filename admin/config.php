<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Mesas</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>

  <!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/index.css" media="screen" />
</head>

<body>

<!-- Header and Nav Content -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <div class="row">

  	<h1>⚙️ Área do Administrador</h1>

  	<hr>

  	<br>

  	<div class="col-4">
  	<i class="fas fa-4x fa-user-friends"></i><br><br><br>

    <a href="src/funcionario/funcionarios.php"><button class="btn-lg btn-outline-success">Funcionários</button></a><br><br>
  	<a href="src/funcionario/add_funcionario.php"><button class="btn-lg btn-outline-success">Criar Funcionário</button></a><br><br>

  	<!-- <button class="btn-lg btn-outline-success">Criar Tipo de Produto</button><br><br> -->
  	
  	</div>

  	<div class="col-4">
  	<i class="fas fa-4x fa-chart-pie"></i><br><br><br>

  	<button class="btn-lg btn-outline-info">Configurações Gerais</button><br><br>
  	<button class="btn-lg btn-outline-info">Relatórios de Vendas</button><br><br>
    <button class="btn-lg btn-outline-info">Estatísticas</button>
  	</div>

  	<div class="col-4">
  	<i style="margin-right: 20px" class="fas fa-4x fa-hamburger"></i><i class="fas fa-4x fa-beer"></i><br><br><br>

  	<a href="src/produto/produtos.php"><button class="btn-lg btn-outline-success">Produtos Cadastrados</button></a><br><br>
  	<a href="src/produto/add_produto.php"><button class="btn-lg btn-outline-success">Criar Produto</button></a>

  	</div>

  </div>
</div>
</body>
</html>