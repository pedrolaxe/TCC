<?php
include "db.php";

function anti_injection($sql)
{
  // remove palavras que contenham sintaxe sql
  $sql = trim($sql); //limpa espacos vazio
  $sql = strip_tags($sql); //tira tags html e php
  $sql = addslashes($sql); //Adiciona barras invertidas a uma string
  $sql = quotemeta($sql); //coloca / se tiver cifrao
  return $sql;
}

function insert_mesa()
{
  global $con;

  $numero = $_POST['numero'];

  // PARA APARECER 'MESA 01' EM VEZ DE 'MESA 1'
  // if(strlen($numero) == 1) {
  //   $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
  // }

  // SETAR STATUS DA MESA = ABERTA
  $status = true;

  // VERIFICAR SE MESA JÁ EXISTE
  $query  = "SELECT * FROM MESA WHERE numero = $numero";
  $result = mysqli_query($con, $query);

  // ALERTA
  if ($result && mysqli_num_rows($result)) {
    echo '<div class="alert alert-danger" role="alert">A Mesa Já Existe!</div>';
  } else {
    $query  = "INSERT INTO MESA (numero, status) ";
    $query .= "VALUES ('$numero', '$status')";
    $result = mysqli_query($con, $query);

    // header('Location: /mesas.php');

  }
}


// function insert_produto() {
//   global $con;


//     $nome  = $_POST['nome_produto'];
//     $tipo  = $_POST['tipo'];
//     $preco = $_POST['preco'];


//     $query  = "INSERT INTO PRODUTO (nome_produto, tipo, preco) ";
//     $query .= "VALUES ('$nome', '$tipo', '$preco')";

//     $result = mysqli_query($con, $query);

//     header('Location: /src/produto/produtos.php');
// }

// function alterar_produto($id, $nome, $tipo, $preco) {
//   global $con;

//   $query = "UPDATE produto SET nome_produto = '$nome', tipo = '$tipo', preco = '$preco' WHERE id_produto = $id";
//   $result = mysqli_query($con, $query);


//   header('Location: /src/produto/produtos.php');

// }


// function delete_produto($id) {
//   global $con;

//   $query  = "DELETE FROM PRODUTO WHERE id_produto = $id";
//   $result = mysqli_query($con, $query);

//   if(!$result) {
//       header('Location: /src/produto/produtos.php');
//     } else{

//     } 

//   header('Location: /src/produto/produtos.php');

// }


// function delete_consumo($id_consumo, $id_mesa) {
//   global $con;

//   $query  = "DELETE FROM CONSUMO WHERE id_consumo = $id_consumo";
//   $result = mysqli_query($con, $query);

//   header('Location: /admin/src/mesa/mesa.php?id='.$id_mesa);

// }


// function trocar_mesa() {
//   global $con;

//   // INFOS DA MESA QUE VAI SE MUDAR PARA OUTRA MESA
//   $id_mesa1 = $_POST['id'];
//   $id_mesa2 = '';

//   // Arrays para transferir produtos de uma mesa para outra
//   $produtosId1_array = [];
//   $produtosId2_array = [];
//   $qtd1_array        = [];
//   $qtd2_array        = [];

//   // MUDAR PARA A MESA DESSE NUMERO
//   $numero = $_POST['numero'];

//   $id_pos     = '';
//   $numero_aux = '';

//   // CONFERIR SE A MESA EXISTE
//   $query  = "SELECT * FROM MESA WHERE numero = $numero";
//   $result = mysqli_query($con, $query);

//   while($row = mysqli_fetch_array($result)) { 

//     $id_mesa2   = $row['id_mesa'];

//     // PARA VERIFICAR SE A MESA EXISTE
//     $numero_aux = $row['numero'];

//   }


//   // CONFERIR SE É A MESMA MESA
//   if($id_mesa1 == $id_mesa2) {

//     header("Location: trocar_mesa.php?id=".$id_mesa1."&changed=true");
//   } 

//   // SE A MESA EXISTE
//   elseif(!empty($id_mesa2)) {

//     // SELECIONAR CONSUMO DA MESA ANTERIOR E ADICIONAR PARA OUTRA MESA
//     // echo "Mesa Existe!<br>";

