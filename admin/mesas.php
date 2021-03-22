<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

# ARMAZENAR USER ID PARA CONTROLE DE ACESSO
if (isset($_GET['user_id'])) {
  $_SESSION['user_id'] = $_GET['user_id'];
} else { }


if (isset($_POST['submit'])) {
  insert_mesa();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mesas</title>
  <link rel="icon" href="<?= LINK_SITE; ?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= LINK_SITE; ?>assets/css/index.css" media="screen" />
</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include '../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <div class="row">

      <?php

      $query  = "SELECT * FROM MESA ORDER BY ABS(numero)";
      $result = mysqli_query($con, $query);

      while ($row = mysqli_fetch_array($result)) {

        $id      = $row['id_mesa'];
        $numero  = $row['numero'];


        # PARA APARECER MESA '09' EM VEZ DE '9'
        if (strlen($numero) == 1) {
          $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
        }

        # NAO ESTÁ SENDO USADO AINDA
        // $status = $row['status'];

      ?>

        <div class="col-2">
          <div class="card mb-3 shadow mesa">
            <div class="card-header">
              <h4 class="my-0 fw-bold">

                <?php

                echo '<h2><a href="' . LINK_SITE . 'admin/src/mesa/mesa.php?id=' . $id . '">Mesa ' . $numero . '</a>
              <a href="' . LINK_SITE . 'admin/src/consumo/consumo.php?id=' . $id . '" style="float:right">+</a></h2>';

                ?>

              </h4>
            </div>

            <div class="card-body">
              <ul class="list-unstyled mb-2">

                <details>
                  <summary>Consumo</summary>

                  <?php

                  # VALOR TOTAL DA CONTA 
                  $soma = 0;

                  $query2  = "

                  SELECT * FROM CONSUMO 
                  INNER JOIN PRODUTO ON 
                  CONSUMO.id_produto = PRODUTO.id_produto 
                  INNER JOIN MESA ON 
                  CONSUMO.id_mesa = MESA.id_mesa
                  
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