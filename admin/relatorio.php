<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

$existe_pedido = false;

if(isset($_POST['submit'])) {

            $data1 = $_POST['data1'];
            $data2 = $_POST['data2'];


            if($data1 > $data2) {
              echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Primeira Data Não Pode Ser Maior Que A Segunda</center></div>';
              $existe_pedido = true;
            }


            if($data1 > $data2) {

            }

            $query  = "

                  SELECT * FROM PEDIDO 
                  INNER JOIN PRODUTO ON 
                  PEDIDO.id_produto = PRODUTO.id_produto 
                  INNER JOIN COMANDA ON 
                  PEDIDO.id_comanda = COMANDA.id_comanda 
                  ORDER BY ABS(id_pedido)
                  
            ";


            $result = $con->query($query);
          }

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

     .btn-outline {
    border: .2em solid black !important;
  }

  .btn-outline:hover {
    border: .2em solid white;
    background-color: black;
    color: white;
  }

  </style>

</head>

<body>

<!-- Header and Nav Content -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <br>

  <form action='relatorio.php' method='post'>

    <div class="row">

    	 <div class="col-5">
        <h1><i class="fas fa-chart-pie"></i> Relatório de Vendas</h1>
      </div>

      <div class="col-3">
        <input name="data1" type="date" value="<?php if(isset($data1)) echo $data1; else echo date("Y-m-d"); ?>" style="height:60px; width: 250px">
      </div>

      <div class="col-3"> 
        <input name="data2" type="date" value="<?php if(isset($data2)) echo $data2; else echo date("Y-m-d"); ?>" style="height:60px; width: 250px">
      </div>

      <div class="col-1">
        <button class="btn-lg btn-outline" type="submit" name="submit" style="height:60px">Ok</button>
      </div>

  </form>

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
              <th>Hora</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>

      <?php

      $submit_ok = false;

      if(isset($_POST['submit'])) {

            # flag
            $submit_ok = true;

            foreach($result as $row) { 

            $status = $row['status'];
  
            if($status == 'fechado') { 

              $id_comanda   = $row['id_comanda'];
              $id_pedido    = $row['id_pedido'];
              $nome         = $row['nome'];
              $nome_produto = $row['nome_produto'];
              $qtd          = $row['quantidade'];

              // $data[0] é data e $data[1] é hora
              $data         = explode(' ',trim($row['data'])); 

              $data_aux = date("Y-m-d", strtotime($data[0]));

              if ($data_aux >= $data1 && $data_aux <= $data2) {

                $existe_pedido = true;

            ?>
              <tr>
                <td><?php echo $id_pedido ?></td>
                <td><?php echo $id_comanda ?></td>
                <td><?php echo ucfirst($nome) ?></td>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $qtd ?></td>
                <td><?php echo $data[1] ?></td>
                <td><?php echo $data[0] ?></td>
              </tr>

            <?php } else {
              # MELHORAR MENSAGEM
              // echo "<tr><td></td>";
              // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              // echo "</tr>";
              
              // break;
            }

            } }

              if (!$existe_pedido) {
                echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Não Existem Pedidos Nessa Data</center></div><br>';
              }


            }


            if (!$submit_ok) {



              $query  = "

                  SELECT * FROM PEDIDO 
                  INNER JOIN PRODUTO ON 
                  PEDIDO.id_produto = PRODUTO.id_produto 
                  INNER JOIN COMANDA ON 
                  PEDIDO.id_comanda = COMANDA.id_comanda 
                  ORDER BY ABS(id_pedido)
                  
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

              // $data[0] é data e $data[1] é hora
              $data         = explode(' ',trim($row['data'])); 

              $data_aux = date("Y-m-d", strtotime($data[0]));

              if ($data_aux == date("Y-m-d")) {

                $existe_pedido = true;

            ?>
              <tr>
                <td><?php echo $id_pedido ?></td>
                <td><?php echo $id_comanda ?></td>
                <td><?php echo ucfirst($nome) ?></td>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $qtd ?></td>
                <td><?php echo $data[1] ?></td>
                <td><?php echo $data[0] ?></td>
              </tr>

            <?php } else {
              # MELHORAR MENSAGEM
              // echo "<tr><td></td>";
              // echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              // echo "</tr>";
              
              // break;
            }

            } }

              if (!$existe_pedido) {
                echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Não Existem Pedidos Nessa Data</center></div><br>';
              }
              
             }

              ?>

          </tbody>

        </table>

        <br><br>

  	</div>

  </div>
</div>
</body>
</html>