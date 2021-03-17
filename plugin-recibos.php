<?php
    if(!isset($_SESSION['usuario_admin'])){
        session_start();
    }
    include "verifica.php";
    //admin_page($_SESSION['id_adm']);
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); 
@$idcliente = anti_injection($_GET['zn_clients']);
?>

    </div>
    </div>
    <!-- /main sidebar -->

    <!-- Main content -->
    <div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-list2"></i> Gerar Recibos</h4>
            </div>

        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Gerar Recibos</li>
            </ul>
        </div>
    </div>
  
    <div class="content">

    <div class="row">

    <div class="col-md-12">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">Gerar Recibos</h6>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>

        <div class="panel-body">

        <div class="row">
            <div class="col-md-2">
                <form method="get" action="">
                    <div class="form-group">
                        <label>Cliente</label><br>
                        <?php 
                        if(is_numeric($idcliente) && !empty($idcliente)){
                            Select_editclientes($idcliente);
                        }else{
                            Select_clients();
                        }
                         ?>
                        <input type="submit" class="btn btn-primary" id="filtrarcliente" style="display:none">
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <form method="get" action="">
                    <div class="form-group">
                        
                        <?php 
                        if(is_numeric($idcliente) && !empty($idcliente)){
                            echo '<label>Selecionar Mês</label><br>';
                            Select_dateexport($idcliente);
                        }else{
                           
                        }
                         ?>
                         <br>
                         <br>
                         <div id="showbtn"></div>
                        
                        <input type="submit" class="btn btn-primary" id="filtrarcliente" style="display:none">
                    </div>
                </form>
            </div>
        </div>
        
    </div>

        </div>
            </div><!--/row -->
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
            $("#zn_dataexp").change(function(){
                var datames = $(this).find(':selected').val();
                var dataano = $(this).find(':selected').data('ano');
                var idcli = $(this).find(':selected').data('cliente');
                $( "#relatsave" ).remove();

                if(datames.length > 0 ){
                    console.log("Mes: ",datames);
                    console.log("Ano: ",dataano);
                    console.log("Ano: ",idcli);
                    $( "#showbtn" ).show( 400, function() {
                        
                        jQuery('<a>').attr(
                            'href', 'ajax/gera_relat?cliente='+idcli+'&mes='+datames+'&ano='+dataano).attr('target', '_blank').attr('class', 'btn btn-success').attr('id', 'relatsave').text('Gerar Recibo').appendTo('#showbtn');
                    
                    });
                }

            });

            $("#zn_clients").change(function(){
                $('#filtrarcliente').click();
            });

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
                            url: "ajax/#.php",
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
