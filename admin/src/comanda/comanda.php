<?php

session_start();
include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);


try {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query  = "SELECT * FROM comanda WHERE id_comanda = $id";
    $result = $con->query($query);

    foreach($result as $row) {
      $registro = true;
      $id       = $row['id_comanda'];
      $nome     = $row['nome'];
      $desconto = $row['desconto'];

      $status = $row['status'];
    }
  }
} catch (Exception $e) {}

try {
  if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query  = "SELECT * FROM comanda WHERE id_comanda = $id";
    $result = $con->query($query);

    foreach($result as $row) {
      $registro = true;
      $id       = $row['id_comanda'];
      $nome     = $row['nome'];
      $desconto = $row['desconto'];

      $status = $row['status'];
    }
  }
} catch (Exception $e) {}

if (isset($_GET['cancelar_pedido'])) {
  $id_pedido     = $_GET['cancelar_pedido'];
  $id_comanda    = $_GET['id_comanda'];

  cancel_pedido($id_pedido, $id_comanda);
}


// if (isset($_GET['cancelar_comanda'])) {
//   $id = $_GET['cancelar_comanda'];
//   cancel_comanda($id);
// }


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

    i.fa-times:hover {
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

      <?php

      if(isset($_GET['senha_incorreta']) && $_GET['senha_incorreta'] == true) {
        echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Senha Incorreta</center></div>';
      }

      if (isset($_GET['impressora'])) {
        if($_GET['impressora'] ==  false) {
          echo '<div  style="width:15em; margin:0 auto;" class="alert alert-warning" role="alert"><center>A Impressora Não Está Configurada Em Configurações Gerais</center></div>';
        } else {
          echo '<div  style="width:15em; margin:0 auto;" class="alert alert-success" role="alert"><center>Impressão Realizada</center></div>';
        }
      }

      if (isset($_POST['submit'])) {

  # IMPRIMIR CONTA
  if(isset($_POST['impressao'])) {
    $id        = $_POST['id'];
    $total     = $_POST['total'];
    $nome      = $_POST['nome'];

    imprimir_nota($id, $total);
  }

  # FECHAR CONTA
  elseif(isset($_POST['total'])) {
    $id       = $_POST['id'];
    $total    = $_POST['total'];
    $nome     = $_POST['nome'];
    $cartao   = $_POST['cartao'];
    $dinheiro = $_POST['dinheiro'];
    $pix      = $_POST['pix'];

    $total = str_replace(',', '.', $total);
    $cartao = str_replace(',', '.', $cartao);
    $dinheiro = str_replace(',', '.', $dinheiro);
    $pix = str_replace(',', '.', $pix);
    $desconto = str_replace(',', '.', $desconto);

    $total = number_format(floatval($total), 2);
    $cartao = number_format(floatval($cartao), 2);
    $dinheiro = number_format(floatval($dinheiro), 2);
    $pix = number_format(floatval($pix), 2);
    $desconto = number_format(floatval($desconto), 2);

    $total_aux = number_format(($cartao+$dinheiro+$pix), 2);

    // echo "CARTAO: ".$cartao."<br>";
    // echo "DINHEIRO: ".$dinheiro."<br>";
    // echo "PIX: ".$pix."<br>";
    // echo "DESCONTO: ".$desconto."<br>";
    // echo "TOTAL AUX: ".$total_aux."<br>";
    // echo "TOTAL: ".($total-$desconto)*1.1;

    $total_desconto_dez = number_format((($total - $desconto)*1.1), 2);
    $total_desconto = number_format(($total - $desconto), 2);

    if( $total_desconto != $total_aux && $total_desconto_dez != $total_aux ) {
      echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>Valor Pago Diferente do Total</center></div>';
    } else {
      fechar_comanda($id, $total, $cartao, $dinheiro, $pix);
    }

    # CANCELAR COMANDA
  } elseif(isset($_POST['observacao'])) {
    $id    = $_POST['id'];
    $senha = $_POST['senha'];
    $obs   = $_POST['observacao'];

    cancel_comanda($id, $senha, $obs);

    # CANCELAR PEDIDO
  } elseif(isset($_POST['id_pedido'])) {
    $id        = $_POST['id'];
    $senha     = $_POST['senha'];
    $id_pedido = $_POST['id_pedido'];

    cancel_pedido($id, $senha, $id_pedido);

    
  }

}

      ?>


    </div>
    <div class="card mb-4 shadow">
      <div class="card-header">
        <h1 class="my-0 fw-bold"><a href='<?php echo LINK_SITE; ?>admin/comandas.php'><i class="fas fa-arrow-left"></i></a><b style="float: right"><?php echo ucfirst($nome) ?></b></h1>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mt-3 mb-4">

          <?php

          $total = 0;
          $flagCancelado = false;

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
            $id_pedido     = $row['id_pedido'];
            $qtd           = $row['quantidade'];
            $nome_produto  = $row['nome_produto'];
            $valor         = $row['valor'];
            $status_pedido = $row['status_pedido'];


            if ($id == $id_comanda) {

              # Flag para escrever "Itens Cancelados"
              if ($status_pedido == 'cancelado') {
                $flagCancelado = true;
              } else {

                echo
                '<li style="margin-bottom: 0.8em">' . $qtd . ' x ' . $nome_produto . '<b style="float:right">' . number_format($qtd * $valor, 2, ',', '.') . '
                <i data-id="'. $id_pedido .'" data-qtd="'. $qtd .'" data-nome_pedido="'. $nome_produto .'" data-bs-toggle="modal" data-bs-target="#cancelarPedido" class="fas fa-times" style="padding-left:0.3em"></i></b></li>';

                $total += $qtd * $valor;
              }
            }
          }

          if($flagCancelado == true) {
            echo '<hr class="style-one">';
            echo '<h3><u>Itens Cancelados</u></h3>';
          }

          $result2 = $con->query($query2);

          foreach($result2 as $row) {

            $id_comanda    = $row['id_comanda'];
            $id_pedido     = $row['id_pedido'];
            $qtd           = $row['quantidade'];
            $nome_produto  = $row['nome_produto'];
            $valor         = $row['valor'];
            $status_pedido = $row['status_pedido'];


            if ($id == $id_comanda && $status_pedido == 'cancelado') {

              echo
              '<li style="margin-bottom: 0.8em">' . $qtd . ' x ' . $nome_produto . '</li>';

              
            }
          }

          echo '<hr class="style-one">';
          echo '<br>';

         

        if($desconto != 0 && $is_admin) {

          echo '

          <div class="form-check form-switch" style="float:right; margin-top:10vh">

        <h4 style="float:right; font-style: italic; font-weight: bold">

        Subtotal <b id="">' . number_format($total, 2, ',', '.') . '</b>

        </h4>
       
        <br>


          <h5 style="float:right; font-style: italic; font-weight: bold">

          Desconto <b id="">' . number_format($desconto, 2, ',', '.') . '</b>

          </h5>

          <br>

          <h5 style="float:right; font-style: italic; font-weight: bold">

          Subtotal c/ Desconto <b id="">' . number_format($total-$desconto, 2, ',', '.') . '</b>

          </h5>

          <br><br>
          ';

        } elseif ($desconto == 0 && $is_admin) { 

        echo '

        <div class="form-check form-switch" style="float:right; margin-top:20vh">

        <h4 style="float:right; font-style: italic; font-weight: bold">

        Subtotal <b id="">' . number_format($total, 2, ',', '.') . '</b>

        </h4>

        <br><br>

        ';
      } elseif ($desconto != 0) {
        echo '

          <div class="form-check form-switch" style="float:right">

        <h4 style="float:right; font-style: italic; font-weight: bold">

        Subtotal <b id="">' . number_format($total, 2, ',', '.') . '</b>

        </h4>
       
        <br>


          <h5 style="float:right; font-style: italic; font-weight: bold">

          Desconto <b id="">' . number_format($desconto, 2, ',', '.') . '</b>

          </h5>

          <br>

          <h5 style="float:right; font-style: italic; font-weight: bold">

          Subtotal c/ Desconto <b id="">' . number_format($total-$desconto, 2, ',', '.') . '</b>

          </h5>

          <br><br>
          ';
      } else {
        echo '

        <div class="form-check form-switch" style="float:right">

        <h4 style="float:right; font-style: italic; font-weight: bold">

        Subtotal <b id="">' . number_format($total, 2, ',', '.') . '</b>

        </h4>

        <br><br>

        ';
      }

        echo '

        <h5 style="float:right; font-style: italic; font-weight: bold">

        Serviço <b id="">' . number_format(($total-$desconto)*0.1, 2, ',', '.') . '</b>

        </h5>

        <br>

        <h2 style="float:right; font-style: italic; font-weight: bold">

        Total <b id="total">' . number_format(($total-$desconto)*1.1, 2, ',', '.') . '</b>

        </h2>

      </div>';

      if($is_admin) {

      echo '<button style="width: 10.4em" class="btn-lg btn-outline-dark" data-bs-toggle="modal" data-bs-target="#fecharConta">Fechar Conta</button>

      <button style="margin-top:5px; width: 10.4em" class="btn-lg btn-outline-dark" data-bs-toggle="modal" data-bs-target="#imprimirConta">Imprimir Conta</button>

      <a href="trocar_comanda.php?id=' . $id . '">
        <button style="margin-top:5px; width: 10.4em" class="btn-lg btn-outline-dark">Trocar Comanda</button>
      </a>

        <a href="desconto.php?id=' . $id . '&total='. $total * 1.1 . '">
        <button style="display:inline; margin-top:5px; width: 10.4em;" type="button" class="btn-lg btn-outline-dark">Desconto</button>
      </a>

      <button style="margin-top:5px;width: 10.4em" class="btn-lg btn-outline-dark" data-bs-toggle="modal" data-bs-target="#cancelarComanda">Cancelar Comanda</button>';

      } else {

         echo '<button style="float:left;width: 10.4em; margin-top: 0vh" class="btn-lg btn-outline-dark" data-bs-toggle="modal" data-bs-target="#fecharConta">Fechar Conta</button>


         <button style="margin-top:5px; width: 10.4em" class="btn-lg btn-outline-dark" data-bs-toggle="modal" data-bs-target="#imprimirConta">Imprimir Conta</button>


      <a href="trocar_comanda.php?id=' . $id . '">
        <button style="margin-top:5px; width: 10.4em" class="btn-lg btn-outline-dark">Trocar Comanda</button>
      </a>';

      }
      

          ?>

        </ul>
      </div>
    </div>

    <!-- CONFIRMAÇÂO PARA CANCELAR PEDIDO -->

    <!-- Modal -->
    <div class="modal fade" id="cancelarPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cancelar Pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="comanda.php" method="POST">
            <div class="modal-body">

                <?php

                echo '<input name="id" value="' . $id . '" hidden>';

                ?>

                <input type="text" name="id_pedido" class="form-control" id="id_pedido" hidden>

                <div class="mb-3">
                  <label for="recipient-name" class="col-form-label">Senha do Administrador</label>
                  <input type="password" name="senha" class="form-control" id="recipient-name" required autofocus>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Pedido</label>
                  <input style="border:0; background-color: #DEF2F1; font-weight: bolder" type="text" class="form-control" id="pedido" readonly>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn-lg btn-outline-primary" data-bs-dismiss="modal">Não</button>
              <button type="submit" name="submit" class="btn-lg btn-outline-danger">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <!-- CONFIRMAÇÂO PARA FECHAR CONTA -->

    <!-- Modal -->
    <div class="modal fade" id="fecharConta" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Fechar Conta</h5>
            <button type="button" class="btn-lg-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Tem certeza disso?
            <br><br>
          <form action="comanda.php" method="POST">

            <?php

            echo 
            '

              <input name="id" value="' . $id . '" hidden>
              <input name="total" value="' . $total . '" hidden>
              <input name="nome" value="' . $nome . '" hidden>


            '

            ?>

              <div class="mb-3" align="center">
                <label class="col-form-label">Cartão</label>
                <input type="money" name="cartao" class="form-control" style="width: 30%; text-align: center" autofocus>

                <label class="col-form-label">Dinheiro</label>
                <input type="money" name="dinheiro" class="form-control" style="width: 30%; text-align: center">

                <label class="col-form-label">Pix</label>
                <input type="money" name="pix" class="form-control" style="width: 30%; text-align: center">
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn-lg btn-outline-primary" data-bs-dismiss="modal">Não</button>
              <button class="btn-lg btn-outline-danger" name="submit" type="submit">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>


        <!-- CONFIRMAÇÂO PARA IMPRIMIR CONTA -->

    <!-- Modal -->
    <div class="modal fade" id="imprimirConta" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Imprimir Conta</h5>
            <button type="button" class="btn-lg-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Tem certeza disso?
          </div>
          <form action="comanda.php" method="POST">

            <?php

            echo 
            '

              <input name="id" value="' . $id . '" hidden>
              <input name="total" value="' . $total . '" hidden>
              <input name="nome" value="' . $nome . '" hidden>
              <input name="impressao" value="' . true . '" hidden>


            '

            ?>

            <div class="modal-footer">
              <button type="button" class="btn-lg btn-outline-primary" data-bs-dismiss="modal">Não</button>
              <button class="btn-lg btn-outline-danger" name="submit" type="submit">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>



    <!-- CONFIRMAÇÂO PARA CANCELAR COMANDA -->

    <!-- Modal -->
    <div class="modal fade" id="cancelarComanda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #DEF2F1;">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cancelar Comanda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="comanda.php" method="POST">
            <div class="modal-body">

                <?php

                echo '<input name="id" value="' . $id . '" hidden>';

                ?>

                <div class="mb-3">
                  <label for="recipient-name" class="col-form-label">Senha do Administrador</label>
                  <input type="password" name="senha" class="form-control" id="recipient-name" required autofocus>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Observação</label>
                  <textarea type="text" name="observacao" class="form-control" id="message-text" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn-lg btn-outline-primary" data-bs-dismiss="modal">Não</button>
              <button type="submit" name="submit" class="btn-lg btn-outline-danger">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </main>
</body>

<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/jquery.js"></script>

<script type="text/javascript">
  
$(document).on("click", ".fa-times", function (e) {

  e.preventDefault();

  var _self = $(this);

  var id_pedido   = _self.data('id');
  var nome_pedido = _self.data('nome_pedido');
  var qtd         = _self.data('qtd');

  var qtd_nome = qtd + " x " + nome_pedido;

  $("#id_pedido").val(id_pedido);
  $("#pedido").val(qtd_nome);

  // $(_self.attr('href')).modal('show');
});

// AUTO FOCUS MODAL
$('.modal').on('shown.bs.modal', function() {
  $(this).find('[autofocus]').focus();
});

</script>

<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/maskmoney.js"></script>

<script type="text/javascript">
  $(function() {
    $('[type=money]').maskMoney({
      thousands: '',
      decimal: ',',
      allowZero: true
    });
  })
</script>

</html>