<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/sesion/valida_sesion.php';

// es esta la manera más eficiente?
// recordar id usuario

$id = preg_replace('#/admin/users/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

if($id != '') {
$query = 
' SELECT usuario.nombre AS usuario
,apellido,correo,pais.nombre AS pais
,fecha_registro,id FROM 
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
}
}else{
    pg_close($dbconn);   
    header( "Location: /");
}
    

?>