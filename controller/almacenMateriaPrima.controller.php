<?php
date_default_timezone_set('America/Bogota');

class almacenMateriaPrimaController
{
  //datatable almacen productos prima
  public static function ctrDTableAlmacenProductosPrima()
  {
    $table = "almacen_mprima";
    $response = almacenMateriaPrimaModel::mdlDTableAlmacenProductosPrima($table);

    // Iterar sobre cada sub-array en $response
    foreach ($response as &$producto) {
      $updatePrecioUni = self::ctrPrecioUnitarioProducto($producto['idMprima']);
    }
    $stockAlmacenProducto = self::ctrStockAlmacenProductos($table);
    // Devolver el array modificado
    return $stockAlmacenProducto;
  }

  //funcion para obtener el precio unitario de un producto
  public static function ctrPrecioUnitarioProducto($idMprima)
  {
    $table = "materia_prima";
    $precioMprima = almacenMateriaPrimaModel::mdlPrecioUnitarioProducto($table, $idMprima);
    $updatePrecioUni = self::ctrUpdateUnitarioProducto($idMprima, $precioMprima);
    return $updatePrecioUni;
  }
  //actualizar precio unitario de un producto en el almacen prima
  public static function ctrUpdateUnitarioProducto($idMprima, $precioMprima)
  {
    $table = "almacen_mprima";
    $response = almacenMateriaPrimaModel::mdlUpdateUnitarioProducto($table, $idMprima, $precioMprima);
    return $response; //true or false
  }

  //funcion para obtener el stock total del almacen y calcular el total de cada producto
  public static function ctrStockAlmacenProductos($table)
  {
    $response = almacenMateriaPrimaModel::mdlDTableAlmacenProductosPrima($table);
    foreach ($response as &$producto) {
      // Calcular el total multiplicando cantidadProdAlma por precioUnit
      $total = $producto['cantidadMprimaAlma'] * $producto['precioUnit'];
      // Agregar el total como un nuevo dato en el sub-array
      $producto['totalMprimaAlma'] = $total;
    }
    return $response;
  }
}
