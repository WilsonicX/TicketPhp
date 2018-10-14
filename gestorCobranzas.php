<?php
/*Aqui retornamos los datos para la impresion*/
$data = array(
  "razonSocial" => "Mi Polleria J & B",
  "ruc" => "10239658120",
  "direccion" => "Castilla-Piura",
  "telefono" => "963252124",
  "email" => "correo@example.com"
);

$data['serie'] = "B001";
$data['numero'] = "23";
$data['fecha'] = "14/10/2018";

/*Este codigo es para el detalle de la nota de venta
lo hice para uno pero debes de adaptarlo a tus necesidades segun el codigo de abajo que esta comentado
*/
$dataProductos = array();
$dataItem = array(
  "cantidad" => "12",
  "producto" => "Hamburguesas",
  "precioUnitario" => "4.20",
  "costoTotal" => "50.40",
);
array_push($dataProductos, $dataItem);

/*$sentenciaProductos = Conexion::conectar()->prepare("SELECT dp.cantidad, prd.nombre_producto, dp.precio_unitario, ROUND(dp.cantidad*dp.precio_unitario,2) AS total FROM 
rest_detalle_pedido dp INNER JOIN rest_pedido p ON p.codigo_pedido = dp.codigo_pedido INNER JOIN rest_producto prd ON prd.codigo_producto= dp.codigo_producto WHERE p.codigo_pedido =:codigoPedido");
$sentenciaProductos->bindParam(":codigoPedido", $resultado[3]);
$sentenciaProductos->execute();
$lista = $sentenciaProductos->fetchAll();
$dataProductos = array();
$total = 0;
foreach ($lista as $fila => $item){
  $dataItem = array(
    "cantidad" => $item['cantidad'],
    "producto" => $item['nombre_producto'],
    "precioUnitario" => $item['precio_unitario'],
    "costoTotal" => $item['total'],
  );
  array_push($dataProductos, $dataItem);
  $total+=$item['total'];
}*/
$data['detalle'] = $dataProductos;
$data['total'] = "50.40";
//data['total'] = $total;

echo json_encode($data,
JSON_HEX_AMP  |
 JSON_HEX_APOS |
 JSON_HEX_QUOT
);
/*Fin Aqui retornamos los datos para la impresion*/