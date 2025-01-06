<?php

///hostin local

class Conexion
{
  static public function conn()
  {
    $link = new PDO("mysql:host=db;dbname=pruebasbetaacide_dfrida", "root", "test");
    $link->exec("set names utf8");
    return $link;
  }
}

//hostinguer

/* class Conexion
{
  static public function conn()
  {
    $link = new PDO("mysql:host=localhost;dbname=pruebasbetaacide_admin_dfrida", "pruebasbetaacide_admin_dfrida", "xb{kk[6{uMrF");
    $link->exec("set names utf8");
    return $link;
  }
} */
