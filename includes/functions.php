<?php
include "db.php";

# ANTI INJECTION

function anti_injection($sql) {
  # remove palavras que contenham sintaxe sql
  $sql = trim($sql); #limpa espacos vazio
  $sql = strip_tags($sql); #tira tags html e php
  $sql = addslashes($sql); #Adiciona barras invertidas a uma string
  $sql = quotemeta($sql); #coloca / se tiver cifrao
  return $sql;
}

######################################################


# MESA

function insert_mesa() {
  global $con;

  $numero   = $_POST['numero'];
  $desconto = 0;

  # NAO ESTÁ SENDO USADO AINDA
  $status = true;

  # VERIFICAR SE MESA JÁ EXISTE
  $query  = "SELECT * FROM mesa WHERE numero = $numero";

  $q = $con->query($query);
  if($q->rowCount() > 0){
    echo '<div style="margin:0" class="alert alert-danger" role="alert"><center>A Mesa Já Existe!</center></div>';
  }else{
    $query  = "INSERT INTO mesa (numero, status, desconto) ";
    $query .= "VALUES ('$numero', '$status', '$desconto')";
    $con->query($query);
  }

}

function trocar_mesa() {
  global $con;

  # INFORMACOES DA MESA QUE VAI SE MUDAR PARA A OUTRA
  $id_mesa1 = anti_injection($_POST['id']);
  $id_mesa2 = '';

  # ARRAY PARA MANIPULAR PRODUTOS E SUAS RESPECTIVAS QUANTIDADES PARA A MESA NOVA
  $produtosId1_array = [];
  $produtosId2_array = [];
  $qtd1_array      = [];
  $qtd2_array      = [];

  # MUDAR PARA A MESA DESSE NUMERO
  $numero = anti_injection($_POST['numero']);

  # ACHO QUE NAO PRECISA DO $ID_POS
  $id_pos     = '';
  $numero_aux = '';

  # CONFERIR SE A MESA EXISTE
  $query  = "SELECT * FROM mesa WHERE numero = $numero";
  $result = $con->query($query);

  while ($row = $result->fetch_assoc() ) {

    $id_mesa2   = $row['id_mesa'];

    # PARA VERIFICAR SE A MESA EXISTE
    $numero_aux = $row['numero'];
  }


  # CONFERIR SE É A MESMA MESA
  if ($id_mesa1 == $id_mesa2) {
    header("Location: trocar_mesa.php?id=" . $id_mesa1 . "&changed=true");
  }

  # SE A MESA EXISTE
  elseif (!empty($id_mesa2)) {

    # SELECIONAR PEDIDO DA MESA ANTERIOR E ADICIONAR PARA OUTRA MESA
    echo "Mesa Existe!<br>";

    $query  = "
    SELECT * FROM pedido 
    INNER JOIN produto ON 
    PEDIDO.id_produto = produto.id_produto 
    INNER JOIN mesa ON 
    PEDIDO.id_mesa = mesa.id_mesa";

    $result = $con->query($query);

    foreach($result as $row) {

      $id_mesa      = $row['id_mesa'];
      $id_produto   = $row['id_produto'];
      $id_pedido    = $row['id_pedido'];
      $qtd          = $row['quantidade'];
      $nome_produto = $row['nome_produto'];
      $preco        = $row['preco'];

      # echo "id_mesa: ".$id_mesa."<br>"."id_mesa1: ".$id_mesa1;


      # PROCURAR PEDIDO DA mesa2
      if ($id_mesa2 == $id_mesa) {

        array_push($produtosId2_array, $id_produto);
        array_push($qtd2_array, $qtd);
      }
    }

    $query  = "

    SELECT * FROM PEDIDO 
    INNER JOIN PRODUTO ON 
    PEDIDO.id_produto = PRODUTO.id_produto 
    INNER JOIN MESA ON 
    PEDIDO.id_mesa = MESA.id_mesa

    ";

    $result = $con->query($query);

    foreach($result as $row) {

      $id_mesa      = $row['id_mesa'];
      $id_produto   = $row['id_produto'];
      $id_pedido    = $row['id_pedido'];
      $qtd          = $row['quantidade'];
      $nome_produto = $row['nome_produto'];
      $preco        = $row['preco'];

      # echo "id_mesa: ".$id_mesa."<br>"."id_mesa1: ".$id_mesa1;


      # PROCURAR PEDIDO DA mesa1
      if ($id_mesa1 == $id_mesa) {

        array_push($produtosId1_array, $id_produto);
        array_push($qtd1_array, $qtd);
      }
    }

    if (!$produtosId2_array) {

      for ($i = 0; $i < sizeof($produtosId1_array); $i++) {
        $query  = "INSERT INTO pedido (quantidade, id_mesa, id_produto)";
        $query .= "VALUES ('$qtd1_array[$i]', '$id_mesa2', '$produtosId1_array[$i]')";
        $result = $con->query($query);
      }
    } else {

      for ($i = 0; $i < sizeof($produtosId1_array); $i++) {

        $produto_repetido = false;

        for ($j = 0; $j < sizeof($produtosId2_array); $j++) {

          if ($produtosId1_array[$i] == $produtosId2_array[$j]) {

            $produto_repetido = true;
            $qtd = $qtd1_array[$i] + $qtd2_array[$j];
            $query = "UPDATE PEDIDO SET quantidade = $qtd WHERE id_produto = $produtosId2_array[$j] AND (id_mesa = $id_mesa2)";
            $result = $con->query($query);
          } elseif (!$produto_repetido && $j == sizeof($produtosId2_array) - 1) {

            $query  = "INSERT INTO PEDIDO (quantidade, id_mesa, id_produto)";
            $query .= "VALUES ('$qtd1_array[$i]', '$id_mesa2', '$produtosId1_array[$i]')";
            $result = $con->query($query);
          }
        }
      }
    }

    delete_mesa($id_mesa1);

    $userIsAdmin = ID_userisadmin($_SESSION['user_id']);

    if ($userIsAdmin) {
      header('Location: ' . LINK_SITE . 'admin/mesas.php');
    } else {
      header('Location: ' . LINK_SITE . 'mesas.php');
    }
  }

  # SE A MESA NÃO EXISTIR...
  else {

    # SELECIONAR PEDIDO DA MESA ANTERIOR E ADICIONAR PARA OUTRA MESA
    echo "Mesa Não Existe!<br>";

    $query = "UPDATE mesa SET numero = $numero WHERE id_mesa='$id_mesa1'";
    $result = $con->query($query);

    header('Location: ' . LINK_SITE . 'admin/mesas.php');
  }
}

