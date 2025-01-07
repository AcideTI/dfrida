<?php
date_default_timezone_set('America/Bogota');

class almacenProductosController
{
  //datatable almacen productos
  public static function ctrDTableAlmacenProductos()
  {
    $table = "almacen_prod";
    // Obtener los datos de la base de datos
    $response = almacenProductosModel::mdlDTableAlmacenProductos($table);

    // Iterar sobre cada sub-array en $response
    foreach ($response as &$producto) {
      $updatePrecioUni = self::ctrPrecioUnitarioProducto($producto['idProd']);
    }
    $stockAlmacenProducto = self::ctrStockAlmacenProductos($table);
    // Devolver el array modificado
    return $stockAlmacenProducto;
  }

  //funcion para obtener el precio unitario de un producto
  public static function ctrPrecioUnitarioProducto($idProd)
  {
    $table = "producto";
    $precioProd = almacenProductosModel::mdlPrecioUnitarioProducto($table, $idProd);
    $updatePrecioUni = self::ctrUpdateUnitarioProducto($idProd, $precioProd);
    return $updatePrecioUni;
  }
  //actualizar precio unitario de un producto en el almacen
  public static function ctrUpdateUnitarioProducto($idProd, $precioProd)
  {
    $table = "almacen_prod";
    $response = almacenProductosModel::mdlUpdateUnitarioProducto($table, $idProd, $precioProd);
    return $response; //true or false
  }

  //funcion para obtener el stock total del almacen y calcular el total de cada producto
  public static function ctrStockAlmacenProductos($table)
  {
    $response = almacenProductosModel::mdlDTableAlmacenProductos($table);
    foreach ($response as &$producto) {
      // Calcular el total multiplicando cantidadProdAlma por precioUnit
      $total = $producto['cantidadProdAlma'] * $producto['precioUnit'];
      // Agregar el total como un nuevo dato en el sub-array
      $producto['totalProdAlma'] = $total;
    }
    return $response;
  }
}
