<?php
class FunctionPedidos
{
  //  Estados de los pedidos
  public static function getEstadoPedido($stateValue)
  {
    // Estado de los Pedidos
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-primary">Asignado</span>';
    }
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-warning">Sin Asignar</span>';
    }
    if ($stateValue == 3) {
      $estado = '<span class="badge rounded-pill bg-success">Finalizado</span>';
    }
    if ($stateValue == 4) {
      $estado = '<span class="badge rounded-pill bg-info">Entregado</span>';
    }
    return $estado;
  }

  //botones Pedido
  public static function getBtnPedido($idPedido, $estadoPedido, $idCoti)
  {
    // Deshabilitar si el estado del pedido es 2 o 3
    $disabled = ($estadoPedido == 2 || $estadoPedido == 3 || $estadoPedido == 4) ? 'disabled' : '';
    $botones = '
        <button class="btn btn-primary btnEditarPedido" idPedido="' . $idPedido . '" ' . $disabled . '><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-danger btnDeletePedido" idPedido="' . $idPedido . '" idCoti = "' . $idCoti . '" ' . $disabled . '><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-dark btnDescargarPedidoPdf" idPedido="' . $idPedido . '"><i class="fa-solid fa-file-pdf"></i></button>
        ';
    return $botones;
  }
  //boton para ver el cliente del pedido
  public static function getBtnVerClientePedido($codPed, $idCli)
  {
    $botones = '
         <button class="btn btn-success btnVerClientePedido" data-bs-toggle="modal" data-bs-target="#modalVerClientePedidos" codPed="' . $codPed . '" idCli="' . $idCli . '">
         <i class="fa-solid fa-user-tie"></i>
         </button>
        ';
    return $botones;
  }
  //boton para ver el cliente del pedido
  public static function getBtnVerProductosPedido($codPed, $idCoti)
  {
    $botones = '
             <button class="btn btn-primary btnVerProductosPedido" data-bs-toggle="modal" data-bs-target="#modalVerProdCotiPedidos" codPed="' . $codPed . '" idCoti="' . $idCoti . '">
             <i class="fa-solid fa-boxes-packing"></i>
             </button>
            ';
    return $botones;
  }
  //boton para ver el cliente del pedido
  public static function getBtnVerProductosPrimaPedido($codPed, $idSalMprima)
  {
    $botones = '
         <button class="btn btn-warning btnVerProductosPrimaPedido" data-bs-toggle="modal" data-bs-target="#modalVerProdPrimaCotiPedidos" codPed="' . $codPed . '" idSalMprima="' . $idSalMprima . '">
         <i class="fa-solid fa-box-archive"></i>
         </button>
        ';
    return $botones;
  }

}