//     $query  = "

//     SELECT * FROM CONSUMO 
//     INNER JOIN PRODUTO ON 
//     CONSUMO.id_produto = PRODUTO.id_produto 
//     INNER JOIN MESA ON 
//     CONSUMO.id_mesa = MESA.id_mesa

//     ";

//     $result = mysqli_query($con, $query);

//     while($row = mysqli_fetch_array($result)) { 

//       $id_mesa      = $row['id_mesa'];
//       $id_produto   = $row['id_produto'];
//       $id_consumo   = $row['id_consumo'];
//       $qtd          = $row['quantidade'];
//       $nome_produto = $row['nome_produto'];
//       $preco        = $row['preco'];

//       // echo "id_mesa: ".$id_mesa."<br>"."id_mesa1: ".$id_mesa1;


//       // PROCURAR CONSUMO DA mesa2
//       if($id_mesa2 == $id_mesa) {

//         // INSERT NA OUTRA MESA
//         // echo "<br>";
//         // echo "ID: ".$id_consumo."<br>";
//         // echo "ID produto: ".$id_produto."<br>";
//         // echo "QTD: ".$qtd."<br>";
//         // echo "NOME: ".$nome_produto."<br>";
//         // echo "PRECO: ".$preco."<br>";

//         array_push($produtosId2_array, $id_produto);
//         array_push($qtd2_array, $qtd);



//       }
//     }


//     $query  = "

//     SELECT * FROM CONSUMO 
//     INNER JOIN PRODUTO ON 
//     CONSUMO.id_produto = PRODUTO.id_produto 
//     INNER JOIN MESA ON 
//     CONSUMO.id_mesa = MESA.id_mesa

//     ";

//     $result = mysqli_query($con, $query);

//     while($row = mysqli_fetch_array($result)) { 

//       $id_mesa      = $row['id_mesa'];
//       $id_produto   = $row['id_produto'];
//       $id_consumo   = $row['id_consumo'];
//       $qtd          = $row['quantidade'];
//       $nome_produto = $row['nome_produto'];
//       $preco        = $row['preco'];

//       // echo "id_mesa: ".$id_mesa."<br>"."id_mesa1: ".$id_mesa1;


//       // PROCURAR CONSUMO DA mesa1
//       if($id_mesa1 == $id_mesa) {

//         // INSERT NA OUTRA MESA
//         // echo "<br>";
//          // echo "ID: ".$id_consumo."<br>";
//          // echo "ID produto: ".$id_produto."<br>";
//          // echo "QTD: ".$qtd."<br>";
//          // echo "NOME: ".$nome_produto."<br>";
//          // echo "PRECO: ".$preco."<br>";

//         array_push($produtosId1_array, $id_produto);
//          array_push($qtd1_array, $qtd);



//       }
//     }

//     if(!$produtosId2_array) {

//       for ($i = 0; $i < sizeof($produtosId1_array); $i++) {
//         $query  = "INSERT INTO CONSUMO (quantidade, id_mesa, id_produto)";
//         $query .= "VALUES ('$qtd1_array[$i]', '$id_mesa2', '$produtosId1_array[$i]')";
//         $result = mysqli_query($con, $query);
//       }

//     }

//     else {

//       for ($i = 0; $i < sizeof($produtosId1_array); $i++) {

//         $produto_repetido = false;

//         for ($j = 0; $j < sizeof($produtosId2_array); $j++) {

//           if($produtosId1_array[$i] == $produtosId2_array[$j]) {

//             $produto_repetido = true;
//             $qtd = $qtd1_array[$i] + $qtd2_array[$j];
//             $query = "UPDATE CONSUMO SET quantidade = $qtd WHERE id_produto = $produtosId2_array[$j] AND (id_mesa = $id_mesa2)";
//             $result = mysqli_query($con, $query);

//           } elseif(!$produto_repetido && $j == sizeof($produtosId2_array)-1) {

//             $query  = "INSERT INTO CONSUMO (quantidade, id_mesa, id_produto)";
//             $query .= "VALUES ('$qtd1_array[$i]', '$id_mesa2', '$produtosId1_array[$i]')";
//             $result = mysqli_query($con, $query);

