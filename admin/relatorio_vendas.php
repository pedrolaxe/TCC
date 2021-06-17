<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

$query_colaborador = "SELECT * FROM COLABORADOR";
$result_col = $con->query($query_colaborador);

$existe_pedido = false;

if(isset($_POST['submit'])) {

            $data1 = $_POST['data1'];
            $data2 = $_POST['data2'];


            if($data1 > $data2) {
              echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Primeira Data Não Pode Ser Maior Que A Segunda</center></div>';
              $existe_pedido = true;
            }

            $query  = "

                  SELECT * FROM PEDIDO 
                  INNER JOIN PRODUTO ON 
                  PEDIDO.id_produto = PRODUTO.id_produto 
                  INNER JOIN COMANDA ON 
                  PEDIDO.id_comanda = COMANDA.id_comanda 
                  INNER JOIN COLABORADOR ON 
                  PEDIDO.id_colaborador = COLABORADOR.id_colaborador
                  ORDER BY ABS(id_pedido)
                  
            ";


            $result = $con->query($query);
          }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Vendas</title>

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

  <form action='relatorio_vendas.php' method='post'>

    <div class="row">

    	 <div class="col-2">
        <h1>Vendas</h1><br>
        <br>
      </div>

      <div class="col-3">
        <input id="troca_input" name="nome" type="text" class="form-control" placeholder="Colaborador" autocomplete="off" list="colaboradores" style="height:60px; width: 250px" autofocus>
        <datalist id="colaboradores">

          <?php

          foreach($result_col as $row) {
            $id_col   = $row['id_colaborador'];
            $nome_col = $row['nome_colaborador'];

            echo '<option value="'.$nome_col.'"></option>';

          }

          ?>

        </datalist>
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
              <th>Comanda</th>
              <th>Atendente</th>
              <th>Produto</th>
              <th>Qtd</th>
              <th>Preço</th>
              <th>Total</th>
              <th>Hora</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>

      <?php

      $submit_ok = false;

      if(isset($_POST['submit'])) {

            $faturamento = 0;

            # flag
            $submit_ok = true;

            if(isset($_POST['nome']) && !empty($_POST['nome'])) {

            $nome_col_sub = $_POST['nome'];

            foreach($result as $row) { 

            $status = $row['status'];
            $nome_col_aux = $row['nome_colaborador'];
  
            if($status == 'fechado' && $nome_col_aux == $nome_col_sub) { 

              $id_comanda     = $row['id_comanda'];
              $id_pedido      = $row['id_pedido'];
              $nome           = $row['nome'];
              $nome_produto   = $row['nome_produto'];
              $qtd            = $row['quantidade'];
              $valor          = $row['valor'];
              $status_pedido  = $row['status_pedido'];
              $id_colaborador = $row['id_colaborador'];

              $query2 = "SELECT * FROM COLABORADOR WHERE id_colaborador = '$id_colaborador'";

              $result2 = $con->query($query2);

              foreach($result2 as $row2) { 
                $nome_colaborador = $row2['nome_colaborador'];
              }

              // $data[0] é data e $data[1] é hora
              $data         = explode(' ',trim($row['data'])); 

              $data_aux = date("Y-m-d", strtotime($data[0]));

              if ($data_aux >= $data1 && $data_aux <= $data2 && $status_pedido != 'cancelado') {

                $existe_pedido = true;

                $faturamento += $valor*$qtd;

            ?>
              <tr>
                <td><?php echo ucfirst($nome) ?></td>
                <td><?php echo $nome_colaborador ?></td>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $qtd ?></td>
                <td><?php echo number_format($valor, 2, ',', '.') ?></td>
                <td><?php echo number_format($valor*$qtd, 2, ',', '.') ?></td>
                <td><?php echo substr($data[1], 0, -3) ?></td>
                <td><?php echo date("d/m/Y", strtotime($data[0])) ?></td>
              </tr>

            <?php }

            } }

            } else {

            foreach($result as $row) { 

            $status = $row['status'];
  
            if($status == 'fechado') { 

              $id_comanda     = $row['id_comanda'];
              $id_pedido      = $row['id_pedido'];
              $nome           = $row['nome'];
              $nome_produto   = $row['nome_produto'];
              $qtd            = $row['quantidade'];
              $valor          = $row['valor'];
              $status_pedido  = $row['status_pedido'];
              $id_colaborador = $row['id_colaborador'];

              $query2 = "SELECT * FROM COLABORADOR WHERE id_colaborador = '$id_colaborador'";

              $result2 = $con->query($query2);

              foreach($result2 as $row2) { 
                $nome_colaborador = $row2['nome_colaborador'];
              }

              // $data[0] é data e $data[1] é hora
              $data         = explode(' ',trim($row['data'])); 

              $data_aux = date("Y-m-d", strtotime($data[0]));

              if ($data_aux >= $data1 && $data_aux <= $data2 && $status_pedido != 'cancelado') {

                $existe_pedido = true;

                $faturamento += $valor*$qtd;

            ?>
              <tr>
                <td><?php echo ucfirst($nome) ?></td>
                <td><?php echo $nome_colaborador ?></td>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $qtd ?></td>
                <td><?php echo number_format($valor, 2, ',', '.') ?></td>
                <td><?php echo number_format($valor*$qtd, 2, ',', '.') ?></td>
                <td><?php echo substr($data[1], 0, -3) ?></td>
                <td><?php echo date("d/m/Y", strtotime($data[0])) ?></td>
              </tr>

            <?php }

            } }

            }

              if (!$existe_pedido) {
                echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Não Existem Pedidos Nessa Data</center></div><br>';
              }


            }


            if (!$submit_ok) {

              $faturamento = 0;

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
              $valor        = $row['valor'];
              $status_pedido = $row['status_pedido'];
              $id_colaborador = $row['id_colaborador'];

              $query2 = "SELECT * FROM COLABORADOR WHERE id_colaborador = '$id_colaborador'";

              $result2 = $con->query($query2);

              foreach($result2 as $row2) { 
                $nome_colaborador = $row2['nome_colaborador'];
              }


              // $data[0] é data e $data[1] é hora
              $data         = explode(' ',trim($row['data'])); 

              $data_aux = date("Y-m-d", strtotime($data[0]));

              if ($data_aux == date("Y-m-d") && $status_pedido != 'cancelado') {

                $existe_pedido = true;

                $faturamento += $valor*$qtd;

            ?>
              <tr>
                <td><?php echo ucfirst($nome) ?></td>
                <td><?php echo $nome_colaborador ?></td>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $qtd ?></td>
                <td><?php echo number_format($valor, 2, ',', '.') ?></td>
                <td><?php echo number_format($valor*$qtd, 2, ',', '.') ?></td>
                <td><?php echo substr($data[1], 0, -3) ?></td>
                <td><?php echo date("d/m/Y", strtotime($data[0])) ?></td>
              </tr>

            <?php } 

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

<script type="text/javascript">

  <?php

    $query = "SELECT * FROM COMANDA";
    $result = $con->query($query);

    foreach($result as $row) { 

      $status = $row['status'];
    
      if($status == 'fechado') { 

        $id_comanda = $row['id_comanda'];
        $desconto   = $row['desconto'];

        $data       = $row['data_comanda']; 

        $data = date("Y-m-d", strtotime($data));

        if ($data == date("Y-m-d")) {
          $faturamento -= $desconto;
        }

      }

    }


    $faturamento = number_format($faturamento, 2, ',', '.') 

  ?>

  let faturamento = document.querySelector("h2");

  <?php if($faturamento != '0,00') { ?>

    faturamento.textContent += 'Faturamento: R$ <?php echo $faturamento; ?>';

  <?php } ?>



</script>


</html>