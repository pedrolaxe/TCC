<?php

session_start();

include "../../../includes/functions.php";

autorizacao_super();

// PEGAR INFORMAÇÕES DO USUARIO NO BANCO DE DADOS
$id = $_GET['id'];

// try {
//   $id = $_REQUEST_URI['get_id'];
// } catch(Exception $e) {
//   $id = $_GET['id'];
// }

$query  = "SELECT * FROM MESA WHERE id_mesa = $id";
$result_mesa = mysqli_query($con, $query);

while ($row = mysqli_fetch_array($result_mesa)) {

  $id_mesa = $row['id_mesa'];
  $numero_mesa = $row['numero'];
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Consumo</title>
  <link rel="icon" href="<?=LINK_SITE;?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

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
      ;

    }
  </style>
</head>

<body>

  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container-fluid'>

    <!-- <h1>Mesa <?php echo $numero_mesa; ?></h1> -->

    <form action="add_consumo.php" method="POST">

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
                <!-- <th>Preço</th> -->
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'bar'";
              $result = mysqli_query($con, $query);

              $count = 1;

              while ($row = mysqli_fetch_array($result)) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>

                <tr>
                  <td><input name="qtd_bar<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <!-- <td><?php echo $preco ?></td> -->
                  <!-- <td style="text-align: right; padding-right: 1vw;"> -->
                  <input name="id_produto_bar<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                  <!-- <input type="submit" value="+"></td> -->
                </tr>
                <!-- </form> -->

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
                <!-- <th>Preço</th> -->
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'porcao'";
              $result = mysqli_query($con, $query);

              $count = 1;

              while ($row = mysqli_fetch_array($result)) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <!-- <form action="add_consumo.php" method="POST"> -->
                <tr>
                  <td><input name="qtd_porcao<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <!-- <td><?php echo $preco ?></td> -->
                  <!-- <td style="text-align: right; padding-right: 1vw;"> -->
                  <input name="id_produto_porcao<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                  <!-- <input type="submit" value="+"></td> -->
                </tr>
                <!-- </form> -->

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
                <!-- <th>Preço</th> -->
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'refeicao'";
              $result = mysqli_query($con, $query);

              $count = 1;

              while ($row = mysqli_fetch_array($result)) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <!-- <form action="add_consumo.php" method="POST"> -->
                <tr>
                  <td><input name="qtd_refeicao<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <!-- <td><?php echo $preco ?></td> -->
                  <!-- <td style="text-align: right; padding-right: 1vw;"> -->
                  <input name="id_produto_refeicao<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                  <!-- <input type="submit" value="+"></td> -->
                </tr>
                <!-- </form> -->

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
                <!-- <th>Preço</th> -->
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'lanche'";
              $result = mysqli_query($con, $query);

              $count = 1;

              while ($row = mysqli_fetch_array($result)) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <!-- <form action="add_consumo.php" method="POST"> -->
                <tr>
                  <td><input name="qtd_lanche<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <!-- <td><?php echo $preco ?></td> -->
                  <!-- <td style="text-align: right; padding-right: 1vw;"> -->
                  <input name="id_produto_lanche<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                  <!-- <input type="submit" value="+"></td> -->
                </tr>
                <!-- </form> -->

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
                <!-- <th>Preço</th> -->
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>

              <?php

              $query  = "SELECT * FROM PRODUTO WHERE TIPO = 'caldo'";
              $result = mysqli_query($con, $query);

              $count = 1;

              while ($row = mysqli_fetch_array($result)) {

                $registro = true;
                $id_produto = $row['id_produto'];
                $tipo  = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco = $row['preco'];

              ?>
                <!-- <form action="add_consumo.php" method="POST"> -->
                <tr>
                  <td><input name="qtd_caldo<?php echo $count ?>" type="number" value="0" min="0" style="width:3em"></td>
                  <td><?php echo $nome_produto ?></td>
                  <!-- <td><?php echo $preco ?></td> -->
                  <!-- <td style="text-align: right; padding-right: 1vw;"> -->
                  <input name="id_produto_caldo<?php echo $count ?>" value="<?php echo $id_produto ?>" hidden>
                  <!-- <input type="submit" value="+"></td> -->
                </tr>
                <!-- </form> -->

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

  <input name="id_mesa" value="<?php echo $id_mesa ?>" hidden>
  <input name="numero_mesa" value="<?php echo $numero_mesa ?>" hidden>

  <center>
    <button class="btn btn-primary" style="width: 15em; height: 4em; margin-right: 1em" type="submit" name="tipo" value="normal">Pedido</button>
    <button class="btn btn-primary" style="width: 15em; height: 4em" type="submit" name="tipo" value="impressao">Pedido + Impressão</button>
  </center>

  </form>

  </div>

  <br><br><br>

</body>

</html>