//           }       
//         }
//       }
//     }

//     delete_mesa($id_mesa1);
//     header("Location: /mesas.php");

//   }

//   // SE A MESA NÃO EXISTIR...
//   else {

//     // SELECIONAR CONSUMO DA MESA ANTERIOR E ADICIONAR PARA OUTRA MESA
//     echo "Mesa Não Existe!<br>";

//     // UPDATE NUMERO
//     // if(strlen($numero) == 1) {
//     //   $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
//     // }
//     $query = "UPDATE MESA SET numero = $numero WHERE id_mesa = $id_mesa1";
//     $result = mysqli_query($con, $query);

//     header("Location: /mesas.php");

//   }
// }


// function fechar_mesa($id, $total) {
//   include "../../impressao.php";

//   if(isset($_POST['dezPorcento'])) {
//     $dezPorcento = $_POST['dezPorcento'];
//   } else { $dezPorcento = 'off'; }

//   echo $dezPorcento;

//   $query  = "SELECT * FROM MESA WHERE id_mesa = $id";
//   $result = mysqli_query($con, $query);

//   while($row = mysqli_fetch_array($result)) { 

//     $id     = $row['id_mesa'];
//     $numero = $row['numero'];
//     $status = $row['status'];

//   }

//   $qtd_array      = [];
//   $nome_array     = [];
//   $qtdPreco_array = [];

//   $soma = 0;

//       $query2  = "

//       SELECT * FROM CONSUMO 
//       INNER JOIN PRODUTO ON 
//       CONSUMO.id_produto = PRODUTO.id_produto 
//       INNER JOIN MESA ON 
//       CONSUMO.id_mesa = MESA.id_mesa

//       ";

//       $result2 = mysqli_query($con, $query2);

//       while($row = mysqli_fetch_array($result2)) { 

//         $id_mesa      = $row['id_mesa'];
//         $id_consumo   = $row['id_consumo'];
//         $qtd          = $row['quantidade'];
//         $nome_produto = $row['nome_produto'];
//         $preco        = $row['preco'];


//         if($id == $id_mesa) {

//           // echo $qtd . "<br>";
//           // echo $nome_produto . "<br>";
//           // echo $qtd*$preco . "<br>";

//           array_push($qtd_array, $qtd);
//           array_push($nome_array, $nome_produto);
//           array_push($qtdPreco_array, $qtd*$preco);

//           // echo
//           // '<li style="margin-bottom: 0.8em">'.$qtd.' x '.$nome_produto.'<b style="float:right">'.number_format($qtd*$preco, 2, '.', ',').'
//           // <a href="mesa.php?delete_consumo='.$id_consumo.'"><i class="fas fa-trash" style="margin-left:0.8em"></i></a></b></li>';

//           $soma += $qtd*$preco;
//         }
//       }

//   if($dezPorcento == 'on') {
//     $soma *= 1.1;
//   }

//   echo $soma;


//   // ATIVAR COMENTARIOS ABAIXO (TESTANDO)
//   $query2 = "DELETE FROM CONSUMO WHERE id_mesa = $id";
//   $result = mysqli_query($con, $query2);

//   $query  = "DELETE FROM MESA WHERE id_mesa = $id";
//   $result = mysqli_query($con, $query);

//   imprimir_conta($soma, $qtd_array, $nome_array, $qtdPreco_array, $numero);
//   cut();

//   header("Location: /mesas.php");

// }


// function delete_mesa($id) {
//   global $con;

//   $query2 = "DELETE FROM CONSUMO WHERE id_mesa = $id";
//   $result = mysqli_query($con, $query2);

//   $query  = "DELETE FROM MESA WHERE id_mesa = $id";
//   $result = mysqli_query($con, $query);

//   header("Location: /admin/mesas.php");

// }


