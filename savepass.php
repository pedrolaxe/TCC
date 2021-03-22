<?php
include "includes/functions.php";
global $con;

$senha = anti_injection(mysqli_real_escape_string($con, $_POST['senha']));
$codigo = anti_injection(mysqli_real_escape_string($con, $_POST['codigo']));

date_default_timezone_set('America/Sao_Paulo');

if(!empty($senha)){
	$senhacript = md5($senha);
	$sqlsenha = $con->query("UPDATE usuario SET senha='$senhacript' WHERE codigo='$codigo'");
	if($sqlsenha){
		Expira_code($codigo);
		echo "Senha Alterada!";
		echo '<meta http-equiv="refresh" content="3; url=index.php">';
	}
}else{
	echo "Preencha corretamente as senhas!";
}
  ?>