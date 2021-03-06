<?php
include "db.php";

# ANTI INJECTION

function anti_injection($sql)
{
  # remove palavras que contenham sintaxe sql
  $sql = trim($sql); #limpa espacos vazio
  $sql = strip_tags($sql); #tira tags html e php
  $sql = addslashes($sql); #Adiciona barras invertidas a uma string
  $sql = quotemeta($sql); #coloca / se tiver cifrao
  return $sql;
}

# comanda
function insert_comanda()
{
  global $con;

  $nome   = $_POST['nome'];
  $desconto = 0;

  # NAO ESTÁ SENDO USADO AINDA
  $status = 'aberto';

  # VERIFICAR SE comanda JÁ EXISTE
  $query  = "SELECT * FROM comanda WHERE nome = '$nome' AND status='aberto'";


  $q = $con->prepare($query);
  $q->execute();
  if ($q->rowCount() > 0) {

    echo '<div style="margin:0" class="alert alert-danger" role="alert"><center>A Comanda Já Existe!</center></div>';
  } else {
    $hora_inicio = date("H:i:s");
    $data = date('Y-m-d');
    $query  = "INSERT INTO comanda (nome, status, desconto, hora_inicio, data_comanda) ";
    $query .= "VALUES ('$nome', '$status', '$desconto', '$hora_inicio', '$data')";
    $con->query($query);
  }
}

function trocar_comanda()
{
  global $con;

  # INFORMACOES DA comanda QUE VAI SE MUDAR PARA A OUTRA
  $id_comanda1 = anti_injection($_POST['id']);
  $id_comanda2 = '';

  # ARRAY PARA MANIPULAR PRODUTOS E SUAS RESPECTIVAS QUANTIDADES PARA A comanda NOVA
  $produtosId1_array = [];
  $produtosId2_array = [];
  $qtd1_array      = [];
  $qtd2_array      = [];

  # MUDAR PARA A comanda DESSE nome
  $nome = anti_injection($_POST['nome']);

  # ACHO QUE NAO PRECISA DO $ID_POS
  $id_pos     = '';
  $nome_aux = '';

  # CONFERIR SE A comanda EXISTE
  $query  = "SELECT * FROM comanda WHERE nome = '$nome' AND status = 'aberto'";
  $result = $con->query($query);

  while ($row = $result->fetch()) {

    $id_comanda2   = $row['id_comanda'];

    # PARA VERIFICAR SE A comanda EXISTE
    $nome_aux = $row['nome'];
  }


  # CONFERIR SE É A MESMA comanda
  if ($id_comanda1 == $id_comanda2) {
    header("Location: trocar_comanda.php?id=" . $id_comanda1 . "&changed=true");
  }

  # SE A comanda EXISTE
  elseif (!empty($id_comanda2)) {

    echo "comanda Existe!<br>";

    if (empty($_GET['ja_existe'])) {

      header("Location: trocar_comanda.php?id=" . $id_comanda1 . "&ja_existe=true&nome_comanda=" . $nome);
    } else {

      $query  = "

      SELECT * FROM PEDIDO 
      INNER JOIN PRODUTO ON 
      PEDIDO.id_produto = PRODUTO.id_produto 
      INNER JOIN comanda ON 
      PEDIDO.id_comanda = comanda.id_comanda

      ";

      $result = $con->query($query);

      foreach ($result as $row) {

        $id_comanda     = $row['id_comanda'];
        $id_produto     = $row['id_produto'];
        $id_pedido      = $row['id_pedido'];
        $id_colaborador = $row['id_colaborador'];
        $qtd            = $row['quantidade'];
        $nome_produto   = $row['nome_produto'];
        $preco          = $row['preco'];
        $data           = $row['data'];
        $valor          = $row['valor'];

        # PROCURAR PEDIDO DA comanda1
        if ($id_comanda1 == $id_comanda) {

          array_push($produtosId1_array, $id_produto);
          array_push($qtd1_array, $qtd);
        }
      }
      for ($i = 0; $i < sizeof($produtosId1_array); $i++) {
        $query  = "INSERT INTO pedido (quantidade, valor, data, id_comanda, id_produto, id_colaborador)";
        $query .= "VALUES ('$qtd1_array[$i]', '$valor', '$data', '$id_comanda2', '$produtosId1_array[$i]', '$id_colaborador')";
        $result = $con->query($query);
      }

      delete_comanda($id_comanda1);

      header('Location: ' . LINK_SITE . 'admin/comandas.php');
    }
  }

  # SE A comanda NÃO EXISTIR...
  else {

    # SELECIONAR PEDIDO DA comanda ANTERIOR E ADICIONAR PARA OUTRA comanda
    echo "comanda Não Existe!<br>";

    $query = "UPDATE comanda SET nome = '$nome' WHERE id_comanda='$id_comanda1'";
    $result = $con->query($query);

    header('Location: ' . LINK_SITE . 'admin/comandas.php');
  }
}

