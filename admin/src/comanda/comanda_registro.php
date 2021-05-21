<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query  = "SELECT * FROM comanda WHERE id_comanda = $id";
  $result = $con->query($query);

  foreach($result as $row) {
    $registro = true;
    $id       = $row['id_comanda'];
    $nome     = $row['nome'];
    $desconto = $row['desconto'];

    // if (strlen($nome) == 1) {
    //   $nome = str_pad($nome, 2, '0', STR_PAD_LEFT);
    // }

    $status = $row['status'];
  }
}

if (isset($_GET['delete_pedido'])) {
  $id_pedido  = $_GET['delete_pedido'];
  $id_comanda    = $_GET['id_comanda'];

  delete_pedido($id_pedido, $id_comanda);
}


if (isset($_GET['cancelar_comanda'])) {
  $id = $_GET['cancelar_comanda'];
  cancel_comanda($id);
}

if (isset($_POST['submit'])) {
  $id     = $_POST['fechar_comanda'];
  $total  = $_POST['total'];
  $nome = $_POST['nome'];

  fechar_comanda($id, $total);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Comanda</title>
  <link rel="icon" href="assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php' ?>

  <style>
    .pricing-header {
      max-width: 30vw;
    }

    .card-header {
      background-color: #88BDBC;
    }

    .card {
      /*width: 40vw;*/
      width: 30em;
      margin: 0 auto;
      /*margin-top: 3vh;*/
      background-color: #DEF2F1;
    }

    li {
      font-weight: bold;
    }

    i {
      color: black;
    }

    i.fa-trash:hover {
      color: red !important;
    }

    a:hover i.fa-arrow-left {
      color: #DEF2F1 !important;
    }
  </style>
</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include '../../../includes/header_admin.php'; ?>

  <main class="container-fluid">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <!-- <h1 class="display-4">comanda</h1> -->
    </div>
    <div class="card mb-4 shadow">
      <div class="card-header">
        <h1 class="my-0 fw-bold"><a href='<?php echo LINK_SITE; ?>admin/comandas.php'><i class="fas fa-arrow-left"></i></a><b style="float: right"><?php echo ucfirst($nome) ?></b></h1>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mt-3 mb-4">

          <?php

          $total = 0;

          $query2  = "

          SELECT * FROM PEDIDO 
          INNER JOIN PRODUTO ON 
          PEDIDO.id_produto = PRODUTO.id_produto 
          INNER JOIN comanda ON 
          PEDIDO.id_comanda = comanda.id_comanda

          ";

          $result2 = $con->query($query2);

          foreach($result2 as $row) {

            $id_comanda   = $row['id_comanda'];
            $id_pedido    = $row['id_pedido'];
            $qtd          = $row['quantidade'];
            $nome_produto = $row['nome_produto'];
            $preco        = $row['preco'];


            if ($id == $id_comanda) {

              echo
              '<li style="margin-bottom: 0.8em">' . $qtd . ' x ' . $nome_produto . '<b style="float:right">' . number_format($qtd * $preco, 2, '.', ',') . '
              </b></li>';

              $total += $qtd * $preco;
            }
          }

          echo '<hr class="style-one">';
          echo '<br>';

          echo

          '
     
      <form action="comanda.php" method="POST">

      <label>Desconto: </label>
      <input name="desconto" style="width:26%; border:0" value="R$ ' . $desconto . '" disabled>

      <br>

      <label>Status: </label>
      <input name="status" style="width:26%; border:0" value="' . ucfirst($status) . '" disabled>

      <br><br>
      
      <input name="fechar_comanda" value="' . $id . '" hidden>
      <input name="total" value="' . $total . '" hidden>
      <input name="nome" value="' . $nome . '" hidden>

      <div class="form-check form-switch" style="float:right;">  
       
        <br><br>

        <h2 style="float:right; font-style: italic; font-weight: bold">

        R$ <b id="total">' . number_format($total, 2, '.', ',') . '</b>

        </h2>

      </div>';


        

      

          ?>

        </ul>
      </div>
    </div>


    <!-- CONFIRMAÇÂO PARA DELETAR comanda -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Cancelar Comanda</h4>
            <button type="button" class="btn-lg-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Tem certeza disso?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-lg btn-outline-primary" data-bs-dismiss="modal">Não</button>
            <a href="comanda.php?cancelar_comanda='<?php echo $id ?>'"><button type="button" class="btn-lg btn-outline-danger">Sim</button></a>
          </div>
        </div>
      </div>
    </div>

  </main>
</body>
</html>