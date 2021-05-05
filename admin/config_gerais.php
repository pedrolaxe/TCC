<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

if (isset($_POST['submit'])) {
  // insert_config();

  $empresa    = $_POST['empresa'];
  $impressora = $_POST['impressora'];
  $logo       = $_POST['logo'];

  $query  = "INSERT INTO config (nome_empresa, nome_impressora, logo) ";
  $query .= "VALUES ('$empresa', '$impressora', '$logo')";
  $result = $con->query($query);

}

# SELECIONAR TABLE CONFIG
$query  = "SELECT * FROM config";
$result = $con->query($query);

while ($row = $result->fetch() ) {

  $empresa    = $row['nome_empresa'];
  $impressora = $row['nome_impressora'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Configurações</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>

  <!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/index.css" media="screen" />

  <style type="text/css">
    
    .form-control {
      height: 70px;
      margin-bottom: 20px; 
      font-size: 22px;
    }

    .logo {
      height: auto;
      /*width: auto;*/
    }

  </style>

</head>

<body>

<!-- Header and Nav Content -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <br>
  <div class="row">

  	<h1>⚙️ Configurações Gerais</h1>

    <br><br><br>

  	<hr>

  	<br><br>

  	<div class="col-6">

      <form action="config_gerais.php" method="POST">
        <label for="Logo"><i style="font-size: 24px; font-weight: bolder">Logo da Empresa</i></label><br><br>
        <input class="form-control logo" type="file" id="img" name="logo" accept="image/*"><br>
        <label><i style="font-size: 24px; font-weight: bolder">Outras Informações</i></label><br><br>
        <input class="form-control" value="<?php if (isset($empresa)) echo $empresa; ?>" type="text" name="empresa" placeholder="Nome da Empresa">
        <input class="form-control" value="<?php if (isset($impressora)) echo $impressora; ?>" type="text" name="impressora" placeholder="Nome da Impressora">

        <br>
        <button class="btn btn-lg btn-outline" style="float:right; width:120px; margin-left: 20px !important" type="submit" name="submit">Ok</button>

      </form>
  	

  	</div>

  
  </div>
</div>
</body>
</html>