<?php

date_default_timezone_set('America/Sao_Paulo');

session_start();
include "../../../includes/functions.php";

autorizacao_super();

if (isset($_GET['delete_produto'])) {
  $id = anti_injection($_GET['delete_produto']);
  delete_produto($id);
}

if (isset($_GET['alterar_produto'])) {
  $id = anti_injection($_GET['alterar_produto']);
  alterar_produto($id);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Produtos</title>
  <link rel="icon" href="<?= LINK_SITE; ?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="<?= LINK_SITE; ?>assets/css/produtos.css" rel="stylesheet">
</head>

<body>

  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <br>

    <div class="row">
      <div class="col-4">
        <h1>Bar</h1>
        <br>
        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM produto WHERE tipo = 'bar' ORDER BY nome_produto ASC";
            $result = $con->query($query);

            foreach($result as $row) {

              $registro = true;
              $id    = $row['id_produto'];
              $tipo  = $row['tipo'];
              $nome_produto  = $row['nome_produto'];
              $preco = $row['preco'];

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $preco ?></td>
                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="fas fa-trash"></i></button></a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>


      <div class="col-4">
        <h1>Porções</h1>
        <br>
        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM produto WHERE tipo = 'porcao' ORDER BY nome_produto ASC";
            $result = $con->query($query);

            # NAO HÁ REGISTRO, MAS SE ELE ACHAR REGISTRO $registro = true
            $registro = false;

            foreach($result as $row) {

              $registro = true;
              $id    = $row['id_produto'];
              $tipo  = $row['tipo'];
              $nome_produto  = $row['nome_produto'];
              $preco = $row['preco'];

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $preco ?></td>
                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>">
                    <button" class="btn btn-outline-dark"><i class="fas fa-trash"></i></button>
                  </a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>

      <div class="col-4">
        <h1>Refeições</h1>
        <br>
        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM produto WHERE tipo = 'refeicao' ORDER BY nome_produto ASC";
            $result = $con->query($query);

            # NAO HÁ REGISTRO, MAS SE ELE ACHAR REGISTRO $registro = true
            $registro = false;

            foreach($result as $row) {

              $registro = true;
              $id    = $row['id_produto'];
              $tipo  = $row['tipo'];
              $nome_produto  = $row['nome_produto'];
              $preco = $row['preco'];

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $preco ?></td>
                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>">
                    <button" class="btn btn-outline-dark"><i class="fas fa-trash"></i></button>
                  </a></td>
              </tr>

            <?php } ?>

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
              <th>Nome</th>
              <th>Preço</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM produto WHERE tipo = 'lanche' ORDER BY nome_produto ASC";
            $result = $con->query($query);

            # NAO HÁ REGISTRO, MAS SE ELE ACHAR REGISTRO $registro = true
            $registro = false;

            foreach($result as $row) {

              $registro = true;
              $id    = $row['id_produto'];
              $tipo  = $row['tipo'];
              $nome_produto  = $row['nome_produto'];
              $preco = $row['preco'];

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $preco ?></td>
                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>">
                    <button" class="btn btn-outline-dark"><i class="fas fa-trash"></i></button>
                  </a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>

      <div class="col-4">
        <h1>Caldos</h1>
        <br>
        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM produto WHERE tipo = 'caldo' ORDER BY nome_produto ASC";
            $result = $con->query($query);

            # NAO HÁ REGISTRO, MAS SE ELE ACHAR REGISTRO $registro = true
            $registro = false;

            foreach($result as $row) {

              $registro = true;
              $id    = $row['id_produto'];
              $tipo  = $row['tipo'];
              $nome_produto  = $row['nome_produto'];
              $preco = $row['preco'];

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo $preco ?></td>
                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>">
                    <button" class="btn btn-outline-dark"><i class="fas fa-trash"></i></button>
                  </a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>
</body>

</html>