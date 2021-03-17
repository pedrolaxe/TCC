<?php
  session_start();
  include "../includes/config.php";
  global $mysqli;

  $usuario = anti_injection(mysqli_real_escape_string($mysqli, $_POST['usuario']));
  $senha   = anti_injection(mysqli_real_escape_string($mysqli, $_POST['senha']));
  $senhaenc = Encriptar($senha);

  $sqlinject_usu = strpos($usuario, "'");
  $sqlinject_pas = strpos($senha, "'");

  if($sqlinject_usu == false and $sqlinject_pas == false){

  $qlogin = $mysqli->query("SELECT * FROM zn_users WHERE usuario='$usuario' AND senha='$senhaenc' AND ativo='1'");

  
  if($qlogin->num_rows == 1){

    $_SESSION['usuario_admin'] = $usuario;
    $_SESSION['senha_admin']   = $senhaenc;
    $_SESSION['id_adm']        = Retfunc($usuario);

	echo 'Voc&ecirc; ser&aacute; redirecionado.';
	if($_SESSION['id_adm']==4){
		echo '<script>window.location.href = "index";</script>';
	}else{
		echo '<script>window.location.href = "index";</script>';
	}

  }elseif(empty($usuario)) {
    echo 'Digite o Usu&aacute;rio!';
  }
  elseif(empty($senha)) {
    echo 'Digite a Senha!';

  }else{
    unset($_SESSION['usuario_admin']);
    unset($_SESSION['senha_admin']);
    unset($_SESSION['id_adm']);

    echo 'Usu&aacute;rio ou Senha Incorretos!';
  }
  }else{
  	  echo "SQL INJECTION NO!";
  }
?>
