<?php
require_once "../controller/cotizacion.controller.php";
require_once "../model/cotizacion.model.php";
//require_once "../functions/cotizacion.functions.php";
//inicio de secion 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//funciones para escuchar entrada de datos desde $.ajax de jquery
//datatable de ProductosMprima
if (isset($_POST["todosLosProductosMprima"])) {
  $todosLosProductosMprima = new CotizacionAjax();
  $todosLosProductosMprima->ajaxDTableProductosMprima();
}
//  crear ProductosMprima
if (isset($_POST["jsonCrearProductosMprima"])) {
  $create = new CotizacionAjax();
  $create->jsonCrearProductosMprima = $_POST["jsonCrearProductosMprima"];
  $create->ajaxCrearProductoMprima($_POST["jsonCrearProductosMprima"]);
}
//  visualizar datos ProductosMprima
if (isset($_POST["codProMp"])) {
  $view = new CotizacionAjax();
  $view->codProMp = $_POST["codProMp"];
  $view->ajaxViewProductoMprima($_POST["codProMp"]);
}
//editar ProductosMprima
if (isset($_POST["jsonEditarProductosMprima"])) {
  $edit = new CotizacionAjax();
  $edit->jsonEditarProductosMprima = $_POST["jsonEditarProductosMprima"];
  $edit->ajaxEditarProductosMprima($_POST["jsonEditarProductosMprima"]);
}
//borrar ProductosMprima
if (isset($_POST["jsonBorraProductoMprima"])) {
  $delete = new CotizacionAjax();
  $delete->jsonBorraProductoMprima = $_POST["jsonBorraProductoMprima"];
  $delete->ajaxBorrarProductoMprima($_POST["jsonBorraProductoMprima"]);
}
//Agregar Producto a la cotizacion
if (isset($_POST["codAddProdModalCoti"])) {
  $add = new CotizacionAjax();
  $add->codAddProdModalCoti = $_POST["codAddProdModalCoti"];
  $add->ajaxAgregarProductoCoti($_POST["codAddProdModalCoti"]);
}
//Agregar Producto a la cotizacion
if (isset($_POST["codAddProdMprimaModalCoti"])) {
  $add = new CotizacionAjax();
  $add->codAddProdMprimaModalCoti = $_POST["codAddProdMprimaModalCoti"];
  $add->ajaxAgregarProductoMprimaCoti($_POST["codAddProdMprimaModalCoti"]);
}
/////////////////////////////

class CotizacionAjax
{
  //datatable de ProductosMprima
  public function ajaxDTableProductosMprima()
  {
    $todosLosProductosPrima = CotizacionController::ctrDTableProductosMprima();
    foreach ($todosLosProductosPrima as &$productoMprima) {
      $productoMprima['buttons'] = FunctionProductoMprima::getBtnProductosMprima($productoMprima["idMprima"]);
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
    $response = CotizacionController::ctrCrearProductoMprima($crearProductoMprima);
    echo json_encode($response);
  }
  //  visualizar datos ProductosMprima
  public function ajaxViewProductoMprima($codProMp)
  {
    $codProductoMp = json_decode($codProMp, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = CotizacionController::ctrViewProductoMprima($codProductoMp);
    echo json_encode($response);
  }

  //  editar ProductosMprima
  public function ajaxEditarProductosMprima($jsonEditarProductosMprima)
  {
    $editarProductosMprima = json_decode($jsonEditarProductosMprima, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = CotizacionController::ctrEditProductMprima($editarProductosMprima);
    echo json_encode($response);
  }
  //borrar ProductosMprima
  public function ajaxBorrarProductoMprima($jsonBorraProductoMprima)
  {
    $borrarProductoMprima = json_decode($jsonBorraProductoMprima, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = CotizacionController::ctrDeleteProductMprima($borrarProductoMprima);
    echo json_encode($response);
  }

 //Agregar Producto a la cotizacion
  public function ajaxAgregarProductoCoti($codAddProdModalCoti)
  {
    $codProductoCoti = json_decode($codAddProdModalCoti, true); // Decodificar la cadena de texto JSON en un array asociativo
    $response = CotizacionController::ctrAgregarProductoCoti($codProductoCoti);
    echo json_encode($response);
  }
   //Agregar Producto Mprima a la cotizacion
   public function ajaxAgregarProductoMprimaCoti($codAddProdMprimaModalCoti)
   {
     $codProductoMprimaCoti = json_decode($codAddProdMprimaModalCoti, true); // Decodificar la cadena de texto JSON en un array asociativo
     $response = CotizacionController::ctrAgregarProductoMprimaCoti($codProductoMprimaCoti);
     echo json_encode($response);
   }

}

