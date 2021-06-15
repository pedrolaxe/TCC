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

  <form action='faturamento.php' method='post'>

    <div class="row">



    	 <div class="col-5">
        <h1>Faturamento</h1><br>

        <br><br>

        <h3 class="cartao"></h3><br>
        <h3 class="dinheiro"></h3><br>
        <h3 class="pix"></h3><br>
        <h3 class="desconto"></h3><br>
        <h3 class="total"></h3><br>
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

    <br><br>

  	<div class="col-12">

      <?php

      $submit_ok = false;

      if(isset($_POST['submit'])) {

            $total = 0;

            # flag
            $submit_ok = true;

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
                $total = $qtd*$valor;
             } 

            } }


            }


            if (!$submit_ok) {

              $total = 0;

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
                $total = $qtd*$valor;
            }

            } }
              
             }

              ?>

          </tbody>

        </table>

        <br><br>

  	</div>

  </div>

  


</div>
</body>

<?php

echo $total;

if (!$submit_ok) {

    $date = date("Y/m/d");

    $query2 = "SELECT SUM(cartao), SUM(dinheiro), SUM(pix), SUM(desconto) FROM COMANDA WHERE data_comanda ='$date' AND status != 'cancelado'";
      $result2 = $con->query($query2);

      foreach ($result2 as $value) {

      $cartao   = $value[0];
      $dinheiro = $value[1];
      $pix      = $value[2];
      $desconto = $value[3];

      $faturamento = $cartao+$dinheiro+$pix;

      $faturamento -= $desconto;
    }

  } elseif ($submit_ok) {
    $query2 = "SELECT SUM(cartao), SUM(dinheiro), SUM(pix), SUM(desconto) FROM COMANDA WHERE data_comanda >= '$data1' AND data_comanda <= '$data2' AND status != 'cancelado'";
      $result2 = $con->query($query2);

      foreach ($result2 as $value) {

      $cartao   = $value[0];
      $dinheiro = $value[1];
      $pix      = $value[2];
      $desconto = $value[3];

      $faturamento = $cartao+$dinheiro+$pix;

      $faturamento -= $desconto;
    }
  }

?>

<script type="text/javascript">

  <?php

    $faturamento = number_format($faturamento, 2, ',', '.');
    $cartao = number_format($cartao, 2, ',', '.'); 
    $dinheiro = number_format($dinheiro, 2, ',', '.'); 
    $pix = number_format($pix, 2, ',', '.'); 
    $desconto = number_format($desconto, 2, ',', '.'); 

  ?>

  let faturamento = document.querySelector(".total");
  let cartao      = document.querySelector(".cartao");
  let dinheiro    = document.querySelector(".dinheiro");
  let pix         = document.querySelector(".pix");
  let desconto    = document.querySelector(".desconto");

  <?php if($faturamento != '0,00') { ?>

    faturamento.textContent += 'Total'.padEnd(30, '.')+' R$ <?php echo $faturamento; ?>';
    cartao.textContent      += 'Cartão'.padEnd(28, '.')+' R$ <?php echo $cartao; ?>';
    dinheiro.textContent    += 'Dinheiro'.padEnd(27, '.')+' R$ <?php echo $dinheiro; ?>';
    pix.textContent         += 'Pix'.padEnd(32, '.')+' R$ <?php echo $pix; ?>';
    desconto.textContent    += 'Desconto'.padEnd(25, '.')+' R$ <?php echo $desconto; ?>';

  <?php } ?>



</script>


</html>