<?php
    if(!isset($_SESSION['usuario_admin'])){
        session_start();
    }
    include "verifica.php";
    //admin_page($_SESSION['id_adm']);
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
							<h4><i class="icon-user"></i> Cadastro de Serviços</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Cadastro de Serviços</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

                <div class="row">
                <div class="col-md-4">
                <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title">Cadastrar Serviço</h6>
                </div>

                <div class="panel-body">
                <form class="form-horizontal" action="" method="post">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome">
                </div>

                <div class="form-group">
                    <label>Cliente</label><br>
                    <?php Select_clients(); ?>
                </div>

                <div class="form-group">
                    <label>Valor</label>
                    <input type="text" class="form-control" id="valor">
                </div>

                <div class="form-group">
                    <label>Observação:</label>
                    <input type="text" class="form-control" id="obs">
                </div>

                <div class="text-right">
                    <button type="button" id="cadastrar" class="btn bg-slate-800">Cadastrar</button>
                </div>
                </form>
                  <div id="resultado"></div>
                </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">Serviços Cadastrados</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>

                <div class="panel-body">
                
                <table class="table datatable-basic">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Observação</th>
                            <th></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                  <tbody>

            <?php
                $query = $mysqli->query("SELECT * FROM zn_equipamentos ORDER BY id DESC");
                while($linha = $query->fetch_assoc()){
            ?>
            <tr>
                <td><?=$linha['nome'];?></td>
                <td><?=Nome_cliente($linha['cliente']);?></td>
                <td>R$ <?=$linha['valor'];?></td>
                <td><?=$linha['obs'];?></td>
                <td></td>
                <td class="text-center">
                    <a href="edit_equipamentos?id=<?php echo base64_encode($linha['id']);?>" class="btn btn-info btn-xs"><i class="icon-pencil5"></i></a>
                    <a href="ajax/rm_equip?id=<?php echo base64_encode($linha['id']);?>" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                </td>

            </tr>
            <?php } ?>

    		</tbody>
    		</table>
              
              </div>

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
  <script>
  		$(document).ready(function(){
            jQuery(function($){
                $("#valor").mask("999.999.999.99", {reverse: true});
            });

            $('#cadastrar').click(function()
            {
                var nome             = $("#nome").val();
                var zn_clients       = $("#zn_clients").val();
                var valor            = $("#valor").val();          
                var obs              = $("#obs").val();
                console.log("dados: ", nome, zn_clients, valor, obs)
            
                var dataString = 'nome='+nome+'&zn_clients='+zn_clients+'&valor='+valor+'&obs='+obs;
                
                if($.trim(nome).length>0)
                {
                        $.ajax({
                            type: "POST",
                            url: "ajax/cad_equipamento.php",
                            data: dataString,
                            cache: false,
                            beforeSend: function(){ $("#resultado").html('Aguarde...');},
                            success: function(data){
                                if(data){
                                    $("#resultado").html(data);
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
