<?php
date_default_timezone_set('America/Bogota');

class CotizacionController
{
  // Mostrar todos los productos
  public static function ctrDTableProductos()
  {
    $table = "producto";
    $response = CotizacionModel::mdlDTableProductos($table);
    return $response;
  }

  // Mostrar todas las categorías de productos
  public static function ctrGetAllCategories()
  {
    $table = "categoria_prod";
    $response = CotizacionModel::mdlGetAllCategories($table);
    return $response;
  }

  // Crear nuevo producto
  public static function ctrCrearProducto($crearProducto)
  {
    // Verificar si el nombre de ProductosMprima existe
    // La respuesta será true para existencia y false para no existencia
    $existNomProd = self::ctrExistenciaDeProductoNombre($crearProducto["productName"]);
    // Verificar si el código de ProductosMprima existe
    // La respuesta será true para existencia y false para no existencia
    $existCodProd = self::ctrExistenciaDeCodigoProducto($crearProducto["productCodigo"]);
    if ($existNomProd) {
      $response = "errorNom";
    } elseif ($existCodProd) {
      $response = "errorCod";
    } else {
      $table = "producto";
      $dataCreate = array(
        "idCatPro" => $crearProducto["productCategory"],
        "nombreProd" => $crearProducto["productName"],
        "codigoProd" => $crearProducto["productCodigo"],
        "detalleProd" => $crearProducto["productDetail"],
        "unidadProd" => $crearProducto["productUnit"],
        "precioProd" => $crearProducto["productPrice"],
        "DateCreate" => date("Y-m-d\TH:i:sP"),
      );
      $response = CotizacionModel::CrearProducto($table, $dataCreate);
    }
    return $response;
  }
  //verificar si el nombre de Producto existe
  public static function ctrExistenciaDeProductoNombre($productName)
  {
    $table = "producto";
    //la respues sera true para existencia y false para no existencia
    $response = CotizacionModel::mdlExistenciaDeProductoNombre($table, $productName);
    return $response;
  }
  //verificar si el codigo de Producto existe
  public static function ctrExistenciaDeCodigoProducto($productCodigo)
  {
    $table = "producto";
    //la respues sera true para existencia y false para no existencia
    $response = CotizacionModel::mdlExistenciaDeCodigoProducto($table, $productCodigo);
    return $response;
  }

  //  visualizar datos Producto
  public static function ctrViewProducto($codProduct)
  {
    $table = 'producto';
    $productData = CotizacionModel::mdlViewProducto($table, $codProduct);
    return $productData;
  }

  // Editar un producto específico
  public static function ctrEditProduct($editarProducto)
  {
    if (isset($editarProducto['editProductName']) && isset($editarProducto['editProductCategory'])) {
      $table = 'producto';
      $dataUpdate = array(
        'idProd' => $editarProducto['codProduct'],
        'idCatPro' => $editarProducto['editProductCategory'],
        'nombreProd' => $editarProducto['editProductName'],
        "codigoProd" => $editarProducto["editProductCodigo"],
        'detalleProd' => $editarProducto['editProductDetail'],
        'unidadProd' => $editarProducto['editProductUnit'],
        'precioProd' => $editarProducto['editProductPrice'],
        'DateUpdate' => date("Y-m-d\TH:i:sP"),
      );

      $response = CotizacionModel::mdlEditProduct($table, $dataUpdate);
      return $response;
    }
  }
  // Eliminar un producto
  public static function ctrDeleteProduct($borrarProducto)
  {
    $codProduct = $borrarProducto["codPro"];
    // Verificar si el producto está en almacén
    $almacen = self::ctrAlamacenProductStock($codProduct);
    if (!empty($almacen) && $almacen["cantidadProd"] > 0) {
      $response = "error";
    } else {
      $table = "producto";
      $response = CotizacionModel::mdlDeleteProduct($table, $codProduct);
    }
    return $response;
  }
  //verificar si el producto esta en alamacen
  public static function ctrAlamacenProductStock($codProduct)
  {
    $table = "almacen_prod";
    $response = CotizacionModel::mdlAlamacenProductStock($table, $codProduct);
    return $response;
  }
  //Agregar Producto a la cotizacion
  public static function ctrAgregarProductoCoti($codProductoCoti)
  {
    $table = 'producto';
    $response = CotizacionModel::AgregarProductoCoti($table, $codProductoCoti);
    return $response;
  }

  //Agregar Producto Mprima a la cotizacion
  public static function ctrAgregarProductoMprimaCoti($codProductoMprimaCoti)
  {
    $table = 'materia_prima';
    $response = CotizacionModel::AgregarProductoMprimaCoti($table, $codProductoMprimaCoti);
    return $response;
  }

}
