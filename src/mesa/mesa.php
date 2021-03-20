<?php

session_start();
include "../../includes/functions.php";

autorizacao();

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query  = "SELECT * FROM MESA WHERE id_mesa = $id";
  $result = mysqli_query($con, $query);

  while($row = mysqli_fetch_array($result)) { 
    $registro = true;
    $id     = $row['id_mesa'];
    $numero = $row['numero'];

    if(strlen($numero) == 1) {
      $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
    }

    $status = $row['status'];
  }
}

if (isset($_GET['delete_consumo'])) {
  $id_consumo = $_GET['delete_consumo'];
  $id_mesa = $_GET['id_mesa'];

  delete_consumo($id_consumo, $id_mesa);
}

if (isset($_GET['deletar_mesa'])) {
  $id = $_GET['deletar_mesa'];

  delete_mesa($id);
}

if (isset($_POST['submit'])) {
  $id = $_POST['fechar_mesa'];
  $total = $_POST['total'];
  $numero = $_POST['numero'];

  fechar_mesa($id, $total);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Mesa</title>
  <link rel="icon" href="assets/img/logo.jpg">
   
  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../includes/head.php' ?>

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
  color:black;
}

a:hover i.fas {
  color:red !important;
}

a:hover i.fa-arrow-left {
  color: #DEF2F1 !important;
}

/*.voltar:hover {
  color: white !important;
  background-color: #88BDBC !important;
}*/

</style>
</head>

<body>
    
<!-- HEADER AND NAV -->
<?php include '../../includes/header.php'; ?>

<main class="container-fluid">
  <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <!-- <h1 class="display-4">Mesa</h1> -->
  </div>
  <div class="card mb-4 shadow">
    <div class="card-header">
      <h1 class="my-0 fw-bold"><a href='/mesas.php'><i class="fas fa-arrow-left"></i></a><b style="float: right">Mesa <?php echo $numero ?></b></h1>
    </div>
    <div class="card-body">
      <ul class="list-unstyled mt-3 mb-4">

      <?php

      $total = 0;

      $query2  = "

      SELECT * FROM CONSUMO 
      INNER JOIN PRODUTO ON 
      CONSUMO.id_produto = PRODUTO.id_produto 
      INNER JOIN MESA ON 
      CONSUMO.id_mesa = MESA.id_mesa

      ";

      $result2 = mysqli_query($con, $query2);

      while($row = mysqli_fetch_array($result2)) { 
        $id_mesa      = $row['id_mesa'];
        $id_consumo   = $row['id_consumo'];
        $qtd          = $row['quantidade'];
        $nome_produto = $row['nome_produto'];
        $preco        = $row['preco'];


        if($id == $id_mesa) {

          echo
          '<li style="margin-bottom: 0.8em">'.$qtd.' x '.$nome_produto.'<b style="float:right">'.number_format($qtd*$preco, 2, '.', ',').'
          <a href="mesa.php?delete_consumo='.$id_consumo.'&id_mesa='.$id_mesa.'"><i class="fas fa-trash" style="padding-left:0.3em"></i></a></b></li>';

          $total += $qtd*$preco;
        }
      }

      echo '<hr class="style-one">';

      echo '<br>';

      echo 

      '
     
      <form action="mesa.php" method="POST">
      
      <input name="fechar_mesa" value="'.$id.'" hidden>
      <input name="total" value="'.$total.'" hidden>
      <input name="numero" value="'.$numero.'" hidden>

      <div class="form-check form-switch" style="float:right;">  
        <label style="float:left;margin-right:60px; margin-top:0px" class="form-check-label" for="flexSwitchCheckDefault">
          <i style="">Acrescentar 10%</i>
        </label>
        <input onclick="calcularDezPorcento('.$total.')" name="dezPorcento" style="float:right;margin-top:5px" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">


        <br><br>


        <h2 style="float:right; font-style: italic; font-weight: bold">

        R$ <b id="total">'.number_format($total, 2, '.', ',').'</b>

        </h2>


      </div><button style="float:left" type="submit" name="submit" class="btn-lg btn-outline-primary">Fechar Conta</button>


        </form>


      <a href="trocar_mesa.php?id='.$id.'">
        <button style="margin-left:4px" class="btn-lg btn-outline-success">Trocar Mesa</button>
      </a>


      ';

      ?>

      </ul>
    </div>
  </div>


<!-- CONFIRMAÇÂO PARA DELETAR MESA -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deletar Mesa</h5>
        <button type="button" class="btn-lg-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Tem certeza disso?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-lg btn-secondary" data-bs-dismiss="modal">Não</button>
        <a href="mesa.php?deletar_mesa='<?php echo $id ?>'"><button type="button" class="btn-lg btn-primary">Sim</button></a>
      </div>
    </div>
  </div>
</div>


</main>   
</body>

<script type="text/javascript">

  function calcularDezPorcento(total) {
    let checkBox = document.querySelector("#flexSwitchCheckDefault");
    let totalInput = document.querySelector("#total");

    dezPorcento = total * 0.1;

    console.log("total: ", total);

    if(checkBox.checked == true) {  
      totalInput.textContent = (total + dezPorcento).toFixed(2);
    } else {
      totalInput.textContent = total.toFixed(2);
    }
  }

</script>
</html>
