<?php

date_default_timezone_set('America/Sao_Paulo');

session_start();
include "../../../includes/functions.php";

autorizacao_super();

if (isset($_GET['delete_funcionario'])) {
  $id = $_GET['delete_funcionario'];

  // CRIAR FUNCAO
  delete_funcionario($id);
  echo '<script>alert('.ID_userisadmin($id).')</script>';
}

if (isset($_GET['edit_funcionario'])) {
  $id = $_GET['edit_funcionario'];

  // CRIAR FUNCAO
  //alterar_funcionario($id);
  echo '<script>alert('.ID_userisadmin($id).')</script>';
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Produtos</title>
  <link rel="icon" href="<?=LINK_SITE;?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="<?=LINK_SITE;?>assets/css/produtos.css" rel="stylesheet">
</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container'>
    <br>

    <div class="row">
      <div class="col-6">
        <h1>Funcionários</h1>
        <br>
        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM usuario WHERE tipo = 'funcionario' ORDER BY login ASC";
            $result = $con->query($query);

            foreach($result as $row) {

              $registro = true;
              $id    = $row['id_usuario'];
              $tipo  = $row['tipo'];
              $nome_produto  = $row['login'];
              // $preco = $row['preco'];

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td style="text-align: right; padding-left: 0"><a href="edit_funcionario.php?id_funcionario=<?=$id;?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="funcionarios.php?delete_funcionario=<?=$id;?>"><button class="btn btn-outline-dark"><i class="fas fa-trash"></i></button></a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>
    <br>
    <a href="../../config.php"><button class="w-10 btn btn-lg btn-outline-secondary">Voltar</button></a>
  </div>
</body>
</html>