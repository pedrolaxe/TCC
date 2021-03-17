<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;
date_default_timezone_set('America/Sao_Paulo');


	$razao 		= anti_injection(mysqli_real_escape_string($mysqli, $_POST['razao']));
	$nome_fan 	= anti_injection(mysqli_real_escape_string($mysqli, $_POST['nome_fan']));
	$cnpj		= mysqli_real_escape_string($mysqli, $_POST['cnpj']);
	$email		= mysqli_real_escape_string($mysqli, $_POST['email']);
	$telefone 	= mysqli_real_escape_string($mysqli, $_POST['telefone']);
	$celular 	= mysqli_real_escape_string($mysqli, $_POST['celular']);
	$cep 		= mysqli_real_escape_string($mysqli, $_POST['cep']);
	$endereco 	= mysqli_real_escape_string($mysqli, $_POST['endereco']);
	$comp 		= mysqli_real_escape_string($mysqli, $_POST['comp']);
	$bairro 	= mysqli_real_escape_string($mysqli, $_POST['bairro']);
	$cidade 	= mysqli_real_escape_string($mysqli, $_POST['cidade']);
	$uf 		= mysqli_real_escape_string($mysqli, $_POST['uf']);
	//$zn_categories = mysqli_real_escape_string($mysqli, $_POST['zn_categories']);
	$id_cli 	= anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_POST['id_cli'])));


if(!empty($cnpj)){
	$cad_cli = $mysqli->query("UPDATE zn_clients SET razao='$razao', nome_fan='$nome_fan', cnpj='$cnpj', email='$email', telefone='$telefone', celular='$celular', cep='$cep', endereco='$endereco', comp='$comp', bairro='$bairro', cidade='$cidade', uf='$uf' WHERE id='$id_cli'");
	if($cad_cli){
		echo 'Atualizado, aguarde...';
		//header("Location: plugin-clientes");
		echo '<script>window.location.href = "plugin-clientes";</script>';
	}else{
		echo 'Falha ao Editar';
		//echo '<script>window.location.href = "plugin-clientes";</script>';
		header("Location: plugin-clientes");
	}

}else{
	echo 'Preencha os campos corretamente!';
}
?>
