<?php
    if(!isset($_SESSION['usuario_admin'])){
        session_start();
    }
    include "verifica.php";
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
                        <h4><i class="icon-user"></i> Listar Pedidos</h4>
                    </div>


                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
                        <li class="active">Listar Pedidos</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->


				<!-- Content area -->
    <div class="content">

    

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title">Listar Pedidos</h6>
                    <div class="heading-elements">
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

        
        <table class="table datatable-scroll-y">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Nº Boleta</th>
                        <th>Data Pedido</th>
                        <th>Produtos</th>
                        <th>Observação</th>
                        <!-- <th>Ações</th> -->
                    </tr>
                </thead>
                <tbody>

                <?php

                if(is_numeric($idcliente) && !empty($idcliente)){
                    $query = $mysqli->query("SELECT * FROM zn_pedidos WHERE codcliente='$idcliente' ORDER BY datapedido DESC");
                }else{
                    $query = $mysqli->query("SELECT * FROM zn_pedidos ORDER BY datapedido DESC");
                } 
                    while($linha = $query->fetch_assoc()){
                ?>
                <tr>
                    <td><?php if(!empty($linha['codcliente'])){echo Nome_cliente($linha['codcliente']);}?></td>
                    <td><?=$linha['numboleta'];?></td>
                    <td><?=$linha['datapedido'];?></td>
                    <td>
                        <?php GeraTableProd($linha['save_cart']); ?>       
                    </td>
                    <td><?=$linha['observacao'];?></td>
                    <!-- <td class="text-center">
                        <a href="ajax/rm_pedido?id=<?php //echo base64_encode($linha['id']);?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                    </td> -->

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
            $("#zn_clients").change(function(){
                $('#filtrarcliente').click();
            });
                
        });

</script>
 <!-- Basic modal -->
 <div id="modal_cart" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Basic modal</h5>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold">Text in a modal</h6>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>

                <hr>

                <h6 class="text-semibold">Another paragraph</h6>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- /basic modal -->
</body>
</html>