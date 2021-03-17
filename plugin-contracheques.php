<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
admin_page($_SESSION['id_adm']);
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

				</div>
			</div>
			<!-- /main sidebar -->

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-folder-plus"></i> Contra-Cheques</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Contra-Cheques</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

  					<div class="row">
  						<div class="col-md-6">
                <div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Enviar Contra-cheques</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
							<li><a data-action="close"></a></li>
						</ul>
					</div>
				</div>

  								<div class="panel-body">
                    <form class="form-horizontal" method="post" action="ajax/envia-cq.php" enctype="multipart/form-data">

						<div class="form-group">
							<label>Funcionário:</label>
							<?php SelectFuncionariosName(); ?>
						</div>

						<div class="form-group">
							<label>Arquivo: Até 2mb</label>
							<input type="file" name="arquivocq[]" class="file-input" multiple="multiple">
						</div>

						<div class="text-right">
							<input type="submit" class="btn btn-primary" value="Cadastrar">
						</div>
					</form>
                  <div id="resultado"></div>
  								</div>
  							</div>
  						</div>

				<div class="col-md-6">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h6 class="panel-title">Carregar Contra-cheques</h6>
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="collapse"></a></li>
									<li><a data-action="reload"></a></li>
									<li><a data-action="close"></a></li>
								</ul>
							</div>
						</div>

				<div class="panel-body">

					<div class="table-responsive">
						<table class="table datatable-basic">
							<thead>
								<tr>
									<th>Funcionário</th>
									<th>Tipo</th>
									<th>Arquivo</th>
									<th>Data</th>
									<th>Status</th>
									<th>Ações</th>
								</tr>
							</thead>
							<tbody id="respcq">
							</tbody>
						</table>
					</div>
					
				</div>
    					<!-- /basic datatable -->



  						</div>
  					</div><!--/row -->
  					<!-- /panel heading options -->



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
	<!-- /page container -->
  <script type="text/javascript">
  			function fetch_select(val){
  			 $.ajax({
				type: 'post',
				url: 'ajax/cqbyuser.php',
				data: {
				get_option:val
				},
				success: function (response) {
					$('#respcq').html(response);
				}
			});
  			}
  		</script>
</body>
</html>
