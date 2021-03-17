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

			<div class="content-wrapper">

  <!-- Page header -->
  <div class="page-header page-header-default">
    <div class="page-header-content">
      <div class="page-title">
        <h4><i class="icon-hammer-wrench"></i> Módulos</h4>
      </div>

    </div>

    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
        <li class="active">Ativar Módulos</li>
      </ul>
    </div>
  </div>

  <div class="content">

  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title">Ativar Módulos</h5>
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
              <li><a data-action="reload"></a></li>
              <li><a data-action="close"></a></li>
            </ul>
          </div>
        </div>

    <div class="panel-body">
      <form class="form-horizontal" action="ajax/ativa_plugin.php" method="post">
        <fieldset>
        <div class="form-group">
          <?php List_plugins_inativo(); ?>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <div id="resultado"></div>
        </div>
        </fieldset>
      </form>

    </div>
  </div>
</div>

<div class="col-md-6">
  <div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title">Desativar Plugins</h5>
      <div class="heading-elements">
        <ul class="icons-list">
          <li><a data-action="collapse"></a></li>
          <li><a data-action="reload"></a></li>
          <li><a data-action="close"></a></li>
        </ul>
      </div>
    </div>

  <div class="panel-body">
    <form class="form-horizontal" action="ajax/desativa_plugin.php" method="post">
      <fieldset>
      <div class="form-group">
        <?php List_plugins_ativos(); ?>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <div id="resultado"></div>
      </div>
      </fieldset>
    </form>

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