function fechar_comanda($id, $total, $cartao, $dinheiro, $pix)
{
  global $con;

  $query  = "SELECT * FROM comanda WHERE id_comanda = $id";
  $result = $con->query($query);

  foreach ($result as $row) {

    $id          = $row['id_comanda'];
    $nome        = $row['nome'];
    $status      = $row['status'];
    $desconto    = $row['desconto'];
    $hora_inicio = $row['hora_inicio'];
  }

  $hora_fim = date("H:i:s");


  $query = "UPDATE COMANDA SET status ='fechado', hora_fim = '$hora_fim', dinheiro = '$dinheiro', cartao = '$cartao', pix = '$pix' WHERE id_comanda = $id";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/comandas.php');
}

function imprimir_nota($id, $total)
{
  global $con;

  include "../../../impressao.php";

  $query  = "SELECT * FROM comanda WHERE id_comanda = $id";
  $result = $con->query($query);

  foreach ($result as $row) {

    $id       = $row['id_comanda'];
    $nome   = $row['nome'];
    $status   = $row['status'];
    $desconto = $row['desconto'];
    $hora_inicio = $row['hora_inicio'];
  }

  $qtd_array      = [];
  $nome_array     = [];
  $qtdPreco_array = [];

  $soma = 0;

  $query2  = "

    SELECT * FROM PEDIDO 
    INNER JOIN PRODUTO ON 
    PEDIDO.id_produto = PRODUTO.id_produto 
    INNER JOIN comanda ON 
    PEDIDO.id_comanda = comanda.id_comanda

    ";

  $result2 = $con->query($query2);

  foreach ($result2 as $row) {

    $id_comanda   = $row['id_comanda'];
    $id_pedido    = $row['id_pedido'];
    $qtd          = $row['quantidade'];
    $nome_produto = $row['nome_produto'];
    $preco        = $row['preco'];


    if ($id == $id_comanda) {

      array_push($qtd_array, $qtd);
      array_push($nome_array, $nome_produto);
      array_push($qtdPreco_array, $qtd * $preco);

      $soma += $qtd * $preco;
    }
  }

  $hora_fim = date("H:i:s");

  try {
    $impressora = imprimir_conta($soma, $qtd_array, $nome_array, $qtdPreco_array, $nome, $desconto);
    cut();
  } catch (Exception $e) {
  }


  header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id='.$id . "&impressora=" . $impressora);

}

function insert_desconto()
{
  global $con;

  $id_comanda    = $_POST['id'];
  $desconto      = $_POST['desconto'];
  $total         = $_POST['total'];
  $descontoCheck = $_POST['descontoCheckBox'];

  $desconto = str_replace(',', '.', $desconto);

  if ($descontoCheck == "percentual") {
    $desconto = $total * $desconto / 100;
  }

  if ($desconto > $total) {
    header('Location: ' . LINK_SITE . 'admin/src/comanda/desconto.php?id=' . $id_comanda . '&desconto_alto=true&total=' . $total);
  } elseif ($desconto < 0) {
    header('Location: ' . LINK_SITE . 'admin/src/comanda/desconto.php?id=' . $id_comanda . '&desconto_negativo=true&total=' . $total);
  } else {
    $query = "UPDATE comanda SET desconto='$desconto' WHERE id_comanda='$id_comanda'";

    try {
      $result = $con->query($query);
      header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id=' . $id_comanda);
    } catch (Exception $e) {
      header('Location: ' . LINK_SITE . 'admin/src/comanda/desconto.php?id=' . $id_comanda . "&erro_desconto=true&total=" . $total);
    }
  }

  // header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id='.$id_comanda);
}

