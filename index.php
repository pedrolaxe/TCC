<?php
	if(!isset($_SESSION['usuario_admin'])){
		session_start();
	}
	include "verifica.php";
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

		</div>
	</div>

	<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><span class="text-semibold">Home</span> - SPACEADMIN</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Painel</li>
			</ul>
		</div>
	</div>

	<div class="content">
		<?php AlertnoApi(); ?>
	<div class="row" style="margin-bottom:20px">

		<div class="col-6 col-sm-2">
			<a class="btn bg-slate-800 btn-block btn-float btn-float-lg" href="plugin-clientes"><i class="icon-users4"></i> <span>Clientes</span></a>
		</div>
		<div class="col-6 col-sm-2">
			<a class="btn bg-slate-800 btn-block btn-float btn-float-lg" href="plugin-pedidos"><i class="icon-cart5"></i> <span>Pedidos</span></a>
		</div>
		<div class="col-6 col-sm-2">	
			<a class="btn bg-slate-800 btn-block btn-float btn-float-lg" href="plugin-equipamentos"><i class="icon-coin-dollar"></i> <span>Serviços</span></a>
		</div>
		<div class="col-6 col-sm-2">	
			<a class="btn bg-slate-800 btn-block btn-float btn-float-lg" href="plugin-recibos"><i class="icon-clipboard6"></i> <span>Gerar Recibos</span></a>
		</div>	
		
	</div><!-- /row-->
		
<?php include FOOTER; ?>
</div>
</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>
