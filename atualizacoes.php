<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
?>﻿
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

		</div>
	</div>

	<div class="content-wrapper">

	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-hammer-wrench"></i> Atualizações do Sistema</h4>
			</div>
		</div>
		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Atualizações do Sistema</li>
			</ul>
		</div>
	</div>

	<div class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title"></h5>
					<div class="heading-elements"></div>
				</div>
				<div class="panel-body">
						Última verificação em <?php echo date('d/m/Y')." às ".date('H:i'); ?>
						<h5>Versão do Sistema: <?php echo VERSION; ?></h5>
					<?php
					$myapi = ReturnMyAPI();
					VerifyUpdates($myapi, VERSION);
					?>
				</div>
			</div>
		</div>
	</div>

<!-- Footer -->
<?php include FOOTER; ?>
<!-- /footer -->

</div>
<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>

</body>
</html>
