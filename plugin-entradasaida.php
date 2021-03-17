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
							<h4><i class="icon-user"></i> Entrada / Saída</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Entrada / Saída</li>
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
				<h5 class="panel-title">Entrada / Saída</h5>
				<div class="heading-elements">
                    <ul class="icons-list">
						<li><a data-action="collapse"></a></li>
					</ul>
				</div>
				</div>

                <div class="panel-body">

                    <form class="form-horizontal" action="" method="post">
                      
                      
					  <div class="input_fields_wrap" style="margin-left: -10px;">
					    <label class="control-label">Cod/Patrimônio: </label>
						<a id="add_field_button">Add Campo</a>
						<input type="text" id="codpat" name="codpat[]" class="form-control" placeholder="SUXXXXXX" style="margin-bottom:5px;width:200px;">
					  </div>

					  <div class="form-group">
						<label>Data Saída / Retorno: </label>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input type="text" class="form-control entradasaida" id="data-entradasaida"  value="<?php $date = date('d-m-Y'); echo $date .' - '. date('d-m-Y', strtotime($date. ' + 5 days')); ?>"> 
						</div>
					  </div>

					  <div class="form-group">
                        <label class="control-label">Projeto: </label>
						<input type="text" id="projeto" class="form-control">
                      </div>

                      <div class="form-group">
                        <label class="control-label">Status: </label>
							<select name="zn_status" id="zn_status" class="form-control" style="width:180px;">
								<option value="">Selecione</option>
								<option value="1">Entrada</option>
								<option value="2">Saída</option>
								<option value="3">SuperUber</option>
								<option value="4">Atrasado</option>
							</select>
                      </div>

                      <div class="form-group">
                        <button type="button" id="send" class="btn btn-success">Cadastrar</button>
                        <br>
                        <div id="resultado"></div>
                      </div>
                     
                    </form>

                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="panel panel-flat">
                <div class="panel-heading">
				<h5 class="panel-title">Entrada / Saída</h5>
                  <div class="heading-elements">
                    <ul class="icons-list">
                              <li><a data-action="collapse"></a></li>
                            </ul>
                          </div>
                </div>

                <div class="panel-body">
				
				<table class="table datatable-scroll-y">
							<thead>
								<tr>
									<th>Código</th>
									<th>Dt. Saída</th>
									<th>Dt. Retorno</th>
									<th>Projeto</th>
									<th>Status</th>
									<th>Usuário</th>
									<th>Data-Hora</th>
									<th>Ações</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$select_saida = $mysqli->query("SELECT * FROM zn_entradasaida");
							
							while($lista = $select_saida->fetch_assoc()){

							?>
							<tr>
								<td><?php echo $lista['codpat']; ?></td>
								<td><?php echo $lista['dt_sai']; ?></td>
								<td><?php echo $lista['dt_ent']; ?></td>
								<td><?php echo $lista['projeto']; ?></td>
								<td><?php echo Status_equip($lista['status']); ?></td>
								<td><?php echo $lista['usuario']; ?></td>
								<td><?php echo $lista['data'].' '.$lista['hora']; ?></td>
								<td class="text-center">
									<a href="edit-entradasaida?id=<?php echo base64_encode($lista['id']);?>" class="btn btn-info"><i class="icon-pencil5"></i></a>
									<a href="ajax/rm_entradasaida?id=<?php echo base64_encode($lista['id']);?>" class="btn btn-danger"><i class="icon-trash"></i></a>
								</td>
							</tr>
							<?php }	?>

							</tbody>
						</table>
					
                </div>
              </div>
            </div>
            </div>

	<script>
	$(document).ready(function(){

		$('#send').click(function(){

			var codpat=$("input[name='codpat[]']").map(function(){ 
                    return this.value; 
				}).get();
				
			var data=$("#data-entradasaida").val();
			var zn_status=$("#zn_status").val();
			var projeto=$("#projeto").val();

		if($.trim(codpat).length>0 && $.trim(data).length>0 && $.trim(zn_status).length>0 ){
			$.ajax({
				type: "POST",
				url: "ajax/cad_entradasaida.php",
				data: {
						'codpat[]': codpat,
						'data': data,
						'zn_status': zn_status,
						'projeto': projeto
                    },
				cache: false,
				beforeSend: function(){ $("#resultado").html('<i class="icon-spinner2 spinner"></i>');},
				success: function(data){
					if(data=='true'){
						window.location.href = "plugin-entradasaida";
					}
					else{
						$("#resultado").html(data);
					}

				}
				});

		}
		return false;
		});
	});

     //add fields
	 $(document).ready(function() {
            var max_fields      = 20; //maximum input boxes allowed
            var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID
            
            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><input type="text" id="codpat" name="codpat[]" placeholder="SUXXXXXX" class="form-control"><a href="#" class="remove_field">Remover</a></div>'); //add input box
                }
            });
            
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
			})
			
    //
    // Date range
	//
	 // Basic initialization
	 $('.entradasaida').daterangepicker({
        applyClass: 'bg-slate-600',
		cancelClass: 'btn-default',
		locale: {
            format: 'DD/MM/YYYY'
        }
    });
		});
		
</script>
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
