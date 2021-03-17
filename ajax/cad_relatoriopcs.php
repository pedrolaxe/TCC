<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
date_default_timezone_set('America/Sao_Paulo');
	$nomepc = mysql_real_escape_string(anti_injection($_POST['nomepc']));
	$usuariopc = mysql_real_escape_string(anti_injection($_POST['usuariopc']));
	$zn_clients	= mysql_real_escape_string($_POST['zn_clients']);

	$data = date('d/m/Y');
	$hora = date('H:i:s');

if(!empty($nomepc)){

	foreach($_FILES['relatoriohtml']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['relatoriohtml']['name'][$key];
		$file_size = $_FILES['relatoriohtml']['size'][$key];
		$file_tmp  = $_FILES['relatoriohtml']['tmp_name'][$key];
		$file_type = $_FILES['relatoriohtml']['type'][$key];
		$file_error = $_FILES['relatoriohtml']['error'][$key];

		$cnpjuser = Get_CNPJbyid($zn_clients);
	// Pasta onde o arquivo vai ser salvo
	$_UP['pasta'] = '../uploads/relatorios/'.$cnpjuser."/";
	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 4000000; // 4Mb
	// Array com as extensões permitidas
	$_UP['extensoes'] = array('txt','html');
	// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
	$_UP['renomeia'] = false;
	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($file_error != 0) {
	echo "<script>alert('Nao foi possível fazer o upload, erro:". $_UP['erros'][$file_error].")</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
	exit; // Para a execução do script
	}
	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
	// Faz a verificação da extensão do arquivo
	@$extensao = strtolower(end(explode('.', $file_name)));
	if (array_search($extensao, $_UP['extensoes']) === false) {
	echo "<script>alert('Por favor, envie arquivos com as seguintes extensoes: jpg, png, pdf, doc ou xls')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
	exit;
	}
	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $file_size) {
	echo "<script>alert('O arquivo enviado e muito grande, envie arquivos de ate 4Mb.')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
	exit;
	}
	if ($_UP['renomeia'] == true) {
	$nome_final = sha1(time()).'.'.$extensao;
	} else {
	// Mantém o nome original do arquivo
	$nome_final = $file_name;
	}
	// Depois verifica se é possível mover o arquivo para a pasta escolhida
	if (move_uploaded_file($file_tmp, $_UP['pasta'] . $nome_final)) {

	$caminhorel = 'uploads/relatorios/'.$cnpjuser."/". $nome_final;



	$cad_cli = mysql_query("INSERT INTO zn_relatoriopcs (id_cliente,nomepc,usuariopc,link_relat,data,hora) VALUES ('$zn_clients','$nomepc','$usuariopc','$caminhorel','$data','$hora')");
	if($cad_cli){
		echo 'Cadastrado, aguarde...';
		echo '<script>window.location.href = "plugin-registrodepcs";</script>';
	}else{
		echo 'Falha ao Cadastrar';
		echo '<script>window.location.href = "plugin-registrodepcs";</script>';
	}

}
}
}else{
	echo 'Preencha os campos corretamente!';
}

?>
