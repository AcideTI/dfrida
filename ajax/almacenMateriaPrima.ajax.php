<?php
require_once "../controller/almacenMateriaPrima.controller.php";
require_once "../model/almacenMateriaPrima.model.php";
//require_once "../functions/almacenMateriaPrima.functions.php";
//inicio de secion 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//funciones para escuchar entrada de datos desde $.ajax de jquery

//datatable almacen productos
if (isset($_POST["todosLosProductosAlmacenMprima"])) {
  $todosLosProductosAlmacenMprima = new AlmacenProductosPrimaAjax();
  $todosLosProductosAlmacenMprima->ajaxDTableAlmacenProductosPrima();
}

/////////////////////////////

class AlmacenProductosPrimaAjax
{
  //datatable almacen productos
  public function ajaxDTableAlmacenProductosPrima()
  {
    $todosLosProductosAlmacenMprima = almacenMateriaPrimaController::ctrDTableAlmacenProductosPrima();
    foreach ($todosLosProductosAlmacenMprima as &$almacen) {
      // Realiza la multiplicación normalmente
      // Si cantidadMprimaAlma es negativo, asegura que el totalProdAlmaMprima también lo sea
      if ($almacen["cantidadMprimaAlma"] < 0) {
        $almacen['totalMprimaAlma'] = -abs($almacen['totalMprimaAlma']);
      }
    }
    unset($almacen); // 
  
    echo json_encode($todosLosProductosAlmacenMprima);
  }

}

