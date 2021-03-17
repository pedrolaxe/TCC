<?php
include "includes/config.php";
global $mysqli;
$codigo = anti_injection(mysqli_real_escape_string($mysqli, $_GET['code']));
if(empty($codigo)){
  header("Location: login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPACEADMIN</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script>
	window.onkeydown = function( event ) {
	    if ( event.keyCode === 13 ) {
			document.getElementById('login').click();
	    }
	};
	</script>
</head>

<body class="login-container" id="gradient1">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					<form action="" method="post">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="logo-login"></div>
							<br>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" name="senha1" id="senha1" autocomplete="" placeholder="Digite a Nova Senha">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>

              <div class="form-group has-feedback has-feedback-left">
				<input type="password" class="form-control" name="senha2" id="senha2" autocomplete="" placeholder="Novamente a Senha">
				<div class="form-control-feedback">
					<i class="icon-lock2 text-muted"></i>
				</div>
			</div>
              <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>">

				<div class="form-group">
					<button type="button" class="btn btn-primary btn-block" id="recuperar">Alterar Senha <i class="icon-arrow-right14 position-right"></i></button>
				</div>

				<div class="text-center">
					<div id="error"></div>
				</div>

				</div>
			</form>
				
				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script>
$(document).ready(function(){

$('#recuperar').click(function(){
	var codigo=$("#codigo").val();
	var senha1=$("#senha1").val();
	var senha2=$("#senha2").val();
	var dataString = 'codigo='+codigo+'&senha1='+senha1+'&senha2='+senha2;
if($.trim(senha1).length>0 && $.trim(senha2).length>0){
$.ajax({
	type: "POST",
	url: "ajax/change_password.php",
	data: dataString,
	cache: false,
	beforeSend: function(){ $("#error").val('<img src="img/ajax-loader.gif">');},
	success: function(data){
		if(data){$("#error").html(data);}
		else{$("#error").html(data);}
	}
	});

}
return false;
});

});
</script>
</body>
</html>
