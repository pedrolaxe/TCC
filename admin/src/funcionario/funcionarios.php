<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

include "../../includes/functions.php";
include "../../../includes/db.php";

// autorizacao();
autorizacao_super();

if (isset($_GET['delete_funcionario'])) {

  $id = $_GET['delete_funcionario'];

  // CRIAR FUNCAO
  delete_funcionario($id);
}

if (isset($_GET['alterar_funcionario'])) {

  $id = $_GET['alterar_funcionario'];

  // CRIAR FUNCAO
  alterar_funcionario($id);
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Produtos</title>
  <link rel="icon" href="assets/img/logo.jpg">

	<?php include '../../../includes/head.php'; ?>

   <link href="../../../assets/css/produtos.css" rel="stylesheet">

</head>
<body>

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
    $result = mysqli_query($con, $query);

    while($row = mysqli_fetch_array($result)) { 

      $registro = true;
      $id    = $row['id_usuario'];
      $tipo  = $row['tipo'];
      $nome_produto  = $row['login'];
      // $preco = $row['preco'];

?>
      <tr>
        <td><?php echo $nome_produto ?></td>
        <td style="text-align: right; padding-left: 0"><a href="alterar_produto.php?id_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="far fa-edit"></i></button></a></td>

        <td style="text-align: right; padding-left: 0"><a href="produtos.php?delete_produto=<?php echo $id; ?>"><button class="btn btn-outline-dark"><i class="fas fa-trash"></i></button></a></td>
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