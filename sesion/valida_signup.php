<?php 

include '../db_config.php';
include '../include/header.html';
include 'valida_sesion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usr = $_POST["name"];
    $apellido_usr = $_POST["surname"];
    $pais_usr = $_POST["country"];
    $email = $_POST["email"];
    $contrasena = $_POST["pwd2"];
    $fecha = date("Y-m-d");
    $opciones = array('cost'=>12);

// Las siguientes lineas son para obtener el id del ultimo registrado

    $query_cantidad = 'SELECT ID FROM USUARIO order by ID desc LIMIT 1';    
    $query_cantidad = pg_query_params($dbconn, $query_cantidad,array());
    $query_cantidad = pg_fetch_assoc($query_cantidad);
    $query_cantidad = $query_cantidad["id"];

    $id = $query_cantidad +1;


    $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);

    $sql = 'INSERT INTO usuario (nombre,apellido, correo, contraseña, pais,fecha_registro, administrador, id) VALUES ($1, $2,$3,$4,$5,$6,$7,$8)';
    if( pg_query_params($dbconn, $sql, array($nombre_usr,$apellido_usr,$email, $contrasena_hasheada,$pais_usr,$fecha,0,$id)) !== FALSE ) {
        session_start();
	$_SESSION["usuario"] = $email;
	header("Status: 301 Moved Permanently");
	header("Location: ../index.html");
	exit;
        pg_close($dbconn);
    } else {
        echo "Usuario ya registrado";
        pg_close($dbconn);
    }

}
?>
