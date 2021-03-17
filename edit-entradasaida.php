<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
admin_page($_SESSION['id_adm']);
global $mysqli;
$idequip = anti_injection(mysqli_real_escape_string($mysqli, base64_decode($_GET['id'])) );
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

		</div>
	</div>
		
	<div class="content-wrapper">

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
				
		<div class="content">

          <div class="row">
            <div class="col-md-4">
              <div class="panel panel-flat">
                <div class="panel-heading">
                  <h5 class="panel-title">Entrada / Saída</h5>
                  <div class="heading-elements"></div>
                </div>

                <div class="panel-body">

				<form class="form-horizontal" action="" method="post">
				<input type="hidden" name="identsai" id="identsai" value="<?php echo $idequip;?>">
				<?php
					$edit = $mysqli->query("SELECT * FROM zn_entradasaida WHERE id='$idequip'");
					if($edit->num_rows > 0){
					while($list = $edit->fetch_assoc()){
				?>
					
					<div class="form-group">
					<label class="control-label">Cod/Patrimônio: </label>
					<input type="text" id="codpat" name="codpat[]" class="form-control tokenfield" value="<?=$list['codpat'];?>">
					</div>

					<div class="form-group">
					<label>Data Saída / Retorno: </label>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-calendar22"></i></span>
						<input type="text" class="form-control entradasaida" id="data-entradasaida"  value="<?php echo $list['dt_sai'] .' - '. $list['dt_ent']; ?>"> 
					</div>
					</div>

					<div class="form-group">
					<label class="control-label">Projeto: </label>
					<input type="text" id="projeto" class="form-control" value="<?=$list['projeto'];?>">
					</div>

					<div class="form-group">
					<label class="control-label">Status: </label>
						<?php Select_EditStatus($list['id'], $list['status']) ?>
					</div>
					<?php
					}}
					?>

					<div class="form-group">
					<button type="button" id="send" class="btn btn-info">Salvar</button>
					<br>
					<div id="resultado"></div>
					</div>
					
				</form>

                </div>
              </div>
            </div>
	<script>
	$(document).ready(function(){

		$('#send').click(function(){

			var identsai=$("#identsai").val();
			var codpat=$("input[name='codpat[]']").map(function(){ 
                    return this.value; 
				}).get();
				
			var data=$("#data-entradasaida").val();
			var zn_status=$("#zn_status").val();
			var projeto=$("#projeto").val();

		if($.trim(codpat).length>0 && $.trim(identsai).length>0 && $.trim(zn_status).length>0 ){
			$.ajax({
				type: "POST",
				url: "ajax/edit_entsai.php",
				data: {
						'identsai': identsai,
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
