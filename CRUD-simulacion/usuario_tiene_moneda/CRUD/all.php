<?php
  include '../../db_config.php';
  $sql = "SELECT * FROM usuario_tiene_moneda";
  $result = pg_query_params($dbconn, $sql, array());


$json = file_get_contents('http://127.0.0.1:5000/api/usuario_tiene_moneda');

// Converts it into a PHP object
$usuarios = json_decode($json,true)["usuario moneda"];

foreach($usuarios as $i => $value){

      $direccion_read = '<a href="/CRUD-simulacion/usuario_tiene_moneda/read.html?id=' . $value["id_usuario"] . ',' . $value["id_moneda"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';

      $direccion_edit = '<a href="/CRUD-simulacion/usuario_tiene_moneda/update.html?id=' . $value["id_usuario"] . ',' . $value["id_moneda"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';

      $direccion_delete = '<a href="/CRUD-simulacion/usuario_tiene_moneda/CRUD/delete.php?id=' . $value["id_usuario"] . ',' . $value["id_moneda"] . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';

      echo '<tr>' . '<td>' . $value["id_usuario"] . '<td>' . $value["id_moneda"] . '<td>' . $value["balance"] . '<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;


}


/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
?>
