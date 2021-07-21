<?php
  include '../../db_config.php';
  $sql = "SELECT * FROM usuario";
  $result = pg_query_params($dbconn, $sql, array());


$json = file_get_contents('http://127.0.0.1:5000/api/pais');

// Converts it into a PHP object
$pais = json_decode($json,true)['paises'];

foreach($pais as $i => $value){

      $direccion_read = '<a href="/CRUD-simulacion/pais/read.html?id=' . $value["cod_pais"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';
  
      $direccion_edit = '<a href="/CRUD-simulacion/pais/update.html?id=' . $value["cod_pais"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';
  
      $direccion_delete = '<a href="/CRUD-simulacion/pais/CRUD/delete.php?id=' . $value["cod_pais"] . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';
   
      echo '<tr>' . '<td>' . $value["cod_pais"] . '<td>' . $value["nombre"] .'<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;	


}

 
/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
?>

