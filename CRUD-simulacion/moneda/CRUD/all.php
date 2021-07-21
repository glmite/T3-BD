<?php

$json = file_get_contents('http://127.0.0.1:5000/api/moneda');

// Converts it into a PHP object
$monedas = json_decode($json,true)["monedas"];

foreach($monedas as $i => $value){

      $direccion_read = '<a href="/CRUD-simulacion/moneda/read.html?id=' . $value["id"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';
  
      $direccion_edit = '<a href="/CRUD-simulacion/moneda/update.html?id=' . $value["id"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';
  
      $direccion_delete = '<a href="/CRUD-simulacion/moneda/CRUD/delete.php?id=' . $value["id"] . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';
   
      echo '<tr>' . '<td>' . $value["id"] . '<td>' . $value["sigla"] . '<td>' . $value["nombre"] . '<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;	


}

?>