function fechar_mesa($id, $total) {
  global $con;

  # VERIFICAR SE USUARIO É ADMIN PARA DIRECIONAR PARA O CAMINHO CERTO
  $userIsAdmin = ID_userisadmin($_SESSION['user_id']);

  if ($userIsAdmin) {
    include "../../../impressao.php";
  } else {
    include "../../impressao.php";
  }

  $query  = "SELECT * FROM MESA WHERE id_mesa = $id";
  $result = $con->query($query);

  foreach($result as $row) {

    $id       = $row['id_mesa'];
    $numero   = $row['numero'];
    $status   = $row['status'];
    $desconto = $row['desconto'];
  }

  $qtd_array      = [];
  $nome_array     = [];
  $qtdPreco_array = [];

  $soma = 0;

  $query2  = "

    SELECT * FROM PEDIDO 
    INNER JOIN PRODUTO ON 
    PEDIDO.id_produto = PRODUTO.id_produto 
    INNER JOIN MESA ON 
    PEDIDO.id_mesa = MESA.id_mesa

    ";

  $result2 = mysqli_query($con, $query2);

  foreach($result2 as $row) {

    $id_mesa      = $row['id_mesa'];
    $id_pedido    = $row['id_pedido'];
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


  # INCLUIR EM OUTRA TABELA ANTES DE DELETAR


  $query2 = "DELETE FROM PEDIDO WHERE id_mesa = $id";
  $result = $con->query($query2);

  $query  = "DELETE FROM MESA WHERE id_mesa = $id";
  $result = $con->query($query);

  try {
    $impressora = imprimir_conta($soma, $qtd_array, $nome_array, $qtdPreco_array, $numero, $desconto);
    cut();
  } catch (Exception $e) { }

  if ($userIsAdmin) {
    header('Location: ' . LINK_SITE . 'admin/mesas.php?impressora='.$impressora);
  } else {
    header('Location: ' . LINK_SITE . 'mesas.php?impressora='.$impressora);
  }

}

function insert_desconto() {
  global $con;

  $id_mesa  = $_POST['id'];
  $desconto = $_POST['desconto'];

  $query = "UPDATE mesa SET desconto='$desconto' WHERE id_mesa='$id_mesa'";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/src/mesa/mesa.php?id='.$id_mesa);
}

function delete_mesa($id) {
  global $con;

  $query2 = "DELETE FROM PEDIDO WHERE id_mesa = $id";
  $result = $con->query($query2);

  $query  = "DELETE FROM MESA WHERE id_mesa = $id";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/mesas.php');
}

######################################################


# ADMIN/FUNCIONARIOS

function cadastro_usuario() {
  global $con;

  $login             = anti_injection($_POST['login']);
  $senha             = anti_injection($_POST['senha']);
  $confirmacao_senha = anti_injection($_POST['conf_senha']);
  $email             = anti_injection($_POST['email']);
  $tipo              = anti_injection($_POST['tipo']);


  if ($senha != $confirmacao_senha) {

    # MELHORAR MENSAGEM
    echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert">Senhas Diferentes!</div>';
  } else {

    $senha = md5($senha);

    $query  = "INSERT INTO usuario (login, senha, email, tipo) ";
    $query .= "VALUES ('$login', '$senha', '$email', '$tipo')";
    $result = $con->query($query);

    header("Location: " . LINK_SITE . "admin/src/funcionario/funcionarios.php");
  }
}

function alterar_funcionario($idf, $login, $email, $senha) {
  global $con;

  $senhacrip = md5($senha);

  $query = "UPDATE usuario SET login='$login', senha='$senhacrip', email='$email' WHERE id_usuario='$idf' AND tipo='funcionario'";
  $result = $con->query($query);
  if(!$result) {
    echo '<script>alert("falhou")</script>';
  }
  header('Location: ' . LINK_SITE . 'admin/src/funcionario/funcionarios.php');
}

function delete_funcionario($id) {
  global $con;
  if(ID_userisadmin($id)==false) {
    $query  = "DELETE FROM usuario WHERE id_usuario = $id";
    $result = $con->query($query);
  
    if ($result) {
      header('Location: '.LINK_SITE.'admin/src/funcionario/funcionarios.php');
    }
  }else{
    echo "Nao pode remover admin!";
  }
}

function autorizacao() {
  global $con;
  $auth = $_SESSION['auth'];

  if (!$auth) {
    header("Location: " . LINK_SITE );
  }
}

function autorizacao_super() {
  global $con;
  $auth = $_SESSION['auth_super'];
  $_SESSION['auth'] = false;

  if (!$auth) {
    header("Location: " . LINK_SITE );
  }
}

function ID_userisadmin($id) {
  global $con;
  $sql = $con->query("SELECT * FROM usuario WHERE id_usuario='$id' AND tipo='administrador'");
  while($listar = $sql->fetch_assoc()) {
    if($listar['tipo']=="administrador") {
      return true;
    } else {
      return false;
    }
  }
}

######################################################


# PRODUTO

function insert_produto() {
  global $con;

  $nome  = $_POST['nome_produto'];
  $tipo  = $_POST['tipo'];
  $preco = $_POST['preco'];

  $query  = "INSERT INTO produto (nome_produto, tipo, preco) ";
  $query .= "VALUES ('$nome', '$tipo', '$preco')";

  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/src/produto/add_produto.php?produto_criado=true');
}

function alterar_produto($id, $nome, $tipo, $preco) {
  global $con;

  $query = "UPDATE produto SET nome_produto = '$nome', tipo = '$tipo', preco = '$preco' WHERE id_produto = $id";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
}

function delete_produto($id) {
  global $con;

  $query  = "DELETE FROM produto WHERE id_produto = $id";
  $result = $con->query($query);

  if (!$result) {
    header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
  }

  header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
}

#####################################################


# PEDIDO

function delete_pedido($id_pedido, $id_mesa) {
  global $con;

  $query  = "DELETE FROM pedido WHERE id_pedido = $id_pedido";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/src/mesa/mesa.php?id=' . $id_mesa);
}


#####################################################

function Send_recover($email,$codigo){
	//Set Infos
	$nmsender = "Webmaster";
	$emsender = "sis@dedal.com.br";
	$rtsender = "sis@dedal.com.br";
  
	$linksite = LINK_SITE;
	$mensagem = "Ol&aacute; <br>";
	$mensagem .= 'Clique <a href="'.$linksite.'/changepass.php?code='.$codigo.'">aqui</a> para mudar sua senha.<br>';
	$mensagem .= '<br><br>';
	$mensagem .= 'Dedal';
	$assunto = "Alterar Senha - Dedal";
  
	$headers =  "Content-Type:text/html; charset=UTF-8\n";
	$headers .= "From:  ".$nmsender." <".$emsender.">\n";
	$headers .= "X-Sender:  <".$emsender.">\n";
	$headers .= "X-Mailer: PHP  v".phpversion()."\n";
	$headers .= "X-IP:  ".$_SERVER['REMOTE_ADDR']."\n";
	$headers .= "Return-Path:  <".$rtsender.">\n";
	$headers .= "MIME-Version: 1.0\n";
		if($email !="" && $codigo !=""){
			mail($email, $assunto, $mensagem, $headers);
	  }
  }

function Expira_code($codigo){
	global $con;
	if(!empty($codigo)){
		$sql = $con->query("UPDATE usuario SET codexp='1' WHERE codigo='$codigo'");
		if($sql){
			return true;
		}else{
			return false;
		}
	}
}
function Verify_code($codigo){
	global $con;
	if(!empty($codigo)){
		$sqlcode = $con->query("SELECT codexp FROM zn_users WHERE codigo='$codigo'");
		$lista = $sqlcode->fetch_assoc();
		if($lista['codexp']==1){
			return true;
		}else{
			return false;
		}
	}
}