function delete_comanda($id)
{
  global $con;

  $query2 = "DELETE FROM PEDIDO WHERE id_comanda = $id";
  $result = $con->query($query2);

  $query  = "DELETE FROM comanda WHERE id_comanda = $id";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/comandas.php');
}

function cancel_comanda($id, $senha, $obs)
{
  global $con;

  $senha = md5($senha);

  $result = $con->query("SELECT * FROM colaborador WHERE tipo='administrador'");

  foreach ($result as $row) {
    $senha_check = $row['senha'];
  }

  if ($senha == $senha_check) {
    $status = 'cancelado';
    $hora_fim = date("H:i:s");

    $query = "UPDATE comanda SET status='$status', hora_fim = '$hora_fim', observacao = '$obs' WHERE id_comanda=$id";
    $result = $con->query($query);

    header('Location: ' . LINK_SITE . 'admin/comandas.php');
  } else {
    header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id=' . $id . '&senha_incorreta=true');
  }
}

######################################################


# ADMIN/colaboradores

function cadastro_colaborador()
{
  global $con;

  $login              = anti_injection($_POST['login']);
  $senha              = anti_injection($_POST['senha']);
  $confirmacao_senha  = anti_injection($_POST['conf_senha']);
  $email              = anti_injection($_POST['email']);
  $tipo               = anti_injection($_POST['tipo']);
  $nome               = anti_injection($_POST['nome']);
  $cpf                = anti_injection($_POST['cpf']);
  $rg                 = anti_injection($_POST['rg']);
  $tel                = anti_injection($_POST['telefone']);

  $CPF_valido = validaCPF($cpf);

  if(!$CPF_valido && $tipo != 'administrador') {
    header("Location: " . LINK_SITE . "admin/src/colaborador/add_colaborador.php?login=" . $login . "&email=" . $email . "&nome=" . $nome . "&cpf=" . $cpf . "&rg=" . $rg . "&tel=" . $tel . "&cpfValido=false");
  } elseif (!$CPF_valido && $tipo == 'administrador') {
    header("Location: " . LINK_SITE . "cadastro.php?login=" . $login . "&email=" . $email . "&nome=" . $nome . "&cpf=" . $cpf . "&rg=" . $rg . "&tel=" . $tel . "&cpfValido=false");
  } else {

    # VERIFICAR SE COLABORADOR JÁ EXISTE
    $query  = "SELECT * FROM colaborador WHERE login = '$login' AND status_colaborador IS NULL";

    $q = $con->query($query);
    if ($q->rowCount() > 0) {
      header("Location: " . LINK_SITE . "admin/src/colaborador/add_colaborador.php?login=" . $login . "&email=" . $email . "&nome=" . $nome . "&cpf=" . $cpf . "&rg=" . $rg . "&tel=" . $tel . "&usuario=true");
    } elseif ($senha != $confirmacao_senha) {

      # MELHORAR MENSAGEM
      if($tipo != 'administrador') {
        header("Location: " . LINK_SITE . "admin/src/colaborador/add_colaborador.php?login=" . $login . "&email=" . $email . "&nome=" . $nome . "&cpf=" . $cpf . "&rg=" . $rg . "&tel=" . $tel . "&senhaDif=false");
      } else {
        header("Location: " . LINK_SITE . "cadastro.php?login=" . $login . "&email=" . $email . "&nome=" . $nome . "&cpf=" . $cpf . "&rg=" . $rg . "&tel=" . $tel . "&senhaDif=false");
      }
    } else {

      $senha = md5($senha);

      $query  = "INSERT INTO colaborador (login, senha, email, tipo, codigo, codexp, nome_colaborador, cpf, rg, telefone) ";
      $query .= "VALUES ('$login', '$senha', '$email', '$tipo', '', false, '$nome', '$cpf', '$rg', '$tel')";
      $result = $con->query($query);

      echo '<div style="width:15em; margin:0 auto;" class="alert alert-success">Usuário Criado Com Sucesso</div>';

      if($tipo == 'administrador') {
        header('Location: index.php');
      }
      // if($result) {
      //   header("Location: " . LINK_SITE . "admin/src/colaborador/colaboradores.php");
      // }
    }
  }
}

