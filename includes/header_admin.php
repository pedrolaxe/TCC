<?php

if(basename($_SERVER['PHP_SELF']) == 'comandas.php') {
  $extra = 
  '
  <form action="comandas.php" method="post" class="d-flex">
    <input class="form-control me-2" name="nome" type="text" placeholder="Abrir Comanda" aria-label="Search" autocomplete="off" required>
    <button class="btn-lg btn-outline-dark" type="submit" name="submit">Ok</button>
  </form>
  ';
} elseif(basename($_SERVER['PHP_SELF']) == 'painel.php') {

 $query = "SELECT * FROM config WHERE id_config = 1";
    $result = $con->query($query);

    foreach($result as $row) {

        $nome_empresa = $row['nome_empresa'];
    }

  $extra = '
  <div class="d-flex" style="padding: 0% 8.5%;">
    <h2>'.$nome_empresa.'</h2>
  </div>
  ';

} else { $extra = ''; }

echo '
<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-3 mb-3 border-bottom shadow-sm" >

  '.$extra.'

  <a class="h5 my-0 me-md-auto fw-normal titulo-header" href="#"><h4 style="margin-left: 1.5vw; font-weight: bold;"></h4></a> 

  <nav class="my-2 my-md-0 me-md-3">
  	<a class="p-2 text-dark" href="'.LINK_SITE.'admin/comandas.php"><i class="fas fa-2x fa-home i-menu"></i></a>';

    if ( $_SESSION['tipo_usuario'] == 'administrador' ) {

      echo '<a class="p-2 text-dark" style="margin-left:15px" href="'.LINK_SITE.'admin/painel.php"><i class="fas fa-2x fa-cogs i-menu"></i></a>';

    }

    echo '
    <a class="p-2 text-dark" style="margin-left:15px" href="'.LINK_SITE.'"><i class="fas fa-2x fa-sign-out-alt i-menu"></i></a>
  </nav>
</header>

	';
