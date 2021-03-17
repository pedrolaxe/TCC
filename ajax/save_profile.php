<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "../verifica.php";
global $mysqli;
date_default_timezone_set('America/Sao_Paulo');

$nome		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['nome']));
$email		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['email']));
$nasc		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['nasc']));
$imagem		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['imagem']));
$senha		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['senha']));
$senha2		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['senha2']));
$iduser		= mysqli_real_escape_string($mysqli, base64_decode($_POST['iduser']));
$data		= date('d/m/Y H:i:s');

if($senha=="" && $senha2==""){
	$sql = $mysqli->query("UPDATE zn_users SET email='$email', nome_inteiro='$nome', nascimento='$nasc', url_img='$imagem', data='$data' WHERE id='$iduser'");
	if($sql){
		echo 'Dados Atualizados';
		echo '<script>window.location.href = "meu-perfil";</script>';
	}
}elseif($senha == $senha2){
	$senhacrip = Encriptar($senha);
	$sqls = $mysqli->query("UPDATE zn_users SET senha='$senhacrip', email='$email', nome_inteiro='$nome', nascimento='$nasc', url_img='$imagem', data='$data' WHERE id='$iduser'");
if($sqls){
	echo 'Senha Atualizada';
	echo '<script>window.location.href = "meu-perfil";</script>';
}
}// $senha_usuario == $senha2_usuario
?>
