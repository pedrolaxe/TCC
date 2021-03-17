<?php

date_default_timezone_set('America/Sao_Paulo');

/* Change to the correct path if you copy this example! */
require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */

function imprimir_cozinha($nome, $qtd) {

try {

    $connector = new WindowsPrintConnector("Bematech");

    $printer = new Printer($connector);
    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    // $printer -> selectJustification(Printer::JUSTIFY_CENTER);

    // $printer -> text("\n\n");

    $printer -> text($qtd." x ".$nome."\n\n");
    // $printer -> cut();

    // $printer -> text("\n\n");
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

}



function imprimir_conta($total, $qtd_array, $nome_array, $qtdPreco_array, $numero) {

try {

    $connector = new WindowsPrintConnector("Bematech");
    $printer = new Printer($connector);

    // PARA APARECER 'MESA 01' EM VEZ DE 'MESA 1'
    if(strlen($numero) == 1) {
      $numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
    }


    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);


    $printer -> text("DÊDAL CAFÉ\n\n");

    $printer -> selectPrintMode(Printer::MODE_FONT_A);
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    

    $printer -> text("------------------------------------------------\n");

    $printer -> text("MESA: " . $numero . "\n");
    $printer -> text("DATA: " . date("d/m/y") . "\n");
    $printer -> text("HORA: " . date("H:i") . "\n");

    $printer -> text("------------------------------------------------\n\n");



    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);

    $printer -> text("PEDIDO\n\n\n");

    $printer -> selectPrintMode(Printer::MODE_FONT_A);


    foreach ($qtd_array as $key => $value) {

      $printer -> setJustification(Printer::JUSTIFY_LEFT);
      $printer -> text($qtd_array[$key] . " x " . $nome_array[$key] . "\n");


      $printer -> setJustification(Printer::JUSTIFY_RIGHT);
      $printer -> text(number_format($qtdPreco_array[$key], 2 , ',', '.') . "\n");

    }


    $printer -> text("\n------------------------------------------------\n\n");


    // $printer -> setJustification(Printer::JUSTIFY_LEFT);
    // $printer -> text("TOTAL:\n");

    $printer -> setJustification(Printer::JUSTIFY_RIGHT);
    $printer -> text("TOTAL: R$ " . number_format($total, 2, ',', '.') . "\n");
    // $printer -> text("TOTAL: " . $total . "\n");
    // $printer -> text("TOTAL: " . $total . "\n");
    // $printer -> text("TOTAL: " . $total . "\n");

    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

}



function numero_mesa($numero_mesa) {

    try {

    $connector = new WindowsPrintConnector("Bematech");

    $printer = new Printer($connector);

    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);

    // $printer -> setJustification(Printer::JUSTIFY_RIGHT);
    // $printer -> text(date("H:i")."\n\n");


    $printer -> setJustification(Printer::JUSTIFY_CENTER);

    // PARA APARECER 'MESA 01' EM VEZ DE 'MESA 1'
    if(strlen($numero_mesa) == 1) {
      $numero_mesa = str_pad($numero_mesa, 2, '0', STR_PAD_LEFT);
    }


    $printer -> text("\nMESA ".$numero_mesa."\n\n\n");

    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> selectPrintMode(Printer::MODE_FONT_A);

    $printer -> text("------------------------------------------------\n");

    $printer -> text("HORA: " . date("H:i")."\n");

    $printer -> text("------------------------------------------------\n\n\n");
    
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

}


function cut() {

try {

    $connector = new WindowsPrintConnector("Bematech");

    $printer = new Printer($connector);
    $printer -> text("\n");
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

}

