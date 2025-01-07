<?php

///hostin local

/* class Conexion
{
  static public function conn()
  {
    $link = new PDO("mysql:host=db;dbname=pruebasbetaacide_dfrida", "root", "test");
    $link->exec("set names utf8");
    return $link;
  }
} */

//conexcion Cpanel

class Conexion
{
  static public function conn()
  {
    $link = new PDO("mysql:host=localhost;dbname=pruebasbetaacide_dfrida", "pruebasbetaacide_admin_dfrida", "W(^bm#y..?gJ");
    $link->exec("set names utf8");
    return $link;
  }
} 

