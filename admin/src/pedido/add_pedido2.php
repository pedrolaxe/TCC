<?php

session_start();

include "../../../includes/functions.php";
# include "../../../includes/db.php";
include "../../../impressao.php";

autorizacao_super();

date_default_timezone_set('America/Sao_Paulo');

$data = date("Y-m-d H:i:s");

# NUMERO DA comanda QUE SERÃO INCLUIDOS OS PEDIDOS
$id_comanda   = $_POST['id_comanda'];
$nome_comanda = $_POST['nome_comanda'];
$qtd          = $_POST['qtd'];
$nome_produto = $_POST['nome_produto'];
$preco        = $_POST['preco'];
$id_produto   = $_POST['id_produto'];

echo $id_comanda."<br>";
echo $nome_comanda."<br>";
echo $qtd."<br>";
echo $nome_produto."<br>";
echo $preco."<br>";
echo $id_produto;

echo "<br><br>";

$query = "

SELECT * FROM PEDIDO 
INNER JOIN PRODUTO ON 
PEDIDO.id_produto = PRODUTO.id_produto 
INNER JOIN COMANDA ON 
PEDIDO.id_COMANDA = COMANDA.id_COMANDA

";

# VARIAVEL DE CONTROLE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA COMANDA
$produto_repetido = false;
$id_comanda       = $_POST['id_comanda'];
$impressora       = true;

$result = $con->query($query);

# WHILE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA COMANDA
foreach($result as $row) { 

  $comanda_id   = $row['id_comanda'];
  $produto_id   = $row['id_produto'];
  $preco        = $row['preco'];
  $produto_qtd  = $row['quantidade'];
  $nome_produto = $row['nome_produto'];

  

  // echo $comanda_id."<br>";
  // echo $produto_id."<br>";
  // echo $preco."<br>";
  // echo $produto_qtd."<br>";
  // echo $preco."<br>";
  // echo $nome_produto;

  // echo "<br><br>";

   # VERIFICAR SE A COMANDA PESQUISADA É IGUAL A COMANDA SELECIONADA PARA ADICIONAR PRODUTOS
  if($id_comanda == $comanda_id) {
    // echo "COMANDA YES";

    # VERIFICAR SE O PRODUTO JÁ EXISTA NA COMANDA
    if($id_produto == $produto_id) {
      echo "Produto YES";

      $qtd += $produto_qtd;

      # UPDATE QUANTIDADE DO PRODUTO
      $query  = "UPDATE PEDIDO SET quantidade = $qtd WHERE id_produto = $id_produto AND (id_comanda = $id_comanda)";
      $result = $con->query($query);

      $produto_repetido = true;

    } 

  }
}

    if($produto_repetido == false) {

      # CASO O PRODUTO NÃO EXISTA NA COMANDA
      $query2  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
      $result_produto = $con->query($query2);

      # IMPRIMIR NOTA DA COZINHA
      foreach($result_produto as $row) { 
        $id_produto = $row['id_produto'];
        $preco      = $row['preco'];
        $nome       = $row['nome_produto'];
      } 

      $query3  = "INSERT INTO PEDIDO (quantidade, id_comanda, id_produto, data)";
      $query3 .= "VALUES ('$qtd', '$id_comanda', '$id_produto', '$data')";
      $result = $con->query($query3);

    }

header('Location: '.LINK_SITE.'admin/src/pedido/pedido2.php?id='.$id_comanda.'&pedido=feito');

// header('Location: '.LINK_SITE.'admin/comandas.php?impressora='.$impressora);





































# VERIFICAR SE É PARA IMPRIMIR A NOTA PARA A COZINHA OU NÃO
// if (isset($_POST['tipo'])) {
//   if($_POST['tipo'] == "impressao") {
//     $impressao = true;
//   }
// } else { $impressao = false; }

// # ARRAYS PARA ARMAZENAR O ID E QTD DOS PRODUTOS PEDIDOS
// $id_array  = [];
// $qtd_array = [];

// foreach ($_POST as $key => $value) {

// 	# VERIFICAR SE EXISTE AS STRINGS NA POSIÇÃO DAS KEYS
//   if(strpos($key, 'id_comanda') !== false) {
//     continue;
//   } elseif(strpos($key, 'id') !== false) {
//     array_push($id_array, $value);
//   } elseif(strpos($key, 'qtd') !== false) {
//     array_push($qtd_array, $value);
//   } else { }

// }

// # VARIAVEIS DE CONTROLE DO WHILE ABAIXO
// $id_array_size  = sizeof($id_array);
// $qtd_array_size = sizeof($qtd_array);
// $count = 0;

// # VARIAVEL DE CONTROLE PARA NÃO IMPRIMIR MAIS DE UMA VEZ O NUMERO DA comanda
// $info_comanda = false;

