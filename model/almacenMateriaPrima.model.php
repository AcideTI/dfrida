<?php

require_once "conexion.php";

class almacenMateriaPrimaModel
{
  //datatable de ingresos productos prima
  public static function mdlDTableAlmacenProductosPrima($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
      idAlmaMprima, idMprima, codigoMprimaAlma, nombreMprimaAlma, unidadMprimaAlma, cantidadMprimaAlma, precioMprimaAlma, DateUpdate, precioUnit
        FROM $table 
        ORDER BY 
          CASE 
            WHEN cantidadMprimaAlma > 0 THEN 1
            WHEN cantidadMprimaAlma < 0 THEN 2
            ELSE 3
          END ASC,
          DateUpdate DESC,
          idAlmaMprima DESC
      ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //funcion para obtener el precio unitario de un producto
  public static function mdlPrecioUnitarioProducto($table, $idMprima)
  {
    $statement = Conexion::conn()->prepare("SELECT precioMprima FROM $table WHERE idMprima = :idMprima");
    $statement->bindParam(":idMprima", $idMprima, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['precioMprima'] : null;
  }

  //actualizar precio unitario de un producto
  public static function mdlUpdateUnitarioProducto($table, $idMprima, $precioUnit)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET precioUnit = :precioUnit WHERE idMprima = :idMprima");
    $statement->bindParam(":idMprima", $idMprima, PDO::PARAM_INT);
    $statement->bindParam(":precioUnit", $precioUnit, PDO::PARAM_STR);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