function cadastro_usuario()
{
  global $con;

  $login             = anti_injection($_POST['login']);
  $senha             = anti_injection($_POST['senha']);
  $confirmacao_senha = anti_injection($_POST['conf_senha']);
  $email             = anti_injection($_POST['email']);
  $tipo              = $_POST['tipo'];

  // echo $login."<br>";
  // echo $senha."<br>";
  // echo $confirmacao_senha."<br>";
  // echo $email."<br>";

  if ($senha != $confirmacao_senha) {
    // MELHORAR MENSAGEM
    echo '<div style="width:15em; margin:0 auto" class="alert alert-danger" role="alert">Senhas Diferentes!</div>';
  } else {

    $senha = md5($senha);

    $query  = "INSERT INTO usuario (login, senha, email, tipo) ";
    $query .= "VALUES ('$login', '$senha', '$email', '$tipo')";
    $result = mysqli_query($con, $query);

    header("Location: " . LINK_SITE . "/admin/src/funcionario/funcionarios.php");
  }
}

function autorizacao()
{
  global $con;
  $auth = $_SESSION['auth'];

  if (!$auth) {
    header("Location: " . LINK_SITE . "");
  }
}

function autorizacao_super()
{
  $auth = $_SESSION['auth_super'];
  $_SESSION['auth'] = false;

  if (!$auth) {
    header("Location: " . LINK_SITE . "");
  }
}

/** Admin Functions */
// function insert_mesa() {

//   $numero = $_POST['numero'];

//   // PARA APARECER 'MESA 01' EM VEZ DE 'MESA 1'
//   // if(strlen($numero) == 1) {
//   //   $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
//   // }

//   // SETAR STATUS DA MESA = ABERTA
//   $status = true;

//   // VERIFICAR SE MESA JÁ EXISTE
//   $query  = "SELECT * FROM MESA WHERE numero = $numero";
//   $result = mysqli_query($con, $query);

//   // ALERTA
//   if($result && mysqli_num_rows($result)) {
//     echo '<div class="alert alert-danger" role="alert">A Mesa Já Existe!</div>';
//   } else {


//   $query  = "INSERT INTO MESA (numero, status) ";
//   $query .= "VALUES ('$numero', '$status')";


//   $result = mysqli_query($con, $query);

//   // TESTE DE QUERY
//   // if(!$result) {
//   //     die("Query Failed" . mysqli_error($con));
//   // } else{
//   //     echo "YES";
//   // } 

//   // header('Location: /mesas.php');

// }
// }


function insert_produto()
{
  global $con;

  $nome  = $_POST['nome_produto'];
  $tipo  = $_POST['tipo'];
  $preco = $_POST['preco'];


  $query  = "INSERT INTO PRODUTO (nome_produto, tipo, preco) ";
  $query .= "VALUES ('$nome', '$tipo', '$preco')";

  $result = mysqli_query($con, $query);

  header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
}

function alterar_produto($id, $nome, $tipo, $preco)
{
  global $con;

  $query = "UPDATE produto SET nome_produto = '$nome', tipo = '$tipo', preco = '$preco' WHERE id_produto = $id";
  $result = mysqli_query($con, $query);
  header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
}


function delete_produto($id)
{
  global $con;

  $query  = "DELETE FROM PRODUTO WHERE id_produto = $id";
  $result = mysqli_query($con, $query);

  if (!$result) {
    header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
  }

  header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
}


function delete_consumo($id_consumo, $id_mesa)
{
  global $con;

  $query  = "DELETE FROM CONSUMO WHERE id_consumo = $id_consumo";
  $result = mysqli_query($con, $query);

  header('Location: ' . LINK_SITE . 'admin/src/mesa/mesa.php?id=' . $id_mesa);
}

