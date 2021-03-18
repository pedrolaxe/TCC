<?php
session_start();
include "../includes/functions.php";

autorizacao_super();

if (isset($_POST['submit'])) {
  insert_mesa();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Mesas</title>
  <link rel="icon" href="<?= LINK_SITE; ?>assets/img/logo.jpg">

  <?php include '../includes/head.php' ?>

  <link rel="stylesheet" type="text/css" href="<?= LINK_SITE; ?>assets/css/index.css" media="screen" />


</head>

<body>

  <!-- Header and Nav Content -->
  <?php include '../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <div class="row">

      <?php

      $query  = "SELECT * FROM MESA ORDER BY ABS(numero)";
      $result = mysqli_query($con, $query);

      while ($row = mysqli_fetch_array($result)) {

        $id      = $row['id_mesa'];
        $numero  = $row['numero'];


        // PARA APARECER MESA '09' EM VEZ DE '9' //
        if (strlen($numero) == 1) {
          $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
        }

        // NAO ESTÁ SENDO USADO AINDA //
        $status = $row['status'];

      ?>

        <div class="col-2">
          <div class="card mb-3 shadow mesa">
            <div class="card-header">
              <h4 class="my-0 fw-bold">

                <?php

                echo '<h2><a href="' . LINK_SITE . 'src/mesa/mesa.php?id=' . $id . '">Mesa ' . $numero . '</a>
              <a href="' . LINK_SITE . 'src/consumo/consumo.php?id=' . $id . '" style="float:right">+</a></h2>';

                ?>

              </h4>
            </div>

            <div class="card-body">
              <ul class="list-unstyled mb-2">

                <details>
                  <summary>Consumo</summary>


                  <?php

                  // VALOR TOTAL DA CONTA //
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

                    // $id_mesa e $id representam a mesma id mas por buscas diferentes para comparar uma com a outra na hora de
                    // mostrar os produtos para cada mesa corretamente
                    $id_mesa      = $row['id_mesa'];
                    $qtd          = $row['quantidade'];
                    $nome_produto = $row['nome_produto'];
                    // $preco        = $row['preco'];

                    if ($id == $id_mesa) {

                      // PRECO DO PRODUTO //
                      // echo '<li><b>'.$qtd.' x </b>'.$nome_produto.'<b style="float:right">'.number_format($qtd*$preco, 2, '.', ',').'</b></li>';

                      echo '<li><b>' . $qtd . ' x </b>' . $nome_produto . '</li>';


                      // $soma += $qtd*$preco;

                    }
                  }


                  // SOMA DOS PRODUTOS //
                  // echo '<br>';
                  // if($soma != 0) {
                  //   echo '<h3 style="float:right; font-style: italic; font-weight: bold">'.number_format($soma, 2, '.', ',').'</h3>';
                  // }

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