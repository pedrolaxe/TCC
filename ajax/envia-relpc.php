<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";

//posts
$nomepc = anti_injection(mysql_real_escape_string($_POST['nomepc']));
$usuariopc = anti_injection(mysql_real_escape_string($_POST['usuariopc']));
$sispc = anti_injection(mysql_real_escape_string($_POST['sispc']));
$localpc = anti_injection(mysql_real_escape_string($_POST['localpc']));
$id_cliente = mysql_real_escape_string($_POST['zn_clients']);

$datahoje = date('d/m/Y');
$hora = date("H:i");

if(isset($_FILES['siwpc'])){
	foreach($_FILES['siwpc']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['siwpc']['name'][$key];
		$file_size = $_FILES['siwpc']['size'][$key];
		$file_tmp  = $_FILES['siwpc']['tmp_name'][$key];
		$file_type = $_FILES['siwpc']['type'][$key];
		$file_error = $_FILES['siwpc']['error'][$key];

if(empty($id_cliente)){
	echo "<script>alert('Informe o Cliente')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
	exit;
}
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../uploads/relatorios/';
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 4000000; // 4Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('txt','csv','html','png');
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;
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
	echo "<script>alert('Por favor, envie arquivos com as seguintes extensoes: txt, csv ou html')</script>";
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

$caminhocq = 'uploads/relatorios/'.$nome_final;

$q = mysql_query("INSERT INTO zn_relatoriopcs (id_cliente,nomepc,usuariopc,sispc,localpc,link_relat,data,hora) VALUES ('$id_cliente','$nomepc','$usuariopc','$sispc','$localpc','$caminhocq','$datahoje','$hora')");
if($q){
	echo "<script>alert('Cadastrado com Sucesso!')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
}else{
	echo "<script>alert('Erro! :(')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
}
}else{
	echo "<script>alert('Erro, Tente novamente mais tarde!')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
}
	}//foreach
}//if isset files

?>
