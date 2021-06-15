<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

if(isset($_POST['submit'])) {

            $data = $_POST['data'];
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

  <form action='top_colaborador.php' method='post'>

    <div class="row">

    	 <div class="col-5">
        <h1>Colaborador do Mês</h1><br>
        <h2></h2><br>
      </div>

      <div class="col-3">

      </div>

      <div class="col-3"> 
        <input name="data" type="month" value="<?php if(isset($data)) echo $data; else echo date("m-Y"); ?>" style="height:60px; width: 250px">
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
              <th>Colaborador</th>
              <th>Quantidade Vendida</th>
              <th>Faturamento</th>
            </tr>
          </thead>
          <tbody>

      <?php

      $submit_ok = false;

      if(isset($_POST['submit'])) {

            # flag
            $submit_ok = true;

            $data         = explode(' ',trim($data)); 

              $data_aux = date("Y-m", strtotime($data[0]));

              $query = "SELECT c.nome_colaborador, SUM(p.quantidade), SUM(p.valor*p.quantidade) FROM PEDIDO p INNER JOIN COLABORADOR c ON p.id_colaborador = c.id_colaborador INNER JOIN COMANDA com ON p.id_comanda = com.id_comanda WHERE p.data LIKE '$data_aux%' AND com.status = 'fechado' AND p.status_pedido IS NULL GROUP BY c.id_colaborador";
              $result = $con->query($query);

              foreach ($result as $value) {

              echo '
              <tr>
                <td>'.$value[0].'</td>
                <td>'.$value[1].'</td>
                <td>R$ '.str_replace('.', ',', $value[2]).'</td>
              </tr>
              ';
              }



            }

            if (!$submit_ok) {

              $query = "SELECT c.nome_colaborador, SUM(p.quantidade), SUM(p.valor*p.quantidade) FROM PEDIDO p INNER JOIN COLABORADOR c ON p.id_colaborador = c.id_colaborador INNER JOIN COMANDA com ON p.id_comanda = com.id_comanda WHERE com.status = 'fechado' AND p.status_pedido IS NULL GROUP BY c.id_colaborador";
              $result = $con->query($query);

              foreach ($result as $value) {

              echo '
              <tr>
                <td>'.$value[0].'</td>
                <td>'.$value[1].'</td>
                <td>R$ '.str_replace('.', ',', $value[2]).'</td>
              </tr>
              ';
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