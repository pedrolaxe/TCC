<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>

  <!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/index.css" media="screen" />

<style type="text/css">
  
button {
  border: 3px solid black !important;
}

button:hover {
  border: 3px solid white;
  background-color: black;
  color: white;
}

.btn-outline-success {
  border: 3px solid green !important;
}

</style>


</head>

<body>

<!-- Header and Nav Content -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <br>
  <div class="row">

  	<!-- <h1>⚙️ Área do Gerente</h1> -->
    <h1>Área do Gerente</h1>

    <br><br><br>

  	<hr>

  	<br><br><br>

  	<div class="col-4">
  	<!-- <i class="fas fa-4x fa-chart-pie"></i><br><br><br> -->

  	<a href="config_gerais.php"><button class="btn-lg btn-outline">Configurações Gerais</button></a><br><br>
  	<a href="relatorio_vendas.php"><button class="btn-lg btn-outline">Relatório de Vendas</button></a><br><br>
    <a href="relatorio_comandas.php"><button class="btn-lg btn-outline">Relatório de Comandas</button></a>
  	</div>

  	<div class="col-4">
  	<!-- <i style="margin-right: 20px" class="fas fa-4x fa-hamburger"></i><i class="fas fa-4x fa-beer"></i><br><br><br> -->

  	<a href="src/produto/produtos.php"><button class="btn-lg btn-outline">Produtos</button></a>
  	<a href="src/produto/add_produto.php"><button class="btn-lg btn-outline-success">+</button></a><br><br>
    <a href="top_produtos.php"><button class="btn-lg btn-outline">Top Produtos</button></a>

  	</div>

    <div class="col-4">
    <!-- <i class="fas fa-4x fa-user-friends"></i><br><br><br> -->

    <a href="src/colaborador/colaboradores.php"><button class="btn-lg btn-outline">Colaboradores</button></a>
    <a href="src/colaborador/add_colaborador.php"><button class="btn-lg btn-outline-success">+</button></a><br><br>

    <!-- <button class="btn-lg btn-outline-success">Criar Tipo de Produto</button><br><br> -->
    
    </div>

  </div>
</div>
</body>
</html>