<?php

require_once "conexion.php";

class ingresoProdModel
{
  //datatable de ingresos productos
  public static function mdlDTableIngProdcuctos($table)
  {
    $statement = Conexion::conn()->prepare("SELECT idIngProd, nombreIngProd, fechaIngProd, totalIngProd FROM $table ORDER BY idIngProd DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //datatable  ingresos en el modal de ingresos productos
  public static function mdlVerProductosIngresadosModal($table, $codAllIngProd)
  {
    $statement = Conexion::conn()->prepare("SELECT ingJsonProd FROM $table WHERE idIngProd = :idIngProd");
    $statement->bindParam(":idIngProd", $codAllIngProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //verificar datos de productos en almacen
  public static function mdlStockAlmacen($table, $codProd)
  {
    $statement = Conexion::conn()->prepare("SELECT cantidadProdAlma FROM $table WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $codProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  // El producto ya existe, se actualiza la cantidad
  public static function mdlSumarProductoAlmacenProd($table, $dataSumarProdAlamacen)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET codigoProdAlma = :codigoProdAlma, nombreProdAlma = :nombreProdAlma, unidadProdAlma = :unidadProdAlma, cantidadProdAlma = :cantidadProdAlma, DateUpdate = :DateUpdate  WHERE idProd = :idProd");
    $statement->bindParam(":codigoProdAlma", $dataSumarProdAlamacen["codigoProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":nombreProdAlma", $dataSumarProdAlamacen["nombreProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":unidadProdAlma", $dataSumarProdAlamacen["unidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadProdAlma", $dataSumarProdAlamacen["cantidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":idProd", $dataSumarProdAlamacen["idProd"], PDO::PARAM_INT);
    $statement->bindParam(":DateUpdate", $dataSumarProdAlamacen["DateUpdate"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }
  //ingreso de productos a almacen
  public static function mdlIngresarProductosAlmacenProd($table, $dataIngAlamacen)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (idProd, codigoProdAlma, nombreProdAlma, unidadProdAlma, cantidadProdAlma, precioProdAlma, DateCreate) VALUES (:idProd, :codigoProdAlma, :nombreProdAlma, :unidadProdAlma, :cantidadProdAlma, :precioProdAlma, :DateCreate)");
    $statement->bindParam(":idProd", $dataIngAlamacen["idProd"], PDO::PARAM_INT);
    $statement->bindParam(":codigoProdAlma", $dataIngAlamacen["codigoProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":nombreProdAlma", $dataIngAlamacen["nombreProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":unidadProdAlma", $dataIngAlamacen["unidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadProdAlma", $dataIngAlamacen["cantidadProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":precioProdAlma", $dataIngAlamacen["precioProdAlma"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataIngAlamacen["DateCreate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //crear el registro de ingreso de productos
  public static function mdlCrearIngresoProd($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (nombreIngProd, fechaIngProd, igvIngProd, subTotalIngProd, totalIngProd, ingJsonProd, DateCreate) VALUES(:nombreIngProd, :fechaIngProd, :igvIngProd, :subTotalIngProd, :totalIngProd, :ingJsonProd, :DateCreate)");
    $statement->bindParam(":nombreIngProd", $dataCreate["nombreIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":fechaIngProd", $dataCreate["fechaIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":igvIngProd", $dataCreate["igvIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":subTotalIngProd", $dataCreate["subTotalIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":totalIngProd", $dataCreate["totalIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":ingJsonProd", $dataCreate["ingJsonProd"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //visualizar datos para editar ingreso productos
  public static function mdlVerDataFichaTrabajo($table, $codIdIngProd)
  {
    $statement = Conexion::conn()->prepare("SELECT
     idIngProd,
     nombreIngProd,
     fechaIngProd, 
     igvIngProd,
     subTotalIngProd,
     totalIngProd,
     ingJsonProd
     FROM $table WHERE idIngProd = :idIngProd");
    $statement->bindParam(":idIngProd", $codIdIngProd, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //obtener precio para editar ingreso productos
  public static function mdlPrecioProdEdit($table, $codIngProd)
  {
    $statement = Conexion::conn()->prepare("SELECT precioProd FROM $table WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $codIngProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //editar registro ingreso de productos
  public static function mdlEditarIngresoProd($table, $dataEdit)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET nombreIngProd = :nombreIngProd, fechaIngProd = :fechaIngProd, igvIngProd = :igvIngProd, subTotalIngProd = :subTotalIngProd, totalIngProd = :totalIngProd, ingJsonProd = :ingJsonProd, DateUpdate = :DateUpdate WHERE idIngProd = :idIngProd");
    $statement->bindParam(":nombreIngProd", $dataEdit["nombreIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":fechaIngProd", $dataEdit["fechaIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":igvIngProd", $dataEdit["igvIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":subTotalIngProd", $dataEdit["subTotalIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":totalIngProd", $dataEdit["totalIngProd"], PDO::PARAM_STR);
    $statement->bindParam(":ingJsonProd", $dataEdit["ingJsonProd"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataEdit["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":idIngProd", $dataEdit["idIngProd"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }


  //eliminar productos ingresados**

  //obtener el registro de productos ingresados
  public static function mdlRecuperarProductosIngresados($table, $codIngProd)
  {
    $statement = Conexion::conn()->prepare("SELECT ingJsonProd FROM $table WHERE idIngProd = :idIngProd");
    $statement->bindParam(":idIngProd", $codIngProd, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
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

  //  Borrar ingreso productos
  public static function mdlBorrarRegistroIngresProducto($table, $codIngProd)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE idIngProd = $codIngProd");
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //fin eliminar productos ingresados**

  //Agregar Producto al ingreso
  public static function mdlAgregarIngProducto($table, $codIngProducto)
  {
    $statement = Conexion::conn()->prepare("SELECT idProd, nombreProd, codigoProd, unidadProd,precioProd FROM $table WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $codIngProducto, PDO::PARAM_INT);
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
  // Descargar excel ingreso productos por fechas
  public static function mdlObtenerDatosIngresoProductosporFecha($tabla, $fechaInicio, $fechaFin){
    $statement = Conexion::conn()->prepare("SELECT ingreso_prod.idIngProd, ingreso_prod.nombreIngProd, ingreso_prod.fechaIngProd, ingreso_prod.igvIngProd, ingreso_prod.subTotalIngProd, ingreso_prod.totalIngProd, ingreso_prod.ingJsonProd FROM $tabla WHERE ingreso_prod.fechaIngProd BETWEEN :fechaInicio AND :fechaFin");
    $statement->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $statement->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
