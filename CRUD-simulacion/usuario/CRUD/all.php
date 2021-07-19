<?php
  include '../../db_config.php';
  $sql = "SELECT * FROM usuario";
  $result = pg_query_params($dbconn, $sql, array());


$json = file_get_contents('http://127.0.0.1:5000/api/usuario');

// Converts it into a PHP object
$usuarios = json_decode($json,true)["usuarios"];

foreach($usuarios as $i => $value){

      $direccion_read = '<a href="/CRUD-simulacion/usuario/read.html?id=' . $value["id"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';
  
      $direccion_edit = '<a href="/CRUD-simulacion/usuario/update.html?id=' . $value["id"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';
  
      $direccion_delete = '<a href="/CRUD-simulacion/usuario/CRUD/delete.php?id=' . $value["id"] . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';
   
      echo '<tr>' . '<td>' . $value["id"] . '<td>' . $value["nombre"] . '<td>' . $value["apellido"] . '<td>' . $value["correo"] . '<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;	


}

 
/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
?>
