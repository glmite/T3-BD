<?php 
include '../db_config.php';

//obtiene el correo de la sesión
$email=$_SESSION["usuario"];
	
//sql consulta con datos asociados a nuestro usuario
$sql = "SELECT sigla,nombre, balance, valor, valor*balance AS total FROM (SELECT sigla, nombre, balance, id_moneda FROM usuario_tiene_moneda INNER JOIN moneda ON moneda.id= usuario_tiene_moneda.id_moneda WHERE correo = '$email') AS a INNER JOIN (SELECT d.id_moneda, d.valor, d.fecha FROM precio_moneda AS d WHERE fecha = (SELECT max(d1.fecha) FROM precio_moneda AS d1 WHERE d1.id_moneda= d.id_moneda)) AS b ON b.id_moneda= a.id_moneda ";
$result = pg_query_params($dbconn, $sql, array());
pg_close($dbconn); 


?>
