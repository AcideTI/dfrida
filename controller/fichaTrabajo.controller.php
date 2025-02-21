<?php
date_default_timezone_set('America/Bogota');

class FichaTrabajoController
{
  // Mostrar todos los productos
  public static function ctrDTableFrichasTrabajo()
  {
    $table = "ficha_proceso";
    $response = FichaTrabajoModel::mdlDTableFrichasTrabajo($table);
    return $response;
  }

  //visualizar procesos en el modal de procesos trabajo
  public static function ctrVerProcesosTrabajo($codFichTrab)
  {
    $table = "ficha_proceso";
    $response = FichaTrabajoModel::mdlVerProcesosTrabajo($table, $codFichTrab);
    return $response;
  }

  //  crear ficha Trabajo
  public static function ctrCrearFichaTrabajo($CrearProcesoTrabajo, $jsonProcesosTrabajo)
  {
    // Eliminar datos innecesarios
    $procesoTrabajoData = self::ctrBorrarDatosInecesarios($CrearProcesoTrabajo);
    // Eliminar el array $CrearProcesoTrabajo para no duplicar datos
    unset($CrearProcesoTrabajo);

    $table = "ficha_proceso";
    $dataCreate = array(
      "tituloFichaProc" => $procesoTrabajoData["tituloProcesAdd"],
      "productoFichaProc" => $procesoTrabajoData["productoFichaProcAdd"],
      "detalleFichaProc" => $procesoTrabajoData["detalleFichaProcAdd"],
      "procesoFichaProcJson" => $jsonProcesosTrabajo,
      "DateCreate" => date("Y-m-d\TH:i:sP"),
    );
    $response = FichaTrabajoModel::mdCrearFichaTrabajo($table, $dataCreate);

    return $response;
  }

  //eliminar datos inecesarios
  public static function ctrBorrarDatosInecesarios($CrearProcesoTrabajo)
  {
    unset($CrearProcesoTrabajo["procesosAdd"]);
    unset($CrearProcesoTrabajo["tiempoAdd"]);
    unset($CrearProcesoTrabajo["observacionAdd"]);
    $response = $CrearProcesoTrabajo;
    return $response;
  }
  //visualizar datos para editar ficha trabajo
  public static function ctrVerDataFichaTrabajo($codFichTrabView)
  {
    $codFichTrab = $codFichTrabView;
    $table = "ficha_proceso";
    $response = FichaTrabajoModel::mdlVerDataFichaTrabajo($table, $codFichTrab);
    return $response;
  }

  // Editar ficha Trabajo
  public static function ctrEditFichaTrabajo($editarProcesoTrabajo, $jsonProcesosTrabajoEdit)
  {
    // Eliminar datos innecesarios
    $procesoTrabajoData = self::ctrBorrarDatosInecesariosEdit($editarProcesoTrabajo);
    // Eliminar el array $crearCotizacion para no duplicar datos
    unset($editarProcesoTrabajo);

    $table = "ficha_proceso";
    $dataCreate = array(
      "idFichaProc" => $procesoTrabajoData["codFichTrab"],
      "tituloFichaProc" => $procesoTrabajoData["tituloProcesEdit"],
      "productoFichaProc" => $procesoTrabajoData["productoFichaProcEdit"],
      "detalleFichaProc" => $procesoTrabajoData["detalleFichaProcEdit"],
      "procesoFichaProcJson" => $jsonProcesosTrabajoEdit,
      "DateCreate" => date("Y-m-d\TH:i:sP"),
    );
    $response = FichaTrabajoModel::mdlEditFichaTrabajo($table, $dataCreate);

    return $response;
  }
  //verificar si el nombre de Producto existe
  public static function ctrBorrarDatosInecesariosEdit($editarProcesoTrabajo)
  {
    unset($editarProcesoTrabajo["procesosAdd"]);
    unset($editarProcesoTrabajo["tiempoAdd"]);
    unset($editarProcesoTrabajo["observacionAdd"]);
    $response = $editarProcesoTrabajo;
    return $response;
  }

  //eliminar ficha trabajo
  public static function ctrDeleteFichaTrabajo($borrarFichaTrabajo)
  {
    $codFichTrab = $borrarFichaTrabajo["codFichTrab"];
    $table = "ficha_proceso";
    $response = FichaTrabajoModel::mdlDeleteFichaTrabajo($table, $codFichTrab);

    return $response;
  }
  //select2 para productos
  public static function ctrCateSelect2ProductoTrab()
  {
    $table = "producto";
    $response = FichaTrabajoModel::mdlCateSelect2ProductoTrab($table);
    return $response;
  }


}
