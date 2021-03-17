<?php

session_start();

include "../../includes/functions.php";
include "../../includes/db.php";
include "../../../impressao.php";

// autorizacao();
autorizacao_super();

$numero_mesa = $_POST['numero_mesa'];


if (isset($_POST['tipo'])) {

  if($_POST['tipo'] == "impressao") {
    $impressao = true;
  }

} else { $impressao = false; }


$id_array  = [];
$qtd_array = [];

foreach ($_POST as $key => $value) {
  // echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";

	// VERIFICAR SE EXISTE AS STRINGS DENTRO DAS KEYS
  if(strpos($key, 'id_mesa') !== false) {
    continue;
  } elseif(strpos($key, 'id') !== false) {
    array_push($id_array, $value);
  } elseif(strpos($key, 'qtd') !== false) {
    array_push($qtd_array, $value);
  } else {}

}

$id_array_size  = sizeof($id_array);
$qtd_array_size = sizeof($qtd_array);

$count = 0;
$info_mesa = false;

while($count < $id_array_size) {

	if($qtd_array[$count] == 0) {
	  $count += 1;
	  continue;
	} else {

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

    while($row = mysqli_fetch_array($result2)) { 

      // $id_mesa e $mesa_id representam a mesma id mas por buscas diferentes para comparar uma com a outra na hora de
      // mostrar os produtos para cada mesa corretamente
      $mesa_id      = $row['id_mesa'];
      $produto_id   = $row['id_produto'];
      $preco        = $row['preco'];
      $produto_qtd  = $row['quantidade'];
      $nome_produto = $row['nome_produto'];

      if($mesa_id == $id_mesa) {
        if($id_produto == $produto_id) {

          if($impressao) {

          	if($info_mesa == false) {
          		numero_mesa($numero_mesa);
          		$info_mesa = true;
          	}

          
        	  imprimir_cozinha($nome_produto, $qtd);
          }

        	$qtd += $produto_qtd;

          $query  = "UPDATE CONSUMO SET quantidade = $qtd WHERE id_produto = $id_produto AND (id_mesa = $id_mesa)";
					$result = mysqli_query($con, $query);

					$produto_repetido = true;

        }
      }
    }

    if($produto_repetido) {
      $produto_repetido = false;
      $count += 1;
      continue;
    }

	  $query  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
	  $result_produto = mysqli_query($con, $query);
	  

	  while($row = mysqli_fetch_array($result_produto)) { 

	    $id_produto = $row['id_produto'];
	    $preco      = $row['preco'];

	    $nome       = $row['nome_produto'];

      if($impressao) {

  	    if($info_mesa == false) {
          numero_mesa($numero_mesa);
          $info_mesa = true;
        }

	      imprimir_cozinha($nome, $qtd);
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

header('Location: /admin/mesas.php');

?>

