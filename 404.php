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

			<div class="content">

				<!-- Error title -->
				<div class="text-center content-group">
					<h1 class="error-title">404</h1>
					<h5>Opa, Você foi para um caminho que não existe...</h5>
				</div>

				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
						<div class="row">
							<div class="col-sm-12">
								<a href="index" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Volte a Homepage</a>
							</div>
						</div>
					</div>
				</div>

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

</body>
</html>
