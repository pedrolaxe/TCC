<?php

session_start();

include "../../../includes/functions.php";

// autorizacao();
autorizacao_super();

if (isset($_POST['submit'])) {

  $id    = anti_injection($_POST['id']);
  $nome  = anti_injection($_POST['nome_produto']);
  $tipo  = anti_injection($_POST['tipo']);
  $preco = anti_injection($_POST['preco']);
  
  alterar_produto($id, $nome, $tipo, $preco);

} else { }

// SELECIONAR PRODUTO PARA SER ALTERADO
if (isset($_GET['id_produto'])) {

  $id_produto = $_GET['id_produto'];

  $query  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
  $result = mysqli_query($con, $query);

  while($row = mysqli_fetch_array($result)) { 

    $id    = $row['id_produto'];
    $nome  = $row['nome_produto'];
    $tipo  = $row['tipo'];
    $preco = $row['preco'];

  }
}


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Produto</title>
    <link rel="icon" href="assets/img/logo.jpg">
    
    <?php include '../../../includes/head.php'; ?>

  <!-- Custom styles for this template -->
  <link href="<?=LINK_SITE;?>assets/css/form.css" rel="stylesheet">

<style>

select.minimal {
  background-image:
    linear-gradient(45deg, transparent 50%, #6E6658 50%),
    linear-gradient(135deg, #6E6658 50%, transparent 50%),
    linear-gradient(to right, #ccc, #ccc);
  background-position:
    calc(100% - 20px) calc(1em + 2px),
    calc(100% - 15px) calc(1em + 2px),
    calc(100% - 2.5em) 0.5em;
  background-size:
    5px 5px,
    5px 5px,
    1px 1.5em;
  background-repeat: no-repeat;
}

select.minimal:focus {
  background-image:
    linear-gradient(45deg,  green 50%, transparent 50%),
    linear-gradient(135deg, transparent 50%,  green 50%),
    linear-gradient(to right, #ccc, #ccc);
  background-position:
    calc(100% - 15px) 1em,
    calc(100% - 20px) 1em,
    calc(100% - 2.5em) 0.5em;
  background-size:
    5px 5px,
    5px 5px,
    1px 1.5em;
  background-repeat: no-repeat;
  border-color: #88BDBC;
  outline: 0;
}

</style>

</head>
<body class="text-center">

<?php include '../../../includes/header_admin.php'; ?>
    
<main class="form-signin">
  <form action='alterar_produto.php' method='post'>
    <!-- <img class="mb-4" src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1>Alteraração Produto</h1>
    <br>
    <input name="id" type="text" class="form-control" placeholder="Nome" autocomplete="off" value="<?php echo $id ?>" hidden>
    <label for="Nome" class="visually-hidden">Nome</label>
    <input name="nome_produto" type="text" class="form-control" placeholder="Nome" autocomplete="off" value="<?php echo $nome ?>" required autofocus>
    <br>
    <label for="Tipo" class="visually-hidden">Tipo</label>
    <select name="tipo" placeholder="Tipo" class="form-control minimal" value="<?php echo $tipo ?>" required>
      
      <option value="" disabled selected>Tipo</option>
      <option value="bar">Bar</option>
      <option value="porcao">Porções</option>
      <option value="refeicao">Refeição</option>
      <option value="lanche">Lanche</option>
      <option value="caldo">Caldos</option>
      <option value="desconto">Desconto</option>

    </select>
    <br>
    <label for="Preço" class="visually-hidden">Preço</label>
    <input name="preco" type="money" class="form-control" placeholder="Preço" autocomplete="off" value="<?php echo $preco ?>" required>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name='submit'>Alterar Produto</button>
    <br><br>
  </form>
</main>
  
</body>

<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/maskmoney.js"></script>

<script type="text/javascript">
$(function() {
  $('[type=money]').maskMoney({
    thousands: '',
    decimal: '.'
  });
})
</script>

</html>