<?php

// session_start();

include "../../../includes/functions.php";
include "../../../includes/db.php";
include "../../../impressao.php";

autorizacao_super();

# NUMERO DA MESA QUE SERÃO INCLUIDOS OS PEDIDOS
$numero_mesa = $_POST['numero_mesa'];

# VERIFICAR SE É PARA IMPRIMIR A NOTA PARA A COZINHA OU NÃO
if (isset($_POST['tipo'])) {
  if($_POST['tipo'] == "impressao") {
    $impressao = true;
  }
} else { $impressao = false; }

# ARRAYS PARA ARMAZENAR O ID E QTD DOS PRODUTOS PEDIDOS
$id_array  = [];
$qtd_array = [];

foreach ($_POST as $key => $value) {

	# VERIFICAR SE EXISTE AS STRINGS NA POSIÇÃO DAS KEYS
  if(strpos($key, 'id_mesa') !== false) {
    continue;
  } elseif(strpos($key, 'id') !== false) {
    array_push($id_array, $value);
  } elseif(strpos($key, 'qtd') !== false) {
    array_push($qtd_array, $value);
  } else { }

}

# VARIAVEIS DE CONTROLE DO WHILE ABAIXO
$id_array_size  = sizeof($id_array);
$qtd_array_size = sizeof($qtd_array);
$count = 0;

# VARIAVEL DE CONTROLE PARA NÃO IMPRIMIR MAIS DE UMA VEZ O NUMERO DA MESA
$info_mesa = false;

# LOOP PARA INSERIR PRODUTOS NA MESA
while($count < $id_array_size) {

  # CASO A QUANTIDADE SEJA '0' CONTINUAR PARA O PRÓXIMO PRODUTO
	if($qtd_array[$count] == 0) {
	  $count += 1;
	  continue;
	} else {

    # VARIAVEL DE CONTROLE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA MESA
	  $produto_repetido = false;

	  $id_mesa    = $_POST['id_mesa'];

	  $id_produto = $id_array[$count];
	  $qtd = $qtd_array[$count];


	  $query2 = "

	  SELECT * FROM CONSUMO 
	  INNER JOIN PRODUTO ON 
	  CONSUMO.id_produto = PRODUTO.id_produto 
	  INNER JOIN MESA ON 
	  CONSUMO.id_mesa = MESA.id_mesa

	  ";


	  $result2 = mysqli_query($con, $query2);

    # WHILE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA MESA
    while($row = mysqli_fetch_array($result2)) { 

      $mesa_id      = $row['id_mesa'];
      $produto_id   = $row['id_produto'];
      $preco        = $row['preco'];
      $produto_qtd  = $row['quantidade'];
      $nome_produto = $row['nome_produto'];

      # VERIFICAR SE A MESA PESQUISADA É IGUAL A MESA SELECIONADA PARA ADICIONAR PRODUTOS
      if($mesa_id == $id_mesa) {

        # VERIFICAR SE O PRODUTO JÁ EXISTA NA MESA
        if($id_produto == $produto_id) {

          if($impressao) {

          	if($info_mesa == false) {
          		numero_mesa($numero_mesa);
          		$info_mesa = true;
          	}
          
            # IMPRIMIR NOTA DA COZINHA
        	  $impressora = imprimir_cozinha($nome_produto, $qtd);
          }

        	$qtd += $produto_qtd;

          # UPDATE QUANTIDADE DO PRODUTO
          $query  = "UPDATE CONSUMO SET quantidade = $qtd WHERE id_produto = $id_produto AND (id_mesa = $id_mesa)";
					$result = mysqli_query($con, $query);

					$produto_repetido = true;

        }
      }
    }

    # CASO O PRODUTO JÁ EXISTA NA MESA, VERIFICAR O PRÓXIMO PRODUTO
    if($produto_repetido) {
      $produto_repetido = false;
      $count += 1;
      continue;
    }

    # CASO O PRODUTO NÃO EXISTA NA MESA
	  $query  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
	  $result_produto = mysqli_query($con, $query);
	  

    # IMPRIMIR NOTA DA COZINHA
	  while($row = mysqli_fetch_array($result_produto)) { 
	    $id_produto = $row['id_produto'];
	    $preco      = $row['preco'];
	    $nome       = $row['nome_produto'];

      if($impressao) {
  	    if($info_mesa == false) {
          numero_mesa($numero_mesa);
          $info_mesa = true;
        }

        # IMPRIMIR NOTA DA COZINHA
	      $impressora = imprimir_cozinha($nome, $qtd);
      }
	  }


	  $query  = "INSERT INTO CONSUMO (quantidade, id_mesa, id_produto)";
	  $query .= "VALUES ('$qtd', '$id_mesa', '$id_produto')";
	  $result = mysqli_query($con, $query);
	}

	$count += 1;
}

if($impressao) {
  cut();
}

////////////////////////////////////////////////////////////////
//
// ALERTA SE NAO COLOCAR NENHUM PRODUTO
// $count = 0;
//
// while($count < $id_array_size) {
//
//
// 	if($qtd_array[$count] == 0) {
// 	  $count += 1;
// 	}
//
// }
//
// if($count == $qtd_array_size) {
// 	echo '<script>alert("Adicione um Produto")</script>';
// 	header('Location: consumo.php');
// }
//
////////////////////////////////////////////////////////////////

header('Location: '.LINK_SITE.'admin/mesas.php?impressora='.$impressora);

?>