function alterar_colaborador($idf, $login, $email, $nome, $cpf, $rg, $tel)
{
  global $con;

  $CPF_valido = validaCPF($cpf);

  if(!$CPF_valido && $tipo != 'administrador') {
    header("Location: " . LINK_SITE . "admin/src/colaborador/edit_colaborador.php?id_colaborador=".$idf."&cpfValido=false");
  } else {

    $status = "inativo";

    # VERIFICAR SE COLABORADOR JÁ EXISTE
    $query  = "SELECT * FROM colaborador WHERE login = '$login' AND (status_colaborador IS NULL AND id_colaborador != '$idf')";

    $q = $con->query($query);
    if ($q->rowCount() > 0) {
      header('Location: ' . LINK_SITE . 'admin/src/colaborador/edit_colaborador.php?id_colaborador=' . $idf . '&usuario_existe=true');
    } else {

      // $senhacrip = md5($senha);

      $query = "UPDATE colaborador SET login='$login', email='$email', nome_colaborador='$nome', cpf='$cpf', rg='$rg', telefone='$tel' WHERE id_colaborador='$idf' AND tipo='colaborador'";
      $result = $con->query($query);
      if (!$result) {
        echo '<script>alert("falhou")</script>';
      } else {
        echo '<div style="width:15em; margin:0 auto;" class="alert alert-success">Usuário Alterado Com Sucesso</div>';
      }
    }
  }
}

function alterar_senha_colaborador($idf, $novaSenha)
{
  global $con;

  $senhacrip = md5($novaSenha);

  $query = "UPDATE colaborador SET senha = '$senhacrip' WHERE id_colaborador='$idf' AND tipo='colaborador'";
  $result = $con->query($query);
  if (!$result) {
    echo '<script>alert("falhou")</script>';
  } else {
    echo '<div style="width:15em; margin:0 auto;" class="alert alert-success">Senha Alterada Com Sucesso</div>';
  }
}

function inativar_colaborador($id)
{
  global $con;
  if (ID_userisadmin($id) == false) {
    $status = 'inativo';

    $query = "UPDATE colaborador SET status_colaborador = '$status' WHERE id_colaborador='$id'";
    $result = $con->query($query);

    if ($result) {
      header('Location: ' . LINK_SITE . 'admin/src/colaborador/colaboradores.php');
    }
  } else {
    echo "Nao pode remover admin!";
  }
}

function autorizacao_super()
{
  $auth = $_SESSION['auth_super'];
  $_SESSION['auth'] = false;

  if (!$auth) {
    header("Location: " . LINK_SITE);
  }
}

function ID_userisadmin($id)
{
  global $con;
  $sql = $con->query("SELECT * FROM colaborador WHERE id_colaborador='$id' AND tipo='administrador'");
  while ($listar = $sql->fetch()) {
    if ($listar['tipo'] == "administrador") {
      return true;
    } else {
      return false;
    }
  }
}

# PRODUTO

function insert_produto()
{
  global $con;

  $nome      = $_POST['nome_produto'];
  // $tipo      = $_POST['tipo'];
  $preco     = $_POST['preco'];
  $descricao = $_POST['descricao'];


  $preco = str_replace(',', '.', $preco);

  # VERIFICAR SE PRODUTO JÁ EXISTE
  $query  = "SELECT * FROM PRODUTO WHERE nome_produto = '$nome' AND status_produto IS NULL";

  $q = $con->query($query);
  if ($q->rowCount() > 0) {
    echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Produto Já Existe!</center></div>';
  } else {

    $query  = "INSERT INTO produto (nome_produto, preco, descricao) ";
    $query .= "VALUES ('$nome', '$preco', '$descricao')";

    $result = $con->query($query);

    header('Location: ' . LINK_SITE . 'admin/src/produto/add_produto.php?produto_criado=true');
  }
}

