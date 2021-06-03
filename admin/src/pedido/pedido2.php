<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

// PEGAR INFORMAÇÕES DA COMANDA NO BANCO DE DADOS
$id = $_GET['id'];

$query  = "SELECT * FROM comanda WHERE id_comanda = $id";
$result_comanda = $con->query($query);

foreach($result_comanda as $row) {

  $id_comanda = $row['id_comanda'];
  $nome_comanda = $row['nome'];
}

if (isset($_POST['submit'])) {
  $search = $_POST['procurar_produto'];
}

if (isset($_POST['submit_carrinho'])) {

  $id_produto   = $_POST['id_produto'];
  $qtd          = $_POST['qtd'];
  // $nome_produto = $_POST['nome_produto'];
  // $preco        = $_POST['preco'];

  // echo $id_produto."<br>";
  // echo $qtd."<br>";
  // echo $nome_produto."<br>";
  // echo $preco;

}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Pedido</title>
  <link rel="icon" href="<?= LINK_SITE; ?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
  <link href="<?= LINK_SITE; ?>assets/css/produtos.css" rel="stylesheet">

  <style type="text/css">
    
  .styled-table {
    margin: 0 auto;
  }

  .btn-outline-success {
    border-color: #5cb85c;
    color: #5cb85c;
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

      <?php

        if(isset($_GET['pedido']) && $_GET['pedido'] == "feito") {
          echo '<div style="width:15em; margin:0 auto;" class="alert alert-success" role="alert"><center>O Pedido Foi Inserido</center></div>';
        }

      ?>

    <div class="row">

      <div class="col-5" style="padding:0 !important">

        <h1 style="padding: 0vw 4.5vw;">Adicionar Pedido</h1>
        <h2 style="padding: 0vw 4.5vw;"><?php echo "Nome: ".ucfirst($nome_comanda) ?></h2> 
        
        <br>       

        <form action="pedido2.php?id=<?php echo $id ?>" method="POST">
          <div class="input-group mb-4" style="padding: 0vw 4.5vw;">
            <input name="procurar_produto" value="<?php if(isset($_POST['submit'])) echo $search; ?>" type="text" class="form-control" placeholder="" autocomplete="off">

            <button name="submit" class="btn btn-outline" type="submit" style="font-weight: bolder;">Procurar</button>
            <button name="submit_tudo" class="btn btn-outline" type="submit" style="margin-left: .2em;font-weight: bolder;">Listar Tudo</button>

          </div>
        </form>

        <br>

        <a style="padding: 0vw 4.5vw;" href="../../comandas.php"><button class="w-10 btn btn-lg btn-outline">Voltar</button></a>

      </div>


      <div class="col-5" style="padding:0 !important">

        <?php     


        if (isset($_POST['submit']) || isset($_POST['submit_tudo'])) {
                  
                  $search = anti_injection($_POST['procurar_produto']);

                  if (isset($_POST['submit'])) {
                    $query  = "SELECT * FROM produto WHERE nome_produto LIKE '%$search%' ORDER BY nome_produto ASC";
                  } elseif (isset($_POST['submit_tudo'])) {
                    $query  = "SELECT * FROM produto ORDER BY nome_produto ASC";
                  }

                  $result = $con->query($query);

                  if($result->rowCount() > 0) {

                    echo '<table class="styled-table">
                    <thead>
                      <tr>
                        <th>Qtd</th>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>';

                  } else { echo '<h1>Sem Resultado</h1>'; }

                foreach($result as $row) {

                  $registro = true;
                  $id_produto    = $row['id_produto'];
                  // $tipo          = $row['tipo'];
                  $nome_produto  = $row['nome_produto'];
                  $preco         = $row['preco'];
                  $descricao     = $row['descricao'];

              ?>
                <form action="pedido2.php?id=<?php echo $id ?>" method="POST">

                <tr>

                  <td><input name="qtd" type="number" value="0" min="0" style="width:3em"></td>
                  <td><input name="nome_produto" type="text" value="<?php echo $nome_produto ?>" style="width:10em; border: none;background-color:transparent;" readyonly></td>
                  <td><input name="preco" type="text" value="<?php echo str_replace('.', ',', $preco) ?>" style="width:3em; border: none;background-color:transparent;" readyonly></td>

                  <td style="text-align: right; padding-left: 0">
                    <button name="submit_carrinho" class="btn btn-outline-success">
                      <i class="fas fa-check"></i>
                    </button>
                  </td>

                    <input name="id_produto" value="<?php echo $id_produto ?>" hidden>
                </tr> 

                </form>

              <?php } } ?>

          </tbody>
        </table>

        <?php     


              if (isset($_POST['submit_carrinho'])) {

            echo '<table class="styled-table">
              <thead>
                <tr>
                  <th>Qtd</th>
                  <th>Produto</th>
                  <th>Preço</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

                <form action="add_pedido2.php" method="POST">';


                // $search = anti_injection($_POST['procurar_produto']);
                $query  = "SELECT * FROM produto WHERE id_produto=$id_produto";

                $result = $con->query($query);

              foreach($result as $row) {

                $registro = true;
                $id_produto    = $row['id_produto'];
                // $tipo          = $row['tipo'];
                $nome_produto  = $row['nome_produto'];
                $preco         = $row['preco'];
                $descricao     = $row['descricao'];

              ?>
                <tr>

                  <td><input name="qtd" value="<?php echo $qtd ?>" type="number" value="0" min="0" style="width:3em; border: none;background-color:transparent;" readonly></td>
                  <td><input name="nome_produto" value="<?php echo $nome_produto ?>" style="width:10em;; border: none;background-color:transparent;" readonly></td>
                  <td><input name="preco" value="<?php echo str_replace('.', ',', $preco) ?>" style="width:3.5em; border: none;background-color:transparent;" readonly></td>
                  <td></td>

                    <input name="id_produto" value="<?php echo $id_produto ?>" hidden>

                    <input name="id_comanda" value="<?php echo $id_comanda ?>" hidden>
                    <input name="nome_comanda" value="<?php echo $nome_comanda ?>" hidden>
                </tr> 

              <?php } } ?>


                  <td></td>
                  <td></td>
                  <td><?php 

                  if(isset($qtd)) {

                  echo number_format($preco*$qtd, 2, ',', '.');

                }

                  ?></td>
                  <td></td>
              </tbody>
            </table>
              <br>

                <?php 

                if (isset($_POST['submit_carrinho'])) {

                echo '<button class="btn btn-outline-success" type="submit" name="tipo" value="normal" style="font-weight: bolder; float: right; margin-right: 6vw">Confirmar</button>';
                echo '</form>';

                }

                ?>

      </div>


      

    </div>

      <br><br>

</body>

</html>