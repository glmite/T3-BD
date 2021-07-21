<?php
  include '../../db_config.php';
  $sql = "SELECT * FROM usuario";
  $result = pg_query_params($dbconn, $sql, array());


$json = file_get_contents('http://127.0.0.1:5000/api/precio');

// Converts it into a PHP object
$precios = json_decode($json,true)["precios"];

foreach($precios as $i => $value){

      $direccion_read = '<a href="/CRUD-simulacion/precio_moneda/read.html?id=' . $value["id_moneda"] .'/read.html?fecha=' . $value["fecha"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';
  
      $direccion_edit = '<a href="/CRUD-simulacion/precio_moneda/update.html?id=' . $value["id_moneda"] . '/update.html?fecha=' . $value["fecha"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';
  
      $direccion_delete = '<a href="/CRUD-simulacion/precio_moneda/CRUD/delete.php?id=' . $value["id_moneda"]. '/delete.php?fecha=' . $value["fecha"]  . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';
   
      echo '<tr>' . '<td>' . $value["id_moneda"] . '<td>' . $value["valor"] . '<td>' . $value["fecha"] . '<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;	


}

 
/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
?>