function alterar_produto($id, $nome, $preco, $descricao)
{
  global $con;

  # VERIFICAR SE PRODUTO JÁ EXISTE
  $query  = "SELECT * FROM PRODUTO WHERE nome_produto = '$nome' AND id_produto != $id AND status_produto IS NULL";

  $q = $con->query($query);
  if ($q->rowCount() > 0) {
    echo '<div style="width:15em; margin:0 auto;" class="alert alert-danger" role="alert"><center>O Produto Já Existe!</center></div>';
  } else {

    $query = "UPDATE produto SET nome_produto = '$nome', preco = '$preco', descricao = '$descricao' WHERE id_produto = $id";
    $result = $con->query($query);

    echo '<div style="width:15em; margin:0 auto;" class="alert alert-success" role="alert"><center>Produto Modificado Com Sucesso!</center></div>';

    // header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');

  }
}

function inativar_produto($id_produto)
{
  global $con;

  try {
    $query  = "DELETE FROM produto WHERE id_produto = $id_produto";
    $result = $con->query($query);
  } catch (Exception $e) {
  }


  $status = 'inativo';

  $query = "UPDATE PRODUTO SET status_produto='$status' WHERE id_produto=$id_produto";
  $result = $con->query($query);

  header('Location: ' . LINK_SITE . 'admin/src/produto/produtos.php');
}

function cancel_pedido($id, $senha, $id_pedido)
{
  global $con;

  $senha = md5($senha);

  $result = $con->query("SELECT * FROM colaborador WHERE tipo='administrador'");

  foreach ($result as $row) {
    $senha_check = $row['senha'];
  }

  if ($senha == $senha_check) {
    $status = 'cancelado';

    $query = "UPDATE PEDIDO SET status_pedido='$status' WHERE id_pedido=$id_pedido";
    $result = $con->query($query);

    header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id=' . $id);
  } else {
    header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id=' . $id . '&senha_incorreta=true');
  }
}

function delete_pedido($id_pedido, $id_comanda)
{
  global $con;

  $query  = "DELETE FROM pedido WHERE id_pedido = $id_pedido";
  $result = $con->query($query);
  if ($result) {
    header('Location: ' . LINK_SITE . 'admin/src/comanda/comanda.php?id=' . $id_comanda);
  }
}

function Send_recover($email, $codigo)
{
  //Set Infos
  $nmsender = "Webmaster";
  $emsender = "sis@dedal.com.br";
  $rtsender = "sis@dedal.com.br";

  $linksite = LINK_SITE;
  $mensagem = "Ol&aacute; <br>";
  $mensagem .= 'Clique <a href="' . $linksite . '/changepass.php?code=' . $codigo . '">aqui</a> para mudar sua senha.<br>';
  $mensagem .= '<br><br>';
  $mensagem .= 'Dedal';
  $assunto = "Alterar Senha - Dedal";

  $headers =  "Content-Type:text/html; charset=UTF-8\n";
  $headers .= "From:  " . $nmsender . " <" . $emsender . ">\n";
  $headers .= "X-Sender:  <" . $emsender . ">\n";
  $headers .= "X-Mailer: PHP  v" . phpversion() . "\n";
  $headers .= "X-IP:  " . $_SERVER['REMOTE_ADDR'] . "\n";
  $headers .= "Return-Path:  <" . $rtsender . ">\n";
  $headers .= "MIME-Version: 1.0\n";
  if ($email != "" && $codigo != "") {
    mail($email, $assunto, $mensagem, $headers);
  }
}

function Expira_code($codigo)
{
  global $con;
  if (!empty($codigo)) {
    $sql = $con->query("UPDATE colaborador SET codexp='1' WHERE codigo='$codigo'");
    if ($sql) {
      return true;
    } else {
      return false;
    }
  }
}
function Verify_code($codigo)
{
  global $con;
  if (!empty($codigo)) {
    $sqlcode = $con->query("SELECT codexp FROM zn_users WHERE codigo='$codigo'");
    $lista = $sqlcode->fetch();
    if ($lista['codexp'] == 1) {
      return true;
    } else {
      return false;
    }
  }
}

function validaCPF($cpf) {

    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}