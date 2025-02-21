<?php
require_once "../controller/productMprima.controller.php";
require_once "../model/productMprima.model.php";
require_once "../functions/productoMprima.functions.php";
//inicio de secion 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//funciones para escuchar entrada de datos desde $.ajax de jquery
//datatable de ProductosMprima
if (isset($_POST["todosLosProductosMprima"])) {
  $todosLosProductosMprima = new ProductMprimaAjax();
  $todosLosProductosMprima->ajaxDTableProductosMprima();
}
//  crear ProductosMprima
if (isset($_POST["jsonCrearProductosMprima"])) {
  $create = new ProductMprimaAjax();
  $create->jsonCrearProductosMprima = $_POST["jsonCrearProductosMprima"];
  $create->ajaxCrearProductoMprima($_POST["jsonCrearProductosMprima"]);
}
//  visualizar datos ProductosMprima
if (isset($_POST["codProMp"])) {
  $view = new ProductMprimaAjax();
  $view->codProMp = $_POST["codProMp"];
  $view->ajaxViewProductoMprima($_POST["codProMp"]);
}
//editar ProductosMprima
if (isset($_POST["jsonEditarProductosMprima"])) {
  $edit = new ProductMprimaAjax();
  $edit->jsonEditarProductosMprima = $_POST["jsonEditarProductosMprima"];
  $edit->ajaxEditarProductosMprima($_POST["jsonEditarProductosMprima"]);
}
//borrar ProductosMprima
if (isset($_POST["jsonBorraProductoMprima"])) {
  $delete = new ProductMprimaAjax();
  $delete->jsonBorraProductoMprima = $_POST["jsonBorraProductoMprima"];
  $delete->ajaxBorrarProductoMprima($_POST["jsonBorraProductoMprima"]);
}
// Obtener productos prima de una cotización para la vista pedidos
if (isset($_POST["codPedProductosMateriaPrimaPedidos"]) && isset($_POST["idSalMprimaProductosMateriaPrimaPedidos"])) {
  $productosMateriaPrimaPedido = new ProductMprimaAjax();
  $productosMateriaPrimaPedido->codPedProductosMateriaPrimaPedidos = $_POST["codPedProductosMateriaPrimaPedidos"];
  $productosMateriaPrimaPedido->idSalMprimaProductosMateriaPrimaPedidos = $_POST["idSalMprimaProductosMateriaPrimaPedidos"];
  $productosMateriaPrimaPedido->ajaxObtenerProductosPrimaCotizacionPedidos();
}
/////////////////////////////

class ProductMprimaAjax
{
  //datatable de ProductosMprima
  public function ajaxDTableProductosMprima()
  {
    $todosLosProductosPrima = ProductMprimaController::ctrDTableProductosMprima();
    foreach ($todosLosProductosPrima as &$productoMprima) {
      $productoMprima['buttons'] = FunctionProductoMprima::getBtnProductosMprima($productoMprima["idMprima"]);
      $productoMprima['nombreProv'] = FunctionProductoMprima::getNombreProvedor($productoMprima["nombreProv"]);
    }
    //mostar todos los ProductosMprima DataTable
    echo json_encode($todosLosProductosPrima);
  }

  //  crear ProductosMprima
  public function ajaxCrearProductoMprima($jsonCrearProductosMprima)
  {
    $crearProductoMprima = json_decode($jsonCrearProductosMprima, true); // Decodificar la cadena de texto JSON en un array asociativo
    $valoresVacios = 0;
    foreach ($crearProductoMprima as $valor) {
      if (empty($valor)) {
        $valoresVacios++;
      }
    }
    if ($valoresVacios > 2) {
      echo json_encode("error");
      return;
    }
    $response = ProductMprimaController::ctrCrearProductoMprima($crearProductoMprima);
    echo json_encode($response);
  }
  //  visualizar datos ProductosMprima
  public function ajaxViewProductoMprima($codProMp)
  {
    $codProductoMp = json_decode($codProMp, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = ProductMprimaController::ctrViewProductoMprima($codProductoMp);
    echo json_encode($response);
  }

  //  editar ProductosMprima
  public function ajaxEditarProductosMprima($jsonEditarProductosMprima)
  {
    $editarProductosMprima = json_decode($jsonEditarProductosMprima, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = ProductMprimaController::ctrEditProductMprima($editarProductosMprima);
    echo json_encode($response);
  }
  //borrar ProductosMprima
  public function ajaxBorrarProductoMprima($jsonBorraProductoMprima)
  {
    $borrarProductoMprima = json_decode($jsonBorraProductoMprima, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = ProductMprimaController::ctrDeleteProductMprima($borrarProductoMprima);
    echo json_encode($response);
  }
  // Obtener productos prima de una cotización para la vista pedidos
  public $codPedProductosMateriaPrimaPedidos;
  public $idSalMprimaProductosMateriaPrimaPedidos;
  public function ajaxObtenerProductosPrimaCotizacionPedidos()
  {
    $codPed = $this->codPedProductosMateriaPrimaPedidos;
    $idSalMprima = $this->idSalMprimaProductosMateriaPrimaPedidos;
    $response = ProductMprimaController::ctrObtenerProductosPrimaCotizacionPedidos($codPed, $idSalMprima);
    // Verificar si $response contiene el campo 'productsCoti'
    if (isset($response['salJsonMprima'])) {
      // Decodificar el JSON contenido en 'productsCoti'
      $productos = json_decode($response['salJsonMprima'], true);

      // Verificar si la decodificación fue exitosa
      if (is_array($productos)) {
        // Crear un array para almacenar los productos trabajados
        $productosMateriaPrimaTrabajados = [];

        // Recorrer los productos y extraer la información necesaria
        foreach ($productos as $key => $producto) {
          $productosMateriaPrimaTrabajados[] = [
            'codProdMprimaCoti' => $producto['codProdIng'],
            'nombreProdMprimaCoti' => $producto['nombreProdIng'],
            'unidadProdMprimaCoti' => $producto['unidadProdIng'],
            'cantidadProdMprimaCoti' => $producto['cantidadProdIng'],
            'precioProdMprimaCoti' => $producto['precioProdIng']
          ];
        }

        // Devolver el JSON trabajado
        echo json_encode($productosMateriaPrimaTrabajados);
      } else {
        // Manejar el caso en que la decodificación falle
        echo json_encode(['error' => 'Invalid JSON format in productsCoti']);
      }
    } else {
      // Manejar el caso en que 'productsCoti' no esté presente
      echo json_encode(['error' => 'productsCoti field not found']);
    }
  }
}
