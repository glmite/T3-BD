<?php
  include '../../db_config.php';
  $sql = "SELECT * FROM usuario";
  $result = pg_query_params($dbconn, $sql, array());
  if (pg_num_rows($result) > 0)
  {
    while ($row = pg_fetch_assoc($result))
    {
      $direccion_read = '<a href="/admin/users/read.html?id=' . $row["id"] . '" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>';
      //<a href="/admin/users/read.html?id=$ontador" class="btn btn-primary">Ver <i class="fas fa-search"></i></a>
      $direccion_edit = '<a href="/admin/users/update.html?id=' . $row["id"] . '" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>';
      //'<a href="/admin/users/update.html?id=$contador" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>'
      $direccion_delete = '<a href="/admin/users/CRUD/delete.php?id=' . $row["id"] . '" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>';
      //'<a href="/admin/users/CRUD/delete.php?id=$contador class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></a>'
      echo '<tr>' . '<td>' . $row["id"] . '<td>' . $row["nombre"] . '<td>' . $row["apellido"] . '<td>' . $row["correo"] . '<td>' .
          $direccion_read . '<td>' .
          $direccion_edit . '<td>' .
          $direccion_delete;
    }
  }
/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
?>
