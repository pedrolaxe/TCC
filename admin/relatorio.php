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
  <link href="<?=LINK_SITE;?>assets/css/produtos.css" rel="stylesheet">

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

    button {
      border: 3px solid !important;
    }

    button:hover {
      border: 3px solid grey !important;
    }

  </style>

</head>

<body>

<!-- Header and Nav Content -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <br>
  <div class="row">

  	<h1><i class="far fa-file-alt"></i> Relatório de Vendas</h1>

    <br><br><br>

  	<hr>

  	<br><br>

  	<div class="col-12">

      <table class="styled-table" style="width: 100%">
          <thead>
            <tr>
              <th>Pedido</th>
              <th>Comanda</th>
              <th>Nome</th>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "

                  SELECT * FROM PEDIDO 
                  INNER JOIN PRODUTO ON 
                  PEDIDO.id_produto = PRODUTO.id_produto 
                  INNER JOIN COMANDA ON 
                  PEDIDO.id_comanda = COMANDA.id_comanda
                  
            ";


            $result = $con->query($query);

            foreach($result as $row) { 

            $status = $row['status'];
  
            if($status == 'fechado') { 

              $id_comanda   = $row['id_comanda'];
              $id_pedido    = $row['id_pedido'];
              $nome         = $row['nome'];
              $nome_produto = $row['nome_produto'];
              $qtd          = $row['quantidade'];
              $data = '05/05/21';  

            ?>
              <tr>
                <td><?php echo $id_pedido ?></td>
                <td><?php echo $id_comanda ?></td>
                <td><?php echo ucfirst($nome) ?></td>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $qtd ?></td>
                <td><?php echo $data ?></td>
              </tr>

            <?php } } ?>

          </tbody>

        </table>

  	</div>

 <a href="painel.php"><button class="btn btn-lg btn-outline-secondary" style="float:right; width:120px; margin-top: 20px">Voltar</button></a>
  
  </div>
</div>
</body>
</html>