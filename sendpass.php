<?php
include "includes/functions.php";
global $con;

$email = anti_injection(mysqli_real_escape_string($con, $_POST['email']));

 $sqlinject_usu = strpos($email, "'");

  if($sqlinject_usu == false){


$q = $con->query("SELECT email FROM usuario WHERE email='$email'");
$conta_user = $q->num_rows;
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