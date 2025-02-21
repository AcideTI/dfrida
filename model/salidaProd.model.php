<?php

require_once "conexion.php";

class salidaProdModel
{
  //datatable de ingresos productos
  public static function mdlmdlDTableSalProdcuctos($table)
  {
    $statement = Conexion::conn()->prepare("SELECT idSalProd,idPedido, nombreSalProd, fechaSalProd, totalSalProd, idCliente FROM $table ORDER BY idSalProd DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // //data table modal salidas almacen
  public static function mdlDTableSalProdcuctosAlmacen($table)
  {
    $statement = Conexion::conn()->prepare("
          SELECT 
              a.idProd, 
              a.nombreProdAlma, 
              a.codigoProdAlma, 
              a.precioProdAlma, 
              a.cantidadProdAlma, 
              p.precioProd 
          FROM 
              $table a
          INNER JOIN 
              producto p ON a.idProd = p.idProd
          WHERE 
              a.cantidadProdAlma > 0 
          ORDER BY 
              a.idAlmaProd DESC
      ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //datatable  ingresos en el modal de ingresos productos
  public static function mdlVerProductosSalidaModal($table, $codAllSalProd)
  {
    $statement = Conexion::conn()->prepare("SELECT salJsonProd FROM $table WHERE idSalProd = :idSalProd");
    $statement->bindParam(":idSalProd", $codAllSalProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //verificar datos de productos en almacen
  public static function mdlStockAlmacen($table, $codProd)
  {
    $statement = Conexion::conn()->prepare("SELECT cantidadProdAlma FROM $table WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $codProd, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['cantidadProdAlma'] > 0) {
      return $result;
    } else {
      return false;
    }
  }

  // El producto ya existe, se actualiza la cantidad
  public static function mdlRestarProductoAlmacenProd($table, $dataRestarProdAlamacen)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET  cantidadProdAlma = :cantidadProdAlma, DateUpdate = :DateUpdate  WHERE idProd = :idProd");
    $statement->bindParam(":cantidadProdAlma", $dataRestarProdAlamacen["cantidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":idProd", $dataRestarProdAlamacen["idProd"], PDO::PARAM_INT);
    $statement->bindParam(":DateUpdate", $dataRestarProdAlamacen["DateUpdate"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //ingreso de productos a almacen si ubo error al restar 
  public static function mdlRestaurarProductosAlmacenProd($table, $operacion)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET  cantidadProdAlma = :cantidadProdAlma, DateUpdate = :DateUpdate  WHERE idProd = :idProd");
    $statement->bindParam(":cantidadProdAlma", $operacion["cantidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":idProd", $operacion["idProd"], PDO::PARAM_INT);
    $statement->bindParam(":DateUpdate", $operacion["DateUpdate"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //crear el registro de ingreso de productos con id de Pedido
  public static function mdlCrearSalidaProd($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (nombreSalProd, idPedido, idCliente, fechaSalProd, igvSalProd, subTotalSalProd, totalSalProd, salJsonProd, DateCreate) VALUES(:nombreSalProd, :idPedido, :idCliente,:fechaSalProd, :igvSalProd, :subTotalSalProd, :totalSalProd, :salJsonProd, :DateCreate)");
    $statement->bindParam(":nombreSalProd", $dataCreate["nombreSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":idPedido", $dataCreate["idPedido"], PDO::PARAM_STR);
    $statement->bindParam(":idCliente", $dataCreate["idCliente"], PDO::PARAM_INT);
    $statement->bindParam(":fechaSalProd", $dataCreate["fechaSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":igvSalProd", $dataCreate["igvSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":subTotalSalProd", $dataCreate["subTotalSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":totalSalProd", $dataCreate["totalSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":salJsonProd", $dataCreate["salJsonProd"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
    //crear el registro de ingreso de productos con id cliente
    public static function mdlCrearSalidaProdCliente($table, $dataCreate)
    {
      $statement = Conexion::conn()->prepare("INSERT INTO $table (nombreSalProd, idCliente, fechaSalProd, igvSalProd, subTotalSalProd, totalSalProd, salJsonProd, DateCreate) VALUES(:nombreSalProd, :idCliente, :fechaSalProd, :igvSalProd, :subTotalSalProd, :totalSalProd, :salJsonProd, :DateCreate)");
      $statement->bindParam(":nombreSalProd", $dataCreate["nombreSalProd"], PDO::PARAM_STR);
      $statement->bindParam(":idCliente", $dataCreate["idCliente"], PDO::PARAM_INT);
      $statement->bindParam(":fechaSalProd", $dataCreate["fechaSalProd"], PDO::PARAM_STR);
      $statement->bindParam(":igvSalProd", $dataCreate["igvSalProd"], PDO::PARAM_STR);
      $statement->bindParam(":subTotalSalProd", $dataCreate["subTotalSalProd"], PDO::PARAM_STR);
      $statement->bindParam(":totalSalProd", $dataCreate["totalSalProd"], PDO::PARAM_STR);
      $statement->bindParam(":salJsonProd", $dataCreate["salJsonProd"], PDO::PARAM_STR);
      $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
      if ($statement->execute()) {
        return "ok";
      } else {
        return "error";
      }
    }

  //visualizar datos para editar salida productos
  public static function mdlVerDataSalidaRegistro($table, $codIdSalProd)
  {
    $statement = Conexion::conn()->prepare("SELECT
     idSalProd,
     nombreSalProd,
     idPedido,
     fechaSalProd,
     igvSalProd,
     subTotalSalProd,
     totalSalProd,
     salJsonProd
     FROM $table WHERE idSalProd = :idSalProd");
    $statement->bindParam(":idSalProd", $codIdSalProd, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //obtener stock de almacen para visualizar datos para editar salidas productos
  public static function mdlStockAlmacenEdit($table, $codIngProd)
  {
    $statement = Conexion::conn()->prepare("
          SELECT 
              a.cantidadProdAlma, 
              p.precioProd 
          FROM 
              $table a
          INNER JOIN 
              producto p ON a.idProd = p.idProd
          WHERE 
              a.idProd = :idProd
      ");
    $statement->bindParam(":idProd", $codIngProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //editar registro salida de productos
  public static function mdlEditarSalidaProd($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET nombreSalProd = :nombreSalProd, idPedido = :idPedido, fechaSalProd = :fechaSalProd, igvSalProd = :igvSalProd, subTotalSalProd = :subTotalSalProd, totalSalProd = :totalSalProd, salJsonProd = :salJsonProd, DateUpdate = :DateUpdate WHERE idSalProd = :idSalProd");
    $statement->bindParam(":nombreSalProd", $dataUpdate["nombreSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":idPedido", $dataUpdate["idPedido"], PDO::PARAM_STR);
    $statement->bindParam(":fechaSalProd", $dataUpdate["fechaSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":igvSalProd", $dataUpdate["igvSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":subTotalSalProd", $dataUpdate["subTotalSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":totalSalProd", $dataUpdate["totalSalProd"], PDO::PARAM_STR);
    $statement->bindParam(":salJsonProd", $dataUpdate["salJsonProd"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":idSalProd", $dataUpdate["idSalProd"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }


  //eliminar productos salida**

  //obtener el registro de productos salida
  public static function mdlRecuperarProductosRegSalida($table, $codSalProd)
  {
    $statement = Conexion::conn()->prepare("SELECT salJsonProd FROM $table WHERE idSalProd = :idSalProd");
    $statement->bindParam(":idSalProd", $codSalProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  // obtener el idPedido del la salida de productos
  public static function mdlValidarPedidoAsignado($table, $codSalProd)
  {
    $statement = Conexion::conn()->prepare("SELECT idPedido FROM $table WHERE idSalProd = :idSalProd");
    $statement->bindParam(":idSalProd", $codSalProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //verificar datos de productos en almacen
  public static function mdlStockAlmacenSalida($table, $codProd)
  {
    $statement = Conexion::conn()->prepare("SELECT cantidadProdAlma FROM $table WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $codProd, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //actualizar productos en almacen
  public static function mdlActualizarProductosIngresados($table, $dataUpdateProdAlmacen)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET cantidadProdAlma = :cantidadProdAlma, DateUpdate = :DateUpdate WHERE idProd = :idProd");
    $statement->bindParam(":cantidadProdAlma", $dataUpdateProdAlmacen["cantidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdateProdAlmacen["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":idProd", $dataUpdateProdAlmacen["idProd"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //borrar salida productos
  public static function mdlBorrarRegistroIngresProducto($table, $codSalProd)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE idSalProd = $codSalProd");
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //fin eliminar productos ingresados**

  //Agregar Producto de almacen ala salida
  public static function mdlAgregarSalProducto($table, $codSalProducto)
  {
    $statement = Conexion::conn()->prepare("
          SELECT 
              a.idProd, 
              a.nombreProdAlma, 
              a.codigoProdAlma, 
              a.unidadProdAlma, 
              a.precioProdAlma, 
              a.cantidadProdAlma, 
              p.precioProd 
          FROM 
              $table a
          INNER JOIN 
              producto p ON a.idProd = p.idProd
          WHERE 
              a.idProd = :idProd
      ");
    $statement->bindParam(":idProd", $codSalProducto, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //Agregar Producto Mprima a la cotizacion
  public static function AgregarProductoMprimaCoti($table, $codProductoMprimaCoti)
  {
    $statement = Conexion::conn()->prepare("SELECT idMprima, nombreMprima, unidadMprima, precioMprima FROM $table WHERE idMprima = :idMprima");
    $statement->bindParam(":idMprima", $codProductoMprimaCoti, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Descargar PDF de la cotizacion
  public static function mdlDescargarPdfCotizacion($table, $codCoti)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tituloCoti, 
    fechaCoti, 
    razonSocialCoti, 
    nombreComercialCoti, 
    rucCoti, 
    nombreCoti, 
    celularCoti, 
    correoCoti, 
    direccionCoti, 
    detalleCoti, 
    productsCoti, 
    productsMprimaCoti, 
    totalProductsCoti, 
    totalProductsMprimaCoti, 
    igvCoti, 
    subTotalCoti, 
    totalCoti 
    FROM $table WHERE idCoti = :idCoti");
    $statement->bindParam(":idCoti", $codCoti, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //cambiar estao de la cotizacion al descargar
  public static function mdlEstadoDescargaPdfCotizacion($table, $codCoti)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET estadoCoti = '2' WHERE idCoti = :idCoti");
    $statement->bindParam(":idCoti", $codCoti, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Descargar excel datos de salida de productos por fecha
  public static function  mdlObtenerDatosSalidaProductosporFecha($tabla, $fechaInicio,$fechaFin){
    $statement = Conexion::conn()->prepare("SELECT salida_prod.idSalProd, salida_prod.idPedido, salida_prod.nombreSalProd, salida_prod.fechaSalProd, salida_prod.igvSalProd, salida_prod.subTotalSalProd, salida_prod.totalSalProd, salida_prod.salJsonProd FROM $tabla WHERE salida_prod.fechaSalProd BETWEEN :fechaInicio AND :fechaFin");
    $statement->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $statement->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Descargar PDF de salida de Productos
  public static function mdlDescargarPdfSalida($table, $codSalidaProductoPdf)
  {
    $statement = Conexion::conn()->prepare("SELECT salida_prod.nombreSalProd,  salida_prod.fechaSalProd,  salida_prod.igvSalProd, salida_prod.subTotalSalProd, salida_prod.totalSalProd, salida_prod.salJsonProd, cliente.RazonSocialCli, cliente.rucCli, cliente.nombreCli, cliente.correoCli,  cliente.celularCli, cliente.direccionCli FROM $table INNER JOIN cliente ON  salida_prod.idCliente = cliente.idCli WHERE salida_prod.idSalProd = :idSalProd");
    $statement->bindParam(":idSalProd", $codSalidaProductoPdf, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  // Obtener el idCliente del pedido
  public static function mdlObtenerIdClientePedido($table, $codPedido)
  {
    $statement = Conexion::conn()->prepare("SELECT idCli FROM $table WHERE idPedido = :idPedido");
    $statement->bindParam(":idPedido", $codPedido, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
