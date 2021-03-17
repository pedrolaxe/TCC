<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
	$descricao = mysql_real_escape_string(anti_injection($_POST['descricao']));
	$val_uni = mysql_real_escape_string(anti_injection($_POST['val_uni']));
	$desconto = mysql_real_escape_string(anti_injection($_POST['desconto']));
	
	$data = date('d/m/Y');
	$hora = date('H:i:s');
		
if(!empty($descricao)){
	$cad_serv = mysql_query("INSERT INTO zn_services (descricao,val_uni,desconto,data,hora) VALUES ('$descricao','$val_uni','$desconto','$data','$hora')");		
	if($cad_serv){
		echo 'Cadastrado, aguarde...';
		echo '<script>window.location.href = "plugin-servicos";</script>';
	}else{
		echo 'Falha ao Cadastrar';
		echo '<script>window.location.href = "plugin-servicos";</script>';
	}
	
}else{
	echo 'Preencha os campos corretamente!';
}
?>
