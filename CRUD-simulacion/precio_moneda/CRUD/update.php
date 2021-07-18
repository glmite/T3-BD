<?php

/* Este archivo debe manejar la lógica de actualizar los datos de un usuario como admin */

$id = preg_replace('#/admin/users/update.html\?id=#', '', $_SERVER['REQUEST_URI']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../../db_config.php';

    //variables obtenidas de la query    
    $nombre_usr = $_POST["name"];
    $apellido_usr = $_POST["surname"];
    $pais_usr = $_POST["country"];
    $email = $_POST["email"];
    $contrasena = $_POST["pwd"];
    $opciones = array('cost'=>12);
    $id =$_POST["id"];

    //En el caso en que no se haya ingresado contraseña, no se cambia
    if($contrasena=="") {
        $sql_sin_contrasena = 
        'UPDATE usuario  
        SET nombre=$1,apellido=$2, correo=$3, pais=$4 
        WHERE ID =$5;';
        if( pg_query_params($dbconn, $sql_sin_contrasena, array($nombre_usr,$apellido_usr,$email,$pais_usr,$id)) !== FALSE ) {
            pg_close($dbconn);
        echo "Dato actualizado con exito";
        } else {
            echo "no se pudieron actualizar los datos";
            pg_close($dbconn);
        }
    }else { 
    $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
    $sql_con_contrasena = 
    'UPDATE usuario  
    SET nombre=$1,apellido=$2, correo=$3, contraseña=$4, pais=$5 
    WHERE ID =$6;';
    
    //se verifica si la query funcionó
    if( pg_query_params($dbconn, $sql_con_contrasena, array($nombre_usr,$apellido_usr,$email, $contrasena_hasheada,$pais_usr,$id)) !== FALSE ) {
        pg_close($dbconn);
	echo "Dato actualizado con exito";
    } else {
        echo "no se pudieron actualizar los datos";
        pg_close($dbconn);
    }
}

    header( "Location: ../all.html");
} 
elseif($id != '') {

$query = 
' SELECT usuario.nombre AS usuario
,apellido,correo,pais.nombre AS pais,
contraseña,
pais.cod_pais AS cod_pais, 
fecha_registro FROM 
pais JOIN usuario
 ON usuario.pais=pais.cod_pais 
 WHERE id = $1
 ';
 
$result = pg_query_params($dbconn, $query, array($id));
if( $result !== FALSE ) {
    pg_close($dbconn);
    $info_usuario = pg_fetch_assoc($result);
} else {
    echo "Usuario no existe";    
    pg_close($dbconn);
    header("Location: /");
}
} else {
header("Location: /");
}
?>