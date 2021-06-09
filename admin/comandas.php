<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

# ARMAZENAR USER ID PARA CONTROLE DE ACESSO
// if (isset($_GET['user_id'])) {
//   $_SESSION['user_id'] = $_GET['user_id'];
// } else { }

if (isset($_GET['impressora'])) {
  if($_GET['impressora'] ==  false) {
    echo '<div style="margin:0 auto;" class="alert alert-warning" role="alert"><center>A Impressora Não Está Configurada</center></div>';
  }
}

if (isset($_POST['submit'])) {
  insert_comanda();
}

// echo $_SESSION['login_usuario'];

?>

<!DOCTYPE html>
<html>
<head>
  <title>Comandas</title>
  <link rel="icon" href="<?= LINK_SITE; ?>assets/img/logo.jpg">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= LINK_SITE; ?>assets/css/index.css" media="screen" />
</head>

<body>

  <!-- HEADER AND NAV -->
  <?php include '../includes/header_admin.php'; ?>

  <div class='container-fluid'>
    <div class="row">

      <?php

      $query  = "SELECT * FROM comanda WHERE status = 'aberto' ORDER BY ABS(nome)";
      $result = $con->query($query);
      // echo var_dump($result);

      foreach($result as $row) {

        $id      = $row['id_comanda'];
        $nome  = $row['nome'];


        # PARA APARECER comanda '09' EM VEZ DE '9'
        // if (strlen($nome) == 1) {
        //   $nome = str_pad($nome, 2, '0', STR_PAD_LEFT);
        // }

        # NAO ESTÁ SENDO USADO AINDA
        // $status = $row['status'];

      ?>

        <div class="col-2">
          <div class="card mb-3 shadow comanda">
            <div class="card-header">
              <h4 class="my-0 fw-bold">

                <?php

                echo '<h2><a href="' . LINK_SITE . 'admin/src/comanda/comanda.php?id=' . $id . '">' . ucfirst($nome) . '</a>
              <a href="' . LINK_SITE . 'admin/src/pedido/pedido2.php?id=' . $id . '" style="float:right">+</a></h2>';

                ?>

              </h4>
            </div>

            <div class="card-body">
              <ul class="list-unstyled mb-2">

                <details>
                  <summary>Pedidos</summary>

                  <?php

                  # VALOR TOTAL DA CONTA 
                  $soma = 0;

                  $query2  = "

                  SELECT * FROM PEDIDO 
                  INNER JOIN PRODUTO ON 
                  PEDIDO.id_produto = PRODUTO.id_produto 
                  INNER JOIN comanda ON 
                  PEDIDO.id_comanda = comanda.id_comanda
                  
                  ";

                   $result2 = $con->query($query2);

                  foreach($result2 as $row) {
                    $id_comanda    = $row['id_comanda'];
                    $qtd           = $row['quantidade'];
                    $nome_produto  = $row['nome_produto'];
                    $status_pedido = $row['status_pedido'];

                    # VERIFICAR SE A comanda DA PRIMEIRA BUSCA É IGUAL A DA SEGUNDA PARA ADICIONAR OS PRODUTOS NA comanda CORRETA
                    if ($id == $id_comanda && $status_pedido != 'cancelado') {
                      echo '<li><b>' . $qtd . ' x </b>' . $nome_produto . '</li>';
                    }
                  }

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