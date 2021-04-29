<?php

include "../../includes/functions.php";
include "../../includes/db.php";
include "../../impressao.php";

autorizacao();

# NUMERO DA comanda QUE SERÃO INCLUIDOS OS PEDIDOS
$nome_comanda = $_POST['nome_comanda'];

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
  if(strpos($key, 'id_comanda') !== false) {
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

# VARIAVEL DE CONTROLE PARA NÃO IMPRIMIR MAIS DE UMA VEZ O NUMERO DA comanda
$info_comanda = false;

# LOOP PARA INSERIR PRODUTOS NA comanda
while($count < $id_array_size) {

  # CASO A QUANTIDADE SEJA '0' CONTINUAR PARA O PRÓXIMO PRODUTO
	if($qtd_array[$count] == 0) {
	  $count += 1;
	  continue;
	} else {

    # VARIAVEL DE CONTROLE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA comanda
	  $produto_repetido = false;

	  $id_comanda    = $_POST['id_comanda'];

	  $id_produto = $id_array[$count];
	  $qtd        = $qtd_array[$count];

	  $query2 = "

	  SELECT * FROM PEDIDO 
	  INNER JOIN PRODUTO ON 
	  PEDIDO.id_produto = PRODUTO.id_produto 
	  INNER JOIN comanda ON 
	  PEDIDO.id_comanda = comanda.id_comanda

	  ";

	  $result2 = mysqli_query($con, $query2);

    # WHILE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA comanda
    while($row = mysqli_fetch_array($result2)) { 
      $comanda_id      = $row['id_comanda'];
      $produto_id   = $row['id_produto'];
      $preco        = $row['preco'];
      $produto_qtd  = $row['quantidade'];
      $nome_produto = $row['nome_produto'];

      # VERIFICAR SE A comanda PESQUISADA É IGUAL A comanda SELECIONADA PARA ADICIONAR PRODUTOS
      if($comanda_id == $id_comanda) {

        # VERIFICAR SE O PRODUTO JÁ EXISTA NA comanda
        if($id_produto == $produto_id) {

          if($impressao) {
          	if($info_comanda == false) {
          		nome_comanda($nome_comanda);
          		$info_comanda = true;
          	}

            # IMPRIMIR NOTA DA COZINHA
        	  $impressora = imprimir_cozinha($nome_produto, $qtd);
          }

        	$qtd += $produto_qtd;

          # UPDATE QUANTIDADE DO PRODUTO
          $query  = "UPDATE PEDIDO SET quantidade = $qtd WHERE id_produto = $id_produto AND (id_comanda = $id_comanda)";
					$result = mysqli_query($con, $query);

					$produto_repetido = true;
        }
      }
    }

    # CASO O PRODUTO JÁ EXISTA NA comanda, VERIFICAR O PRÓXIMO PRODUTO
    if($produto_repetido) {
      $produto_repetido = false;
      $count += 1;
      continue;
    }

    # CASO O PRODUTO NÃO EXISTA NA comanda
	  $query  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
	  $result_produto = mysqli_query($con, $query);
	  
	  while($row = mysqli_fetch_array($result_produto)) { 
	    $id_produto = $row['id_produto'];
	    $preco      = $row['preco'];
	    $nome       = $row['nome_produto'];

      if($impressao) {
  	    if($info_comanda == false) {
          nome_comanda($nome_comanda);
          $info_comanda = true;
        }

        # IMPRIMIR NOTA DA COZINHA
	      $impressora = imprimir_cozinha($nome, $qtd);
      }
	  }

	  $query  = "INSERT INTO PEDIDO (quantidade, id_comanda, id_produto)";
	  $query .= "VALUES ('$qtd', '$id_comanda', '$id_produto')";
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
// 	header('Location: pedido.php');
// }
//
////////////////////////////////////////////////////////////////

header('Location: /comandas.php?impressora='.$impressora);

?>

