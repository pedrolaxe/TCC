<?php

session_start();
include "includes/functions.php";

autorizacao();

# ARMAZENAR USER ID PARA CONTROLE DE ACESSO
if (isset($_GET['user_id'])) {
  $_SESSION['user_id'] = $_GET['user_id'];
} else { }

if (isset($_GET['impressora'])) {
  if($_GET['impressora'] ==  false) {
    echo '<div margin:0 auto;" class="alert alert-danger" role="alert"><center>A Impressora Não Está Configurada</center></div>';
  }
}

if (isset($_POST['submit'])) {
  insert_mesa();
} else { }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Mesas</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include 'includes/head.php' ?>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/index.css" media="screen" />
</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include 'includes/header.php'; ?>

  <div class='container-fluid'>
    <div class="row">

      <?php

      $query  = "SELECT * FROM mesa ORDER BY ABS(numero)";
      //$result = mysqli_query($con, $query);

      $q = $con->query($query);
     
      while($row = $q->fetch_assoc()) {

        $id      = $row['id_mesa'];
        $numero  = $row['numero'];

        // PARA APARECER MESA '09' EM VEZ DE '9' //
        if (strlen($numero) == 1) {
          $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
        }

        // NAO ESTÁ SENDO USADO AINDA //
        // $status = $row['status'];

      ?>

        <div class="col-2">
          <div class="card mb-3 shadow mesa">
            <div class="card-header">
              <h4 class="my-0 fw-bold">

                <?php

                echo '
                <h2><a href="src/mesa/mesa.php?id=' . $id . '">Mesa ' . $numero . '</a>
                <a href="src/pedido/pedido.php?id=' . $id . '" style="float:right">+</a></h2>';

                ?>

              </h4>
            </div>

            <div class="card-body">
              <ul class="list-unstyled mb-2">

                <details>
                  <summary>Pedidos</summary>

                  <?php

                  // VALOR TOTAL DA CONTA //
                  $soma = 0;

                  $query2  = "

                  SELECT * FROM pedido 
                  INNER JOIN produto ON 
                  pedido.id_produto = produto.id_produto 
                  INNER JOIN mesa ON 
                  pedido.id_mesa = mesa.id_mesa
                  
                  ";

                  $result2 = mysqli_query($con, $query2);

                  while ($row = mysqli_fetch_array($result2)) {
                    $id_mesa      = $row['id_mesa'];
                    $qtd          = $row['quantidade'];
                    $nome_produto = $row['nome_produto'];

                    # VERIFICAR SE A MESA DA PRIMEIRA BUSCA É IGUAL A DA SEGUNDA PARA ADICIONAR OS PRODUTOS NA MESA CORRETA
                    if ($id == $id_mesa) {
                      echo '<li><b>' . $qtd . ' x </b>' . $nome_produto . '</li>';
                    }
                  }

                  ?>

                </details>
              </ul>
            </div>
          </div>
        </div>

      <?php } ?>

    </div>
  </div>
</body>
</html>