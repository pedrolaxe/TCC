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
                        <h4><i class="icon-user"></i> Pedidos</h4>
                    </div>


                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
                        <li class="active">Cadastro de Pedidos</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->


				<!-- Content area -->
                <div class="content">

                    <div class="row">
                    <div class="col-md-8">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h6 class="panel-title">Cadastrar Pedidos</h6>
                        </div>

                    <div class="panel-body">
                    <form class="form-horizontal" action="" method="post">

                    <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Cliente</label><br>
                        <?php Select_clients(); ?>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Número da Boleta</label>
                            <input type="number" class="form-control" id="numboleta">
                        </div>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data Pedido </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    <input type="text" class="form-control" id="datapedido" value="<?php echo date('d/m/Y'); ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Unit.</th>
                                    <th>Valor Total</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    <?php Select_equip(); ?>
                                    </td>
                                    <td><input type="number" placeholder="Quant." class="form-control" id="quantidade"></td>
                                    <td><input type="text" class="form-control" id="valunit"  disabled="true"></td>
                                    <td><input type="text" class="form-control" id="valtotal" disabled="true"></td>
                                    <td>
                                        <button type="button" class="btn btn-success" id="addprod"><i class="icon-add"></i></button>
                                        <button type="button" class="btn btn-danger" id="delprod"><i class="icon-subtract"></i></button>
                                    </td>
                                </tr>
                            </tbody>
    		            </table>
                        </div>
                    </div>
                    <br>
                    <table class="table" id="tbladd">
                        <thead>
                            <tr>
                                <th>Selecionar</th>
                                <th>Serviço</th>
                                <th style="display:none">codserv</th>
                                <th>Quantidade</th>
                                <th>Valor Unit.</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <input type="hidden" value="" id="save_cart">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Observação:</label>
                                <textarea col="60" row="20" id="observacao" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" id="cadastrar" class="btn bg-slate-800">Cadastrar</button>
                    </div>
                </form>
                    <div id="resultado"></div>
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

    $('#tbladd').hide();
    $('#datapedido').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'dd/mm/yyyy',
        monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    });

            $("#addprod").click(function(){
                $('#tbladd').show("fast");
                var nome = $("#zn_equip").find('option:selected').text();
                var codprod = $("#zn_equip").val();
                var quant = $("#quantidade").val();
                var valunit = $("#valunit").val();
                var valtotal = $("#valtotal").val();

                var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + nome + "</td><td style='display:none'>" + codprod + "</td><td>" + quant + "</td><td>" + valunit + "</td><td>" + valtotal + "</td></tr>";
                $("#tbladd tbody").append(markup);
            });
            
            // Find and remove selected table rows
            $("#delprod").click(function(){
                $("#tbladd tbody").find('input[name="record"]').each(function(){
                    if($(this).is(":checked")){
                        $(this).parents("tr").remove();
                    }
                });
            });

            function GetProdArray(){
                const arraycart = $("#tbladd tbody tr").map(function(i, row) {
                const data = $('td', row);
                return {
                    servico: data.eq(2).text().trim(),
                    quant: data.eq(3).text().trim(),
                    vunitario: data.eq(4).text().trim(),
                    vtotal: data.eq(5).text().trim()
                }
                }).get();

                $('#save_cart').val(JSON.stringify(arraycart))
                console.log(arraycart);
            }//fim function



        $("#zn_equip").change(function(){
            var equipid = $(this).val();
            var dataString = 'equipid='+equipid
            console.log(dataString)
            
            $.ajax({
                url: 'ajax/get_prods.php',
                type: "POST",
                data: dataString,
                dataType: 'JSON',
                success:function(response){
                    
                    var len = response.length;

                    $('#valunit').val(response[0]['valor']);

                    $("#quantidade").keyup(function () {
                        var valquant = $('#quantidade').val()
                        var valunit = response[0]['valor'];
                        console.log("mudou")
                        if(valquant.length > 0){
                            var vtotal = (parseFloat(valquant) * parseFloat(valunit));
                            vtotal = vtotal.toFixed(2)
                            $('#valtotal').val(vtotal);       
                        } 
                    });

                }
            });
        });
        $('#cadastrar').click(function(){
            GetProdArray();  
        var zn_clients      = $("#zn_clients").val();
        var numboleta       = $("#numboleta").val();
        var datapedido      = $("#datapedido").val();
        var save_cart       = $("#save_cart").val();
        var observacao      = $("#observacao").val();
    
        var dataString = 'zn_clients='+zn_clients+'&numboleta='+numboleta+'&datapedido='+datapedido+'&save_cart='+save_cart+'&observacao='+observacao;
        
        if($.trim(numboleta).length>0){
                $.ajax({
                    type: "POST",
                    url: "ajax/cad_pedido.php",
                    data: dataString,
                    cache: false,
                    //dataType: "JSON",
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