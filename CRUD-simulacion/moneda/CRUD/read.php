<?php

$id = preg_replace('#/CRUD-simulacion/moneda/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

if($id != '') {

$json_moneda = file_get_contents('http://127.0.0.1:5000/api/moneda' );

$monedas= json_decode($json_moneda,true)["monedas"];

$monedas = array_filter($monedas, function ($var) use ($id) {
    return ($var['id'] == $id);
});

foreach($monedas as $i => $value){ $moneda = $value; }


$sigla = $moneda["sigla"];
$nombre = $moneda["nombre"];


}else{
    pg_close($dbconn);   
    header( "Location: /");
}
    

?>
