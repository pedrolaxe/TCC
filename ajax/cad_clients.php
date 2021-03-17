<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

date_default_timezone_set('America/Sao_Paulo');
	$razao = anti_injection(mysqli_real_escape_string($mysqli, $_POST['razao']));
	$nome_fan = anti_injection(mysqli_real_escape_string($mysqli, $_POST['nome_fan']));
	$cnpj	= mysqli_real_escape_string($mysqli, $_POST['cnpj']);
	$email	= mysqli_real_escape_string($mysqli, $_POST['email']);
	$telefone = mysqli_real_escape_string($mysqli, $_POST['telefone']);
	$celular = mysqli_real_escape_string($mysqli, $_POST['celular']);
	$cep = mysqli_real_escape_string($mysqli, $_POST['cep']);
	$endereco = mysqli_real_escape_string($mysqli, $_POST['endereco']);
	$comp = mysqli_real_escape_string($mysqli, $_POST['comp']);
	$bairro = mysqli_real_escape_string($mysqli, $_POST['bairro']);
	$cidade = mysqli_real_escape_string($mysqli, $_POST['cidade']);
	$uf = mysqli_real_escape_string($mysqli, $_POST['uf']);
	$zn_categories = mysqli_real_escape_string($mysqli, $_POST['zn_categories']);

	$data = date('d/m/Y');
	$hora = date('H:i:s');

$numcli = $mysqli->query("SELECT cnpj FROM zn_clients WHERE cnpj='$cnpj'");

if($numcli->num_rows > 0){
	echo 'CNPJ j&aacute; Cadastrado.';
}else{


if(!empty($cnpj)){
	$cnpjlimpo = limpaCPF_CNPJ($cnpj);
	mkdir("../uploads/relatorios/".$cnpjlimpo, 0755); //cria pasta para utilizar relatorios

	$cad_cli = $mysqli->query("INSERT INTO zn_clients (razao,nome_fan,cnpj,email,telefone,celular,cep,endereco,comp,bairro,cidade,uf,zn_categories,data,hora) VALUES ('$razao','$nome_fan','$cnpj','$email','$telefone','$celular','$cep','$endereco','$comp','$bairro','$cidade','$uf','$zn_categories','$data','$hora')");
	if($cad_cli){
		header("Location: ../plugin-clientes");
	}else{
		echo 'Falha ao Cadastrar';
		header("Location: ../plugin-clientes");
	}

}else{
	echo 'Preencha os campos corretamente!';
}

}//contacnpj
?>
