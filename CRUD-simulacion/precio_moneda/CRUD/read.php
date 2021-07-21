<?php

#$id = preg_replace('#/CRUD-simulacion/pais/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

$patrones= array();
$patrones[0]='/\/CRUD-simulacion\/precio_moneda\/read.html\?id\=/';
$patrones[1] ='/\/read.html\?fecha\=.*/';

$sustituciones=array();
$sustituciones[0]= '';
$sustituciones[1]= '';

$id = preg_replace($patrones, $sustituciones, $_SERVER['REQUEST_URI']);

#se obtiene fecha de url
$patron= '/\/CRUD-simulacion\/precio_moneda\/read.html\?id\=[0-9]+\/read.html\?fecha=/';
$fecha= preg_replace($patron, '', $_SERVER['REQUEST_URI']);
$fecha= preg_replace('/%20/', ' ', $fecha);

if($id != '') {

$json_precio = file_get_contents('http://127.0.0.1:5000/api/precio' );

$precios = json_decode($json_precio,true)["precios"];

$precios= array_filter($precios, function ($var) use ($id,$fecha){
    return ($var['id_moneda']==$id and $var['fecha']== $fecha);
});

foreach($precios as $i => $value){$precio= $value;}

$id_moneda= $id;
$fecha= preg_replace($patron, '', $_SERVER['REQUEST_URI']);

}else{
    pg_close($dbconn);   
    header( "Location: /");
}
    

?>
