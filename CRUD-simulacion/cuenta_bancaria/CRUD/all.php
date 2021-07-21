<?php
  include '../../db_config.php';
  $sql = "SELECT * FROM cuenta_bancaria";
  $result = pg_query_params($dbconn, $sql, array());


$json = file_get_contents('http://127.0.0.1:5000/api/cuenta_bancaria');

// Converts it into a PHP object
$cuentas = json_decode($json,true)["cuentas"];

foreach($cuentas as $i => $value){

      $direccion_read = '<a href="/CRUD-simulacion/cuenta_bancaria/read.html?id=' . $value["numero_cuenta"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';

      $direccion_edit = '<a href="/CRUD-simulacion/cuenta_bancaria/update.html?id=' . $value["numero_cuenta"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';

      $direccion_delete = '<a href="/CRUD-simulacion/cuenta_bancaria/CRUD/delete.php?id=' . $value["numero_cuenta"] . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';

      echo '<tr>' . '<td>' . $value["numero_cuenta"] . '<td>' . $value["id_usuario"] . '<td>' . $value["balance"] . '<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;


}


/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
?>
