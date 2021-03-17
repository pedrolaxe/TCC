<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
global $mysqli;
$idequip = anti_injection(mysqli_real_escape_string($mysqli, base64_decode($_GET['id'])) );
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
							<h4><i class="icon-user"></i> Editar Serviço</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Editar Serviço</li>
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
                            <h6 class="panel-title">Editar Serviço</h6>
                        </div>

                        <div class="panel-body">
                        <form class="form-horizontal" action="" method="post">
                        <input type="hidden" id="idequip" value="<?=$_GET['id'];?>">
                        <?php
                            $edit = $mysqli->query("SELECT * FROM zn_equipamentos WHERE id='$idequip'");
                            if($edit->num_rows > 0){
                                while($list = $edit->fetch_assoc()){
                        ?>
                        
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" id="nome" value="<?=$list['nome'];?>">
                        </div>

                        <div class="form-group">
                            <label>Cliente</label><br>
                            <?php Select_editclientes($list['cliente']); ?>
                        </div>

                        <div class="form-group">
                            <label>Valor</label>
                            <input type="text" class="form-control" id="valor" value="<?=$list['valor'];?>">
                        </div>

                        <div class="form-group">
                            <label>Observação:</label>
                            <input type="text" class="form-control" id="obs" value="<?=$list['obs'];?>">
                        </div>
                        <?php
      						}}else{ echo '<script>window.location.href = "plugin-equipamentos";</script>';}
      					?>
                        <div class="text-right">
                            <button type="button" id="cadastrar" class="btn bg-slate-800">Salvar Modificações</button>
                        </div>
                    </form>
                    <div id="resultado"></div>
                        </div>
                    </div>
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
                $("#valor").mask("999.999.999,99", {reverse: true});
            });

            $('#cadastrar').click(function()
            {
                var idequip          = $("#idequip").val();
                var nome             = $("#nome").val();
                var zn_clients       = $("#zn_clients").val();
                var valor            = $("#valor").val();          
                var obs              = $("#obs").val();
                console.log("dados: ", nome, zn_clients, valor, obs)
            
                var dataString = 'idequip='+idequip+'&nome='+nome+'&zn_clients='+zn_clients+'&valor='+valor+'&obs='+obs;
                
                if($.trim(nome).length>0)
                {
                        $.ajax({
                            type: "POST",
                            url: "ajax/edit_equip.php",
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
