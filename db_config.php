
    <?php
    // detalles de la conexion
    $conn_string = "host=localhost port=5432 dbname= user=postgres password=";
    // establecemos una conexion con el servidor postgresSQL
    $dbconn = pg_connect($conn_string);
    // Revisamos el estado de la conexion en caso de errores.
    if (!$dbconn) {
        echo "<body><h1>Error: No se ha podido conectar a la base de datos\n</h1></body>";
    }
    // Cerramos la conexion
    // pg_close($dbconn);
    ?>
