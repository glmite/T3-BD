<?php

$id = preg_replace('#/CRUD-simulacion/pais/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

if($id != '') {

$json_pais = file_get_contents('http://127.0.0.1:5000/api/pais' );


$paises = json_decode($json_pais,true)["paises"];

$cod_pais = $id;
$nombre = $paises[$id]["nombre"];


}else{
    pg_close($dbconn);   
    header( "Location: /");
}
    

?>