function trocar_mesa()
{
  global $con;

  // INFOS DA MESA QUE VAI SE MUDAR PARA OUTRA MESA
  $id_mesa1 = $_POST['id'];
  $id_mesa2 = '';

  // Arrays para transferir produtos de uma mesa para outra
  $produtosId1_array = [];
  $produtosId2_array = [];
  $qtd1_array      = [];
  $qtd2_array      = [];

  // MUDAR PARA A MESA DESSE NUMERO
  $numero = $_POST['numero'];

  $id_pos     = '';
  $numero_aux = '';

  // CONFERIR SE A MESA EXISTE
  $query  = "SELECT * FROM MESA WHERE numero = $numero";
  $result = mysqli_query($con, $query);

  while ($row = mysqli_fetch_array($result)) {

    $id_mesa2   = $row['id_mesa'];

    // PARA VERIFICAR SE A MESA EXISTE
    $numero_aux = $row['numero'];
  }


  // CONFERIR SE É A MESMA MESA
  if ($id_mesa1 == $id_mesa2) {

    header("Location: trocar_mesa.php?id=" . $id_mesa1 . "&changed=true");
  }

  // SE A MESA EXISTE
  elseif (!empty($id_mesa2)) {

    // SELECIONAR CONSUMO DA MESA ANTERIOR E ADICIONAR PARA OUTRA MESA

    echo "Mesa Existe!<br>";



    $query  = "
  
  SELECT * FROM CONSUMO 
  INNER JOIN PRODUTO ON 
  CONSUMO.id_produto = PRODUTO.id_produto 
  INNER JOIN MESA ON 
  CONSUMO.id_mesa = MESA.id_mesa

  ";

    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {

      $id_mesa      = $row['id_mesa'];
      $id_produto   = $row['id_produto'];
      $id_consumo   = $row['id_consumo'];
      $qtd          = $row['quantidade'];
      $nome_produto = $row['nome_produto'];
      $preco        = $row['preco'];

      // echo "id_mesa: ".$id_mesa."<br>"."id_mesa1: ".$id_mesa1;


      // PROCURAR CONSUMO DA mesa2
      if ($id_mesa2 == $id_mesa) {

        array_push($produtosId2_array, $id_produto);
        array_push($qtd2_array, $qtd);
      }
    }

    $query  = "

    SELECT * FROM CONSUMO 
    INNER JOIN PRODUTO ON 
    CONSUMO.id_produto = PRODUTO.id_produto 
    INNER JOIN MESA ON 
    CONSUMO.id_mesa = MESA.id_mesa

    ";

    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {

      $id_mesa      = $row['id_mesa'];
      $id_produto   = $row['id_produto'];
      $id_consumo   = $row['id_consumo'];
      $qtd          = $row['quantidade'];
      $nome_produto = $row['nome_produto'];
      $preco        = $row['preco'];

      // echo "id_mesa: ".$id_mesa."<br>"."id_mesa1: ".$id_mesa1;


      // PROCURAR CONSUMO DA mesa1
      if ($id_mesa1 == $id_mesa) {

        array_push($produtosId1_array, $id_produto);
        array_push($qtd1_array, $qtd);
      }
    }

    if (!$produtosId2_array) {

      for ($i = 0; $i < sizeof($produtosId1_array); $i++) {
        $query  = "INSERT INTO CONSUMO (quantidade, id_mesa, id_produto)";
        $query .= "VALUES ('$qtd1_array[$i]', '$id_mesa2', '$produtosId1_array[$i]')";
        $result = mysqli_query($con, $query);
      }
    } else {

      for ($i = 0; $i < sizeof($produtosId1_array); $i++) {

        $produto_repetido = false;

        for ($j = 0; $j < sizeof($produtosId2_array); $j++) {

          if ($produtosId1_array[$i] == $produtosId2_array[$j]) {

            $produto_repetido = true;
            $qtd = $qtd1_array[$i] + $qtd2_array[$j];
            $query = "UPDATE CONSUMO SET quantidade = $qtd WHERE id_produto = $produtosId2_array[$j] AND (id_mesa = $id_mesa2)";
            $result = mysqli_query($con, $query);
          } elseif (!$produto_repetido && $j == sizeof($produtosId2_array) - 1) {

            $query  = "INSERT INTO CONSUMO (quantidade, id_mesa, id_produto)";
            $query .= "VALUES ('$qtd1_array[$i]', '$id_mesa2', '$produtosId1_array[$i]')";
            $result = mysqli_query($con, $query);
          }
        }
      }
    }

    delete_mesa($id_mesa1);
    header('Location: ' . LINK_SITE . 'admin/mesas.php');
  }

  // SE A MESA NÃO EXISTIR...
  else {

    // SELECIONAR CONSUMO DA MESA ANTERIOR E ADICIONAR PARA OUTRA MESA
    echo "Mesa Não Existe!<br>";

    $query = "UPDATE MESA SET numero = $numero WHERE id_mesa = $id_mesa1";
    $result = mysqli_query($con, $query);

    header('Location: ' . LINK_SITE . 'admin/mesas.php');
  }

  // PEGAR AS INFORMAÇÔES DESSA MESA E INCLUIR EM UMA NOVA QUE ESTEJA EM USO OU NAO


}


