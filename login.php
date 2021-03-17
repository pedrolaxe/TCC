<?php
session_start();
if(!empty($_SESSION['usuario_admin']))
{
header('Location: index');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPACEADMIN</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<!-- /theme JS files -->
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
						<div class="panel panel-body login-form panel-login">
							<div class="text-center">
								<div class="logo-login"></div>
								<br>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuário/CPF">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="button" class="btn btn-primary btn-block" id="login">Entrar <i class="icon-circle-right2 position-right"></i></button>
							</div>

							<div class="text-center">
								<div id="error"></div>
							</div>

							<div class="text-center">
								<a href="recover">Esqueceu sua Senha?</a>
							</div>
						</div>
					</form>
					<!-- /simple login form -->


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

	$('#login').click(function(){
		var usuario=$("#usuario").val();
		var senha=$("#senha").val();
		var dataString = 'usuario='+usuario+'&senha='+senha;
		if($.trim(usuario).length>0){
			$.ajax({
				type: "POST",
				url: "ajax/zn_login.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#error").html('<i class="icon-spinner2 spinner"></i>');},
				success: function(data){
				if(data){
					$("#error").html(data);
				}
			}
			});

		}
	return false;
	});

	});
	</script>
</body>
</html>
