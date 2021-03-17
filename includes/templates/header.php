<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php Site_title(); ?></title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo URLSITE; ?>/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo URLSITE; ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo URLSITE; ?>/assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?php echo URLSITE; ?>/assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?php echo URLSITE; ?>/assets/css/colors.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/core/libraries/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/forms/tags/tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/forms/tags/tokenfield.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/ui/prism.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/plugins/tables/datatables/datatables.min.js"></script>

	<?php ScriptLoad(); ?>

	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/range.js"></script>
	<script type="text/javascript" src="<?php echo URLSITE; ?>/assets/js/core/app.js"></script>
	
</head>

<body>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index"><img src="assets/images/logo_sistema.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav">
			<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">

			<li class="dropdown dropdown-user">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<img src="<?php GetFotoPerfil($_SESSION['usuario_admin']); ?>" alt="">
					<span><?php echo Nome_inteiro(); ?></span>
					<i class="caret"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="meu-perfil"><i class="icon-user"></i> Meu Perfil</a></li>
					<li class="divider"></li>
					<li><a href="sair"><i class="icon-switch2"></i> Sair</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div><!-- /main navbar -->

	<!-- Page container -->
	<div class="page-container">

	<!-- Page content -->
	<div class="page-content">

	<!-- Main sidebar -->
	<div class="sidebar sidebar-main">
	<div class="sidebar-content">
