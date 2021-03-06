<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

// PEGAR INFORMAÇÕES DO COLABORADOR NO BANCO DE DADOS
$id = $_GET['id'];

// try {
//   $id = $_REQUEST_URI['get_id'];
// } catch(Exception $e) {
//   $id = $_GET['id'];
// }

$query  = "SELECT * FROM comanda WHERE id_comanda = $id";
$result_comanda = $con->query($query);

foreach($result_comanda as $row) {

  $id_comanda = $row['id_comanda'];
  $nome_comanda = $row['nome'];
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Pedido</title>
  <link rel="icon" href="<?=LINK_SITE;?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="<?=LINK_SITE;?>assets/css/produtos.css" rel="stylesheet">

  <style type="text/css">
    a:hover {
      color: #88BDBC;
    }

    a.fw-normal:hover {
      color: white;
    }

    input[type=number] {
      border: 2px solid #88BDBC;
      border-radius: 2px;
      /*      color: #6E6658;*/
      font-weight: bolder;
    }

    input[type=number]:focus {
      border: 2px solid #6E6658;
    }
    
    button {
      border: 3px solid black !important;
      background-color: white !important;
      color: black !important;
    }

    button:hover {
      border: 3px solid white;
      background-color: black !important;
      color: white !important;
    }

  </style>
</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <!-- <h1>comanda <?php echo $nome_comanda; ?></h1> -->
    <form action="add_pedido.php" method="POST">

      <br>

      <div class="row">
        <div class="col-4">
          <h1>Bar</h1>
          <br>
          <table class="styled-table">
            <thead>
              <tr>
                <th>Qtd</th>
                <th>Nome</th>
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'bar'";
              $result = $con->query($query);

              $count = 1;

              foreach($result as $row) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>

                <tr>
                  <td><input name="qtd_bar<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <input name="id_produto_bar<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                </tr>

                <?php

                $count += 1;

              } ?>

            </tbody>
          </table>
        </div>

        <div class="col-4">
          <h1>Porções</h1>
          <br>
          <table class="styled-table">
            <thead>
              <tr>
                <th>Qtd</th>
                <th>Nome</th>
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'porcao'";
              $result = $con->query($query);

              $count = 1;

              foreach($result as $row) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>

                <tr>
                  <td><input name="qtd_porcao<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <input name="id_produto_porcao<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                </tr>

                <?php

                $count += 1;

              } ?>

            </tbody>
          </table>
        </div>

        <div class="col-4">

          <h1>Refeições</h1>
          <br>
          <table class="styled-table">
            <thead>
              <tr>
                <th>Qtd</th>
                <th>Nome</th>
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'refeicao'";
              $result = $con->query($query);

              $count = 1;

              foreach($result as $row) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <tr>
                  <td><input name="qtd_refeicao<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <input name="id_produto_refeicao<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                </tr>

                <?php

                $count += 1;

              } ?>

            </tbody>
          </table>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-4">
          <h1>Lanches</h1>
          <br>
          <table class="styled-table">
            <thead>
              <tr>
                <th>Qtd</th>
                <th>Nome</th>
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'lanche'";
              $result = $con->query($query);

              $count = 1;

              foreach($result as $row) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <tr>
                  <td><input name="qtd_lanche<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <input name="id_produto_lanche<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                </tr>

                <?php

                $count += 1;

              } ?>

            </tbody>
          </table>
        </div>


        <div class="col-4">
          <h1>Caldos</h1>
          <br>
          <table class="styled-table">
            <thead>
              <tr>
                <th>Qtd</th>
                <th>Nome</th>
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'caldo'";
              $result = $con->query($query);

              $count = 1;

              foreach($result as $row) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <tr>
                  <td><input name="qtd_caldo<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <input name="id_produto_caldo<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                </tr>

                <?php

                $count += 1;

              } ?>

            </tbody>
          </table>
        </div>
        </table>
      </div>
  </div>

  <br><br>

  <input name="id_comanda" value="<?php echo $id_comanda ?>" hidden>
  <input name="nome_comanda" value="<?php echo $nome_comanda ?>" hidden>

  <center>
    <button class="btn btn-lg btn-outline" style="width: 15em; height: 4em; margin-right: 1em" type="submit" name="tipo" value="normal">Pedido</button>
    <button class="btn btn-lg btn-outline" style="width: 15em; height: 4em" type="submit" name="tipo" value="impressao">Pedido + Impressão</button>
  </center>

  </form>

  </div>

  <br><br><br>

</body>
</html>