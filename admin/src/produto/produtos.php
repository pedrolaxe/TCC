<?php

date_default_timezone_set('America/Sao_Paulo');

session_start();
include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

if (isset($_POST['submit'])) {
  $id = anti_injection($_POST['id']);
  inativar_produto($id);
}

if (isset($_GET['alterar_produto'])) {
  $id = anti_injection($_GET['alterar_produto']);
  alterar_produto($id);
}

if (isset($_POST['submit_search'])) {
  $search = $_POST['procurar_produto'];
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

  <style type="text/css">
    
    .styled-table {
      width: 90vw;
      margin: 0 auto;
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

  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <br>

    <div class="row">

      <div class="col-12">

        <h1 style="padding: 0vw 3.5vw;">Produtos</h1>

        <br>

        <form action="produtos.php" method="POST">
          <div class="input-group mb-4" style="width: 40vw ;padding: 0vw 3.5vw;">
            <input name="procurar_produto" value="<?php if(isset($_POST['submit_search'])) echo $search; ?>" type="text" class="form-control" placeholder="" autocomplete="off">
            <button name="submit_search" class="btn btn-outline" type="submit" style="font-weight: bolder;">Procurar</button>
            <button class="btn btn-outline" type="submit" style="margin-left: .2em;font-weight: bolder;">Listar Tudo</button>
          </div>
        </form>


        <table class="styled-table" style="margin-bottom:3em">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço</th>
              <th>Descrição</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php     


            if (isset($_POST['submit_search'])) {
              $search = anti_injection($_POST['procurar_produto']);
              $query  = "SELECT * FROM produto WHERE nome_produto LIKE '%$search%' ORDER BY nome_produto ASC";

            } else { 
              $query  = "SELECT * FROM produto ORDER BY nome_produto ASC";
            } 

            $result = $con->query($query);

            foreach($result as $row) {

              $registro = true;
              $id             = $row['id_produto'];
              // $tipo          = $row['tipo'];
              $nome_produto   = $row['nome_produto'];
              $preco          = $row['preco'];
              $descricao      = $row['descricao'];
              $status_produto = $row['status_produto'];

              if ($status_produto != 'inativo') {

            ?>
              <tr>
                <td><?php echo $nome_produto ?></td>
                <td><?php echo number_format($preco, 2, ',', '.') ?></td>

                <td><?php echo $descricao ?></td>

                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><button class="btn btn-outline-dark trash" data-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#inativarProduto"><i class="fas fa-trash"></i></button></td>

              </tr>

            <?php } } ?>

          </tbody>
        </table>
      </div>

</body>

    <!-- CONFIRMAÇÂO PARA INATIVAR PRODUTO -->

    <!-- Modal -->
    <div class="modal fade" id="inativarProduto" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Inativar Produto</h5>
            <button type="button" class="btn-lg-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Tem certeza disso?
          </div>
          <form action="produtos.php" method="POST">

            <input id="id_inativar" name="id" hidden>

            <div class="modal-footer">
              <button type="button" class="btn-lg btn-outline-primary" data-bs-dismiss="modal">Não</button>
              <button class="btn-lg btn-outline-danger" name="submit" type="submit">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>


<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/jquery.js"></script>
<script type="text/javascript">
  
$(document).on("click", ".trash", function (e) {

  e.preventDefault();

  var _self = $(this);
  var id = _self.data('id');

  $("#id_inativar").val(id);

});


</script>

</html>