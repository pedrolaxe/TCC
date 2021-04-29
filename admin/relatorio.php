<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório</title>

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

  	<h1>⚙️ Relatório de Vendas</h1>

    <br><br><br>

  	<hr>

  	<br><br>

  	<div class="col-8">

      <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            // $query  = "SELECT * FROM PEDIDO WHERE tipo = 'funcionario' ORDER BY login ASC";
            // $result = $con->query($query);

            foreach($result as $row) {

              

            ?>
              <tr>
                <td><?php ?></td>
                <td style="text-align: right; padding-left: 0"><a href="edit_colaborador.php?id_colaborador=<?=$id;?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="colaboradores.php?delete_colaborador=<?=$id;?>"><button class="btn btn-outline-dark"><i class="fas fa-trash"></i></button></a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
  	 
      <a href="painel.php"><button class="btn btn-lg btn-outline" style="float:right; width:120px;">Voltar</button></a>

  	</div>

  
  </div>
</div>
</body>
</html>