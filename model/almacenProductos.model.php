<?php

require_once "conexion.php";

class almacenProductosModel
{
  //datatable de ingresos productos
  public static function mdlDTableAlmacenProductos($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
      idAlmaProd, idProd, codigoProdAlma, nombreProdAlma, unidadProdAlma, cantidadProdAlma, precioProdAlma, DateUpdate, precioUnit
        FROM $table 
        ORDER BY 
          CASE 
            WHEN cantidadProdAlma > 0 THEN 1
            WHEN cantidadProdAlma < 0 THEN 2
            ELSE 3
          END ASC,
          DateUpdate DESC,
          idAlmaProd DESC
      ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //funcion para obtener el precio unitario de un producto
  public static function mdlPrecioUnitarioProducto($table, $idProd)
  {
    $statement = Conexion::conn()->prepare("SELECT precioProd FROM $table WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $idProd, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['precioProd'] : null;
  }

  //actualizar precio unitario de un producto
  public static function mdlUpdateUnitarioProducto($table, $idProd, $precioUnit)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET precioUnit = :precioUnit WHERE idProd = :idProd");
    $statement->bindParam(":idProd", $idProd, PDO::PARAM_INT);
    $statement->bindParam(":precioUnit", $precioUnit, PDO::PARAM_STR);
    if ($statement->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
