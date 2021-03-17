<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
date_default_timezone_set('America/Sao_Paulo');

$codigo = anti_injection(mysql_real_escape_string($_POST['codigo']));
$senha1 = anti_injection(quotemeta(mysql_real_escape_string(quotemeta($_POST['senha1']))));
$senha2 = anti_injection(quotemeta(mysql_real_escape_string(quotemeta($_POST['senha2']))));

if(!empty($senha1) && !empty($senha2)){
if($senha1 == $senha2){
	$senhacript = Encriptar($senha1);
	$sqlsenha = mysql_query("UPDATE zn_users SET senha='$senhacript' WHERE codigo='$codigo'");
	if($sqlsenha){
		Expira_code($codigo);
		echo "Senha Alterada!";
		echo '<meta http-equiv="refresh" content="3; url=login">';
	}
}else{
	echo "As Senhas devem ser iguais!";
}
}else{
	echo "Preencha corretamente as senhas!";
}
?>