// # LOOP PARA INSERIR PRODUTOS NA comanda
// while($count < $id_array_size) {

//   # CASO A QUANTIDADE SEJA '0' CONTINUAR PARA O PRÓXIMO PRODUTO
// 	if($qtd_array[$count] == 0) {
// 	  $count += 1;
// 	  continue;
// 	} else {

//     # VARIAVEL DE CONTROLE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA comanda
// 	  $produto_repetido = false;

// 	  $id_comanda    = $_POST['id_comanda'];

// 	  $id_produto = $id_array[$count];
// 	  $qtd = $qtd_array[$count];


// 	  $query2 = "

// 	  SELECT * FROM PEDIDO 
// 	  INNER JOIN PRODUTO ON 
// 	  PEDIDO.id_produto = PRODUTO.id_produto 
// 	  INNER JOIN comanda ON 
// 	  PEDIDO.id_comanda = comanda.id_comanda

// 	  ";


// 	  $result2 = $con->query($query2);

//     # WHILE PARA VERIFICAR SE O PRODUTO JÁ EXISTE NA comanda
//     foreach($result2 as $row) { 

//       $comanda_id      = $row['id_comanda'];
//       $produto_id   = $row['id_produto'];
//       $preco        = $row['preco'];
//       $produto_qtd  = $row['quantidade'];
//       $nome_produto = $row['nome_produto'];

//       # VERIFICAR SE A comanda PESQUISADA É IGUAL A comanda SELECIONADA PARA ADICIONAR PRODUTOS
//       if($comanda_id == $id_comanda) {

//         # VERIFICAR SE O PRODUTO JÁ EXISTA NA comanda
//         if($id_produto == $produto_id) {

//           if($impressao) {

//           	if($info_comanda == false) {
//           		nome_comanda($nome_comanda);
//           		$info_comanda = true;
//           	}
          
//             # IMPRIMIR NOTA DA COZINHA
//         	  $impressora = imprimir_cozinha($nome_produto, $qtd);

//             # PARA NÃO GERAR ERRO DE "IMPRESSORA NAO CONFIGURADA"
//           } else { $impressora = true; }

//         	$qtd += $produto_qtd;

//           # UPDATE QUANTIDADE DO PRODUTO
//           $query  = "UPDATE PEDIDO SET quantidade = $qtd WHERE id_produto = $id_produto AND (id_comanda = $id_comanda)";
// 					$result = $con->query($query);

// 					$produto_repetido = true;

//         }
//       }
//     }

//     # CASO O PRODUTO JÁ EXISTA NA comanda, VERIFICAR O PRÓXIMO PRODUTO
//     if($produto_repetido) {
//       $produto_repetido = false;
//       $count += 1;
//       continue;
//     }

//     # CASO O PRODUTO NÃO EXISTA NA comanda
// 	  $query  = "SELECT * FROM PRODUTO WHERE id_produto = $id_produto";
// 	  $result_produto = $con->query($query);
	  

//     # IMPRIMIR NOTA DA COZINHA
// 	  foreach($result_produto as $row) { 
// 	    $id_produto = $row['id_produto'];
// 	    $preco      = $row['preco'];
// 	    $nome       = $row['nome_produto'];

//       if($impressao) {
//   	    if($info_comanda == false) {
//           nome_comanda($nome_comanda);
//           $info_comanda = true;
//         }

//         # IMPRIMIR NOTA DA COZINHA
// 	      $impressora = imprimir_cozinha($nome, $qtd);

//         # PARA NÃO GERAR ERRO DE "IMPRESSORA NAO CONFIGURADA"
//       } else { $impressora = true; }
// 	  }


// 	  $query  = "INSERT INTO PEDIDO (quantidade, id_comanda, id_produto, data)";
// 	  $query .= "VALUES ('$qtd', '$id_comanda', '$id_produto', '$data')";
// 	  $result = $con->query($query);
// 	}

// 	$count += 1;
// }

// if($impressao) {
//   cut();
// }

// ////////////////////////////////////////////////////////////////
// //
// // ALERTA SE NAO COLOCAR NENHUM PRODUTO
// // $count = 0;
// //
// // while($count < $id_array_size) {
// //
// //
// // 	if($qtd_array[$count] == 0) {
// // 	  $count += 1;
// // 	}
// //
// // }
// //
// // if($count == $qtd_array_size) {
// // 	echo '<script>alert("Adicione um Produto")</script>';
// // 	header('Location: pedido.php');
// // }
// //
// ////////////////////////////////////////////////////////////////

// header('Location: '.LINK_SITE.'admin/comandas.php?impressora='.$impressora);

?>

