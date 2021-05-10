<?php

date_default_timezone_set('America/Sao_Paulo');

session_start();
include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

if (isset($_GET['delete_produto'])) {
  $id = anti_injection($_GET['delete_produto']);
  delete_produto($id);
}

if (isset($_GET['alterar_produto'])) {
  $id = anti_injection($_GET['alterar_produto']);
  alterar_produto($id);
}

if (isset($_POST['submit'])) {
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



  </style>


</head>

<body>

  <?php include '../../../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <br>

    <div class="row">

      <div class="col-12">

        <form action="produtos.php" method="POST">
          <div class="input-group mb-4" style="width: 40vw ;padding: 0vw 4.5vw;">
            <input name="procurar_produto" value="<?php if(isset($_POST['submit'])) echo $search; ?>" type="text" class="form-control" placeholder="">
            <button name="submit" class="btn btn-outline" type="submit" style="font-weight: bolder;">Procurar</button>
            <button class="btn btn-outline" type="submit" style="margin-left: .2em;font-weight: bolder;">Listar Tudo</button>
          </div>
        </form>

        <table class="styled-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço</th>
              <th>Tipo</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php     


            if (isset($_POST['submit'])) {
              $search = anti_injection($_POST['procurar_produto']);
              $query  = "SELECT * FROM produto WHERE nome_produto LIKE '%$search%' ORDER BY nome_produto ASC";

            } else { 
              $query  = "SELECT * FROM produto ORDER BY nome_produto ASC";
            } 

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
                <td><?php echo $tipo ?></td>

                <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

                <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="fas fa-trash"></i></button></a></td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>


      

</body>

</html>