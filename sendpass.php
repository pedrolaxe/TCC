<?php
include "includes/functions.php";
global $con;

$email = anti_injection($_POST['email']);

 $sqlinject_usu = strpos($email, "'");

  if($sqlinject_usu == false){


$q = $con->prepare("SELECT email FROM usuario WHERE email='$email'");
$q->execute();
$conta_user = $q->rowCount();
if($conta_user==1){
	$code = md5(time());
	$query = $con->query("UPDATE usuario SET codigo='$code' WHERE email='$email'");
	if($query){

		Send_recover($email, $code);
		echo 'Enviamos um link para seu e-mail, para redefinir sua senha!';
	}else{
		echo 'Falha ao enviar';
	}

}else{
	echo 'Usu&aacute;rio n&atilde;o encontrado!';
}

  }else{
  	  echo 'SQL INJECTION NO!';
  }
  ?>