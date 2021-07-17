<?php 
include '../db_config.php';


//obtiene el correo de la sesión
$email=$_SESSION["usuario"];

//realiza las consulta de los datos asociados a ese correo
$sql= "SELECT usuario.nombre AS nombre,apellido, correo, pais.nombre AS pais, fecha_registro FROM Usuario, Pais WHERE correo='$email' AND usuario.pais= pais.cod_pais";
$result = pg_query_params($dbconn, $sql, array());

//obtiene un array con los datos
if( pg_num_rows($result) > 0 ) {
    $row = pg_fetch_assoc($result);
    pg_close($dbconn);
} 
else {
    echo "Hubo un error al solicitar los datos";
    pg_close($dbconn);
}

?>
