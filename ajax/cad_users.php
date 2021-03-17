<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

	date_default_timezone_set('America/Sao_Paulo');

	$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
	$usuario = mysqli_real_escape_string($mysqli, $_POST['nome_user']);
	$email = mysqli_real_escape_string($mysqli, $_POST['email_user']);
	$senha = mysqli_real_escape_string($mysqli, $_POST['senha_user']);
	$senhacrip = Encriptar($senha);
	$funcao = mysqli_real_escape_string($mysqli, $_POST['zn_roles']);
	$status = mysqli_real_escape_string($mysqli, $_POST['zn_status']);

	$data = date('d/m/Y H:i:s');

	$usuariolw = str_replace(".", "",$usuario);
	$usuariolim = str_replace("-", "",$usuariolw);

	$q = $mysqli->query("SELECT usuario FROM zn_users WHERE usuario='$usuariolim'");
	$numerocat = $q->num_rows;
	if($numerocat==0){
	if($usuario!="" || $senha!=""){
	  if($funcao==4){

		mkdir("../uploads/contra-cheques/".$usuariolim, 0755);
		$caminho = "uploads/contra-cheques/".$usuariolim."/";
		$sql = $mysqli->query("INSERT INTO zn_users (usuario,senha,nome_inteiro,data,funcao,email,ativo,caminho) VALUES ('$usuariolim','$senhacrip','$nome','$data','$funcao','$email','$status','$caminho')");
	  }else{
			$usuarion = trim(strtolower($nome));
			if(existe_usuario($usuarion)==false){
	  	$sql = $mysqli->query("INSERT INTO zn_users (usuario,senha,nome_inteiro,data,funcao,email,ativo) VALUES ('$usuarion','$senhacrip','$nome','$data','$funcao','$email','$status')");
		}else{
			echo 'Usuario Existente';
		}
	  }
	if($sql){
		echo "true";
	}else{
		echo 'Falha ao cadastrar!';
/*		echo "<script>alert('Falha')</script>";
		echo "<script>javascript:open('../categorias', '_top')</script>";*/
	}
	}else{
		echo 'Preencha corretamente os campos!';
/*		echo "<script>alert('Preencha todos os campos')</script>";
		echo "<script>javascript:open('../categorias', '_top')</script>";*/
	}
	}//numerocat
	else{
		echo 'Usu&aacute;rio j&aacute; existente!';
		//echo "Categoria ja existente!";
	}
?>
