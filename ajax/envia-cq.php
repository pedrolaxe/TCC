<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";

//posts
$iduser = mysql_real_escape_string($_POST['zn_funcionarios']);
$username = UsernameById($iduser);
$datahoje = date('d/m/Y H:i');
$status = 1;

if($iduser != "tdsfunc"){

if(isset($_FILES['arquivocq'])){
	foreach($_FILES['arquivocq']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['arquivocq']['name'][$key];
		$file_size = $_FILES['arquivocq']['size'][$key];
		$file_tmp  = $_FILES['arquivocq']['tmp_name'][$key];
		$file_type = $_FILES['arquivocq']['type'][$key];
		$file_error = $_FILES['arquivocq']['error'][$key];

if(empty($iduser)){
	echo "<script>alert('Informe o Funcionario!')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
	exit;
}
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../uploads/contra-cheques/'.$username."/";
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 4000000; // 4Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'pdf', 'doc', 'xls', 'docx', 'xlsx', 'jpeg');
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
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
exit; // Para a execução do script
}
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
@$extensao = strtolower(end(explode('.', $file_name)));
if (array_search($extensao, $_UP['extensoes']) === false) {
	echo "<script>alert('Por favor, envie arquivos com as seguintes extensoes: jpg, png, pdf, doc ou xls')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
exit;
}
// Faz a verificação do tamanho do arquivo
if ($_UP['tamanho'] < $file_size) {
	echo "<script>alert('O arquivo enviado e muito grande, envie arquivos de ate 4Mb.')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
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

$caminhocq = 'uploads/contra-cheques/'.$username."/". $nome_final;
$emailaa = EmailById($iduser);


$q = mysql_query("INSERT INTO zn_contracheques (id_user,tipo,nome,caminho,data,status) VALUES ('$iduser','$extensao','$nome_final','$caminhocq','$datahoje','$status')");
if($q){
	echo "<script>alert('Cadastrado com Sucesso!')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
}else{
	echo "<script>alert('Erro! :(')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
}
}else{
	echo "<script>alert('Erro, Tente novamente mais tarde!')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
}
	}//foreach
}//if isset files
}else{//TODOS OS FUNCIONARIOS

$sql = mysql_query("SELECT * FROM zn_users WHERE funcao='4'");
$i = 0;
$totais = array();

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../uploads/contra-cheques/tmp/';
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 4000000; // 4Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'pdf', 'doc', 'xls', 'docx', 'xlsx', 'jpeg');
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = false;
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivocq']['error'] != 0) {
	echo "<script>alert('Nao foi possível fazer o upload, erro:". $_UP['erros'][$_FILES['arquivocq']['error']].")</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
exit; // Para a execução do script
}
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
@$extensao = strtolower(end(explode('.', $_FILES['arquivocq']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
	echo "<script>alert('Por favor, envie arquivos com as seguintes extensoes: jpg, png, pdf, doc ou xls')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
exit;
}
// Faz a verificação do tamanho do arquivo
if ($_UP['tamanho'] < $_FILES['arquivocq']['size']) {
	echo "<script>alert('O arquivo enviado e muito grande, envie arquivos de ate 4Mb.')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
exit;
}
if ($_UP['renomeia'] == true) {
$nome_final = sha1(time()).'.'.$extensao;
} else {
// Mantém o nome original do arquivo
$nome_final = $_FILES['arquivocq']['name'];
}

// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivocq']['tmp_name'], $_UP['pasta'] . $nome_final)) {
while($list = mysql_fetch_array($sql)){
		$totais[$i] = $list['usuario'];
$caminhocq = 'uploads/contra-cheques/'.$totais[$i]."/". $nome_final;
$idusu = IdByUsername($totais[$i]);
copy($_UP['pasta'].$nome_final, "../".$caminhocq);

$email = EmailById($idusu);
 	$q = mysql_query("INSERT INTO zn_contracheques (id_user,tipo,nome,caminho,data,status) VALUES ('$idusu','$extensao','$nome_final','$caminhocq','$datahoje','$status')");

if($q){

	echo "<script>alert('Cadastrado com Sucesso!')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
}else{
	echo "<script>alert('Erro! :(')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
}
$i++;
}

}else{
	echo "<script>alert('Erro, Tente novamente mais tarde!')</script>";
	echo "<script>javascript:open('../plugin-contracheques', '_top')</script>";
}

	}

?>
