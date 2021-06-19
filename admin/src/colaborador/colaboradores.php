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
  inativar_colaborador($id);
}

// if (isset($_GET['inativar_colaborador'])) {
//   $id = $_GET['inativar_colaborador'];

//   // CRIAR FUNCAO
//   inativar_colaborador($id);
//   echo '<script>alert('.ID_userisadmin($id).')</script>';
// }

if (isset($_GET['edit_colaborador'])) {
  $id = $_GET['edit_colaborador'];

  // CRIAR FUNCAO
  //alterar_colaborador($id);
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

  <style type="text/css">
      
        .btn-outline {
    border: .2em solid black !important;
  }

  .btn-outline:hover {
    border: .2em solid white;
    background-color: black;
    color: white;
  }

  .styled-table {
    /*min-width: 30vw;*/
    width:80vw;
    border-collapse: collapse;
    /*margin: 5vh 0 0 35vw;*/
    font-size: 0.9em;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}


  </style>

</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container'>
    <br>

    <div class="row">
      <div class="col-12">
        <h1>Colaboradores</h1>
        <br>
        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Login</th>
              <th>CPF</th>
              <th>RG</th>
              <th>Telefone</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $query  = "SELECT * FROM colaborador WHERE tipo = 'colaborador' ORDER BY login ASC";
            $result = $con->query($query);

            foreach($result as $row) {

              $registro = true;

              $id                 = $row['id_colaborador'];
              $tipo               = $row['tipo'];
              $nome               = $row['nome_colaborador'];
              $login              = $row['login'];
              $cpf                = $row['cpf'];
              $rg                 = $row['rg'];
              $tel                = $row['telefone'];
              $status_colaborador = $row['status_colaborador'];

              if ($status_colaborador != 'inativo') {

            ?>
              <tr>
                <td><?php echo $nome ?></td>
                <td><?php echo $login ?></td>
                <td><?php echo $cpf ?></td>
                <td><?php echo $rg ?></td>
                <td><?php echo $tel ?></td>

                <td style="text-align: right; padding-left: 0"><a href="edit_colaborador.php?id_colaborador=<?=$id;?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><button class="btn btn-outline-dark trash" data-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#inativarColaborador"><i class="fas fa-trash"></i></button></td>

              </tr>

            <?php } } ?>

          </tbody>
        </table>
      </div>
    </div>
    <br>
    <a href="../../painel.php"><button class="w-10 btn btn-lg btn-outline">Voltar</button></a>
  </div>
</body>

<!-- CONFIRMAÇÂO PARA INATIVAR PRODUTO -->

    <!-- Modal -->
    <div class="modal fade" id="inativarColaborador" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Inativar Colaborador</h5>
            <button type="button" class="btn-lg-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Tem certeza disso?
          </div>
          <form action="colaboradores.php" method="POST">

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
  var id    = _self.data('id');

  $("#id_inativar").val(id);
});


</script>
</html>