function fechar_mesa($id, $total)
{
  include "../../../impressao.php";

  if (isset($_POST['dezPorcento'])) {
    $dezPorcento = $_POST['dezPorcento'];
  } else {
    $dezPorcento = 'off';
  }

  echo $dezPorcento;

  $query  = "SELECT * FROM MESA WHERE id_mesa = $id";
  $result = mysqli_query($con, $query);

  while ($row = mysqli_fetch_array($result)) {

    $id     = $row['id_mesa'];
    $numero = $row['numero'];
    $status = $row['status'];
  }

  $qtd_array      = [];
  $nome_array     = [];
  $qtdPreco_array = [];

  $soma = 0;

  $query2  = "

    SELECT * FROM CONSUMO 
    INNER JOIN PRODUTO ON 
    CONSUMO.id_produto = PRODUTO.id_produto 
    INNER JOIN MESA ON 
    CONSUMO.id_mesa = MESA.id_mesa

    ";

  $result2 = mysqli_query($con, $query2);

  while ($row = mysqli_fetch_array($result2)) {

    $id_mesa      = $row['id_mesa'];
    $id_consumo   = $row['id_consumo'];
    $qtd          = $row['quantidade'];
    $nome_produto = $row['nome_produto'];
    $preco        = $row['preco'];


    if ($id == $id_mesa) {

      array_push($qtd_array, $qtd);
      array_push($nome_array, $nome_produto);
      array_push($qtdPreco_array, $qtd * $preco);

      $soma += $qtd * $preco;
    }
  }

  if ($dezPorcento == 'on') {
    $soma *= 1.1;
  }

  echo $soma;


  // ATIVAR COMENTARIOS ABAIXO (TESTANDO)
  $query2 = "DELETE FROM CONSUMO WHERE id_mesa = $id";
  $result = mysqli_query($con, $query2);

  $query  = "DELETE FROM MESA WHERE id_mesa = $id";
  $result = mysqli_query($con, $query);

  imprimir_conta($soma, $qtd_array, $nome_array, $qtdPreco_array, $numero);
  cut();

  header('Location: ' . LINK_SITE . 'admin/mesas.php');
}


function delete_mesa($id){
  global $con;

  $query2 = "DELETE FROM CONSUMO WHERE id_mesa = $id";
  $result = mysqli_query($con, $query2);

  $query  = "DELETE FROM MESA WHERE id_mesa = $id";
  $result = mysqli_query($con, $query);

  header('Location: ' . LINK_SITE . 'admin/mesas.php');
}

function alterar_funcionario($idf, $login, $email, $senha){
  global $con;

  $senhacrip = md5($senha);

  $query = "UPDATE usuario SET login='$login', senha='$senhacrip', email='$email' WHERE id_usuario='$idf' AND tipo='funcionario'";
  $result = mysqli_query($con, $query);
  if(!$result){
    echo '<script>alert("falhou")</script>';
  }
  header('Location: ' . LINK_SITE . 'admin/src/funcionario/funcionarios.php');
}


function ID_userisadmin($id){
	global $con;
	$sql = $con->query("SELECT id_usuario FROM usuario WHERE id_usuario='$id' AND tipo='administrador'");
	while($listar = $sql->fetch_assoc()){
		if($listar['tipo']=="administrador"){
			return true;
		}else{
			return false;
		}
	}
}

function delete_funcionario($id){
  global $con;
  if(ID_userisadmin($id)==false){
    $query  = "DELETE FROM usuario WHERE id_usuario = $id";
    $result = mysqli_query($con, $query);
  
    if ($result) {
      header('Location: '.LINK_SITE.'admin/src/funcionario/funcionarios.php');
    }
  }else{
    echo "Nao pode remover admin!";
  }
  
}
