<?php

if(basename($_SERVER['PHP_SELF']) == 'comandas.php') {
  $add_comanda = 
  '
  <form action="comandas.php" method="post" class="d-flex">
    <input class="form-control me-2" name="numero" type="text" placeholder="Abrir Comanda" aria-label="Search" autocomplete="off" required>
    <button class="btn-lg btn-outline-dark" type="submit" name="submit">Ok</button>
  </form>
  ';
} else { $add_comanda = ''; }

echo '

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-3 mb-3 border-bottom shadow-sm" >

  '.$add_comanda.'

  <a class="h5 my-0 me-md-auto fw-normal titulo-header" href="#"><h4 style="margin-left: 1.5vw; font-weight: bold;"></h4></a> 

  <nav class="my-2 my-md-0 me-md-3" style="">
  	<a class="p-2 text-dark" href="/comandas.php"><i class="fas fa-2x fa-home"></i></a>
    <a class="p-2 text-dark" style="margin-left:15px" href="/"><i class="fas fa-2x fa-sign-out-alt"></i></a>
  </nav>
</header>

	';

?>
