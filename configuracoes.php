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
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-hammer-wrench"></i> Configurações</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Configurações</li>
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
                  <h6 class="panel-title"></h6>
                  <div class="heading-elements"></div>
                </div>

                <div class="panel-body">
                      <?php
                    $query = $mysqli->query("SELECT * FROM zn_options");
                    while($linha = $query->fetch_assoc()){

                    ?>
                    <form class="form-horizontal" action="ajax/options.php" method="post">
                      <fieldset>
                      <div class="form-group">
                        <label>Nome do Site: </label>
                        <input name="nome_site" class="form-control" type="text" value="<?=$linha['nome_site'];?>" required>
                      </div>
                      <div class="form-group">
                        <label>Descrição: </label>
                        <input name="desc_site" class="form-control" type="text" value="<?=$linha['desc_site'];?>" required>
                      </div>

                      <div class="form-group">
                        <label>Chave de Ativação: </label>
                        <input name="apikey" class="form-control" type="text" value="<?=$linha['apikey'];?>" placeholder="SUA LICENÇA"><br> Status: <?php if(!empty($linha['apikey'])){VerifyApi($linha['apikey']);} ?>
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <div id="resultado"></div>
                      </div>
                      </fieldset>
                    </form>
                    <?php
                    }
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
	<!-- /page container -->

</body>
</html>
