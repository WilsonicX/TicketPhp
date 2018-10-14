<?php
require __DIR__."/autoload.php";
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$nombre_impresora = "StarSP500CutterSP542";
$obj = json_decode($_REQUEST['data']);

try{

  $connector = new WindowsPrintConnector($nombre_impresora);
  $printer = new Printer($connector);

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

  /*
      Ahora vamos a imprimir un encabezado
  */
  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text($obj->{'razonSocial'} . "\n");
  $printer->text("R.U.C.: " . $obj->{'ruc'} . "\n");
  $printer->text($obj->{'direccion'} . "\n");
  $printer->text("Telf: " . $obj->{'telefono'} . "\n");
  $printer->text($obj->{'email'} . "\n\n\n");

  /*Impresion de la cabecera*/
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->text("Doc: Nota Venta " . $obj->{'serie'} . "-" . $obj->{'numero'} . "\n");
  $printer->text("Fecha Emisión: " . $obj->{'fecha'} . "\n");

  /*Impresion de la cabecera del detalle*/
  $printer->text("----------------------------------------" . "\n");
  //$printer->text("Cant x Prec. Unit.     Producto     " . "\n");
  $printer->text("Cant.  ");
  $printer->text("Descripción   ");
  $printer->text("Prec.Unit   ");
  //$printer->setJustification(Printer::JUSTIFY_RIGHT);
  $printer->text("Importe"  . "\n");
  $printer->text("----------------------------------------" . "\n");

  /* Ahora vamos a imprimir los productos*/
  $listaProductos = $obj->{'detalle'};
  foreach ($listaProductos as $fila => $item)
  {
    #Alinear a la izquierda para la cantidad y el nombre
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    //$printer->text($item->cantidad . "x S/. " . $item->precioUnitario ." " . $item->producto . "\n");
	$printer->text($item->cantidad ." ");
	$printer->text($item->producto ." ");
	$printer->text($item->precioUnitario ." ");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text("S/. " . $item->costoTotal . "\n");
  }

  /* Terminamos de imprimir los productos, ahora va el total  */
  $printer->setJustification(Printer::JUSTIFY_RIGHT);
  $printer->text("-----------------\n");
  $printer->text("TOTAL: S/.". number_format($obj->{'total'},2) ."\n\n");

  /*Pie de página*/
  $printer->setJustification(Printer::JUSTIFY_CENTER);
  $printer->text("Muchas gracias por su compra\n");

  /*Alimentamos el papel 3 veces*/
  $printer->feed(2);

  /*
      Cortamos el papel. Si nuestra impresora
      no tiene soporte para ello, no generará
      ningún error
  */
  $printer->cut();

  /*
      Por medio de la impresora mandamos un pulso.
      Esto es útil cuando la tenemos conectada
      por ejemplo a un cajón
  */
  $printer->pulse();

  /*
      Para imprimir realmente, tenemos que "cerrar"
      la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
  */
  $printer->close();

}catch(Exception $ex){
  echo "Couldn't print to this printer: " . $ex -> getMessage() . "\n";
}