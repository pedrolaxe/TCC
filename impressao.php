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

function get_nome_estabelecimento() {
    # SELECT nome_estabelecimento FROM configs WHERE id = 1;
    $nome_estabelecimento = strtoupper("dêdal café");

    return $nome_estabelecimento;
}

function get_nome_impressora() {
    # SELECT nome_impressora FROM configs WHERE id = 1;
    $connector = new WindowsPrintConnector("Bematech");
    $printer = new Printer($connector);

    return $printer;
}

function imprimir_cozinha($nome, $qtd) {
  try {
    $printer = get_nome_impressora();

    # AUMENTANDO TAMANHO DA LETRA
    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);

    # PRINT QUANTIDADE E NOME DO PRODUTO
    $printer -> text($qtd." x ".$nome."\n\n");
    
    # FECHAR IMPRESSORA
    $printer -> close();

    return true;
  } catch (Exception $e) {
    return false;
  }
}

function imprimir_conta($total, $qtd_array, $nome_array, $qtdPreco_array, $nome, $desconto) {
  try {
    $nome_estabelecimento = get_nome_estabelecimento();
    $printer = get_nome_impressora();

    # PARA APARECER 'comanda 01' EM VEZ DE 'comanda 1'
    // if(strlen($nome) == 1) {
    //   $nome = str_pad($nome, 2, '0', STR_PAD_LEFT);
    // }

    # AUMENTANDO TAMANHO DA LETRA E CENTRALIZANDO
    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);

    $printer -> text($nome_estabelecimento."\n\n");

    # TAMANHO NORMAL DA LETRA E ALINHANDO TEXTO PARA A ESQUERDA
    $printer -> selectPrintMode(Printer::MODE_FONT_A);
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    
    $printer -> text("------------------------------------------------\n");

    # ESCREVER comanda, DATA E HORA
    $printer -> text("comanda: " . $nome . "\n");
    $printer -> text("DATA: " . date("d/m/y") . "\n");
    $printer -> text("HORA: " . date("H:i") . "\n");

    $printer -> text("------------------------------------------------\n\n");

    # AUMENTANDO TAMANHO DA LETRA E CENTRALIZANDO
    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);

    $printer -> text("PEDIDO\n\n\n");

    $printer -> selectPrintMode(Printer::MODE_FONT_A);

    # ESCREVENDO PRODUTOS CONSUMIDOS COM SUAS RESPECTIVAS QUANTIDADES E VALORES
    foreach ($qtd_array as $key => $value) {
      $printer -> setJustification(Printer::JUSTIFY_LEFT);
      $printer -> text($qtd_array[$key] . " x " . $nome_array[$key] . "\n");

      $printer -> setJustification(Printer::JUSTIFY_RIGHT);
      $printer -> text(number_format($qtdPreco_array[$key], 2 , ',', '.') . "\n");
    }

    $printer -> text("\n------------------------------------------------\n\n");

    $printer -> setJustification(Printer::JUSTIFY_RIGHT);

    # DESCONTO
    if($desconto != 0) {
      $printer -> text("DESCONTO: R$ " . number_format($desconto, 2, ',', '.') . "\n\n");

      $total -= $desconto;
    }

    # SUBTOTAL DA CONTA
    $printer -> text("SUBTOTAL: R$ " . number_format($total, 2, ',', '.') . "\n");

    $dezPorcento = $total * 0.1;

    # 10%
    $printer -> text("SERVIÇO: R$ " . number_format($dezPorcento, 2, ',', '.') . "\n\n");

    $total *= 1.1;

    # TOTAL DA CONTA
    $printer -> text("TOTAL: R$ " . number_format($total, 2, ',', '.') . "\n\n\n");


    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("SERVIÇO É OPCIONAL\n");
    
    # FECHAR IMPRESSORA
    $printer -> close();
    return true;
  } catch (Exception $e) { 
    return false;
  }
}

function nome_comanda($nome_comanda) {
  try {
    $printer = get_nome_impressora();

    # AUMENTANDO TAMANHO DA LETRA E CENTRALIZANDO
    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);

    # PARA APARECER 'comanda 01' EM VEZ DE 'comanda 1'
    // if(strlen($nome_comanda) == 1) {
    //   $nome_comanda = str_pad($nome_comanda, 2, '0', STR_PAD_LEFT);
    // }

    # PRINT nome DA comanda
    $printer -> text("\ncomanda ".$nome_comanda."\n\n\n");

    # TAMANHO NORMAL DA LETRA E ALINHANDO TEXTO PARA A ESQUERDA
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> selectPrintMode(Printer::MODE_FONT_A);

    $printer -> text("------------------------------------------------\n");

    # PRINT HORA
    $printer -> text("HORA: " . date("H:i")."\n");

    $printer -> text("------------------------------------------------\n\n\n");
    
    # FECHAR IMPRESSORA
    $printer -> close();
  } catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
  }
}

function cut() {
  try { 
    $printer = get_nome_impressora();

    # PULAR LINHA (PARA DAR MARGEM) E CORTAR PAPEL
    $printer -> text("\n");
    $printer -> cut();
    
    # FECHAR IMPRESSORA
    $printer -> close();
  } catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
  }
}

