<?php

session_start();

include "../../../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

# SELECIONAR PRODUTO PARA SER ALTERADO
if (isset($_GET['id_produto'])) {
  $id_produto = $_GET['id_produto'];

  $query  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
  $result = $con->query($query);

  foreach($result as $row) { 
    $id        = $row['id_produto'];
    $nome      = $row['nome_produto'];
    // $tipo      = $row['tipo'];
    $preco     = $row['preco'];
    $descricao = $row['descricao'];

  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Produto</title>
  <link rel="icon" href="assets/img/logo.jpg">
    
  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../../../includes/head.php'; ?>

  <!-- CSS -->
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

.btn-outline {
    border: .2em solid black !important;
  }

  .btn-outline:hover {
    border: .2em solid white;
    background-color: black;
    color: white;
  }

  .form-signin input {
    margin-bottom: 20px;
  }

  button {
    margin-top: 20px;
  }


</style>
</head>

<body class="text-center">

<?php include '../../../includes/header_admin.php'; ?>
    
<main class="form-signin">
  <form action='alterar_produto.php' method='post'>
    <!-- <img class="mb-4" src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->

    <?php

      if (isset($_POST['submit'])) {
        $id        = anti_injection($_POST['id']);
        $nome      = anti_injection($_POST['nome_produto']);
        // $tipo      = anti_injection($_POST['tipo']);
        $preco     = anti_injection($_POST['preco']);
        $descricao = anti_injection($_POST['descricao']);

        $preco = str_replace(',', '.', $preco);
        
        alterar_produto($id, $nome, $preco, $descricao);
      } else { }

      $preco = str_replace('.', ',', $preco);

    ?>

    <h1 style="font-size: 46px; text-align: center; margin-top: -10px">Editar Produto</h1>
    <br>
    <input name="id" type="text" class="form-control" placeholder="Nome" autocomplete="off" value="<?php echo $id ?>" hidden>
    <label for="Nome" class="visually-hidden">Nome</label>
    <input name="nome_produto" type="text" class="form-control" placeholder="Nome" autocomplete="off" value="<?php echo $nome ?>" required autofocus>

    <label for="Pre??o" class="visually-hidden">Pre??o</label>
    <input name="preco" type="money" class="form-control" placeholder="Pre??o" autocomplete="off" value="<?php echo $preco ?>" required>

    <label for="Descri????o" class="visually-hidden">Descri????o</label>
    <textarea name="descricao" class="form-control" placeholder="Descri????o" id="" style="height: 100px"><?php echo $descricao; ?></textarea>
    <!-- <input name="descricao" type="text" class="form-control" placeholder="Descri????o" autocomplete="off"> -->

    <button class="w-100 btn btn-lg btn-outline-primary" type="submit" name='submit'>Alterar Produto</button>
  </form>
    <a href="<?= LINK_SITE; ?>admin/src/produto/produtos.php"><button class="w-100 btn btn-lg btn-outline">Voltar</button></a>
</main>
  
</body>

<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?=LINK_SITE;?>assets/js/maskmoney.js"></script>

<script type="text/javascript">
$(function() {
  $('[type=money]').maskMoney({
    thousands: '',
    decimal: ','
  });
})
</script>

</html>
