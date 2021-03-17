<?php
include "../includes/config.php";

$username = anti_injection(mysql_real_escape_string($_POST['username']));

 $sqlinject_usu = strpos($username, "'");

  if($sqlinject_usu == false){


$q = mysql_query("SELECT usuario FROM zn_users WHERE usuario='$username'");
$conta_user = mysql_num_rows($q);
if($conta_user==1){
	$code = md5(time());
	$query = mysql_query("UPDATE zn_users SET codigo='$code' WHERE usuario='$username'");
	if($query){
		$emailuser = Email_username($username);
		Send_recover($emailuser,$code);
		echo 'Enviamos um link para seu e-mail, para redefinir sua senha!';
	}else{
		echo 'Erro 711 - Falha ao enviar';
	}

}else{
	echo 'Usu&aacute;rio n&atilde;o encontrado!';
}

  }else{
  	  echo 'SQL INJECTION NO!';
  }
?>
