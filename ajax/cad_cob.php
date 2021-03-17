<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
date_default_timezone_set('America/Sao_Paulo');

	$descricao = mysql_real_escape_string(anti_injection($_POST['descricao']));
	$zn_categories = mysql_real_escape_string($_POST['zn_categories']);
	$data_pref	= mysql_real_escape_string($_POST['data_pref']);
	$date01	= mysql_real_escape_string($_POST['date01']);
	$valor = mysql_real_escape_string($_POST['valor']);
	$zn_clients = mysql_real_escape_string($_POST['zn_clients']);
	//$status = 0;
	$datahora = date('d/m/Y H:i:s');

	
if(!empty($descricao) && !empty($valor)){
	$cad_cli = mysql_query("INSERT INTO zn_cobrancas (id_cliente,descricao,categoria,data_pref,data_pag,valor,status,datahora) VALUES ('$zn_clients','$descricao','$zn_categories','$data_pref','$date01','$valor','0','$datahora')");		
	if($cad_cli){
		echo 'Cadastrado, aguarde...';
		echo '<script>window.location.href = "plugin-cobrancas";</script>';
	}else{
		echo 'Falha ao Cadastrar';
		echo '<script>window.location.href = "plugin-cobrancas";</script>';
	}
}else{
	echo 'Preencha todos os campos!';
}
?>
