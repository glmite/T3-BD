<?php

error_reporting(0);
$id = preg_replace('#/CRUD-simulacion/usuario_tiene_moneda/read.html\?id=#', '', $_SERVER['REQUEST_URI']);
$id_sep = explode(',', $id);
if($id != '') {

$json_usuario_tiene_moneda = file_get_contents('http://127.0.0.1:5000/api/usuario_tiene_moneda');
$json_usuario = file_get_contents('http://127.0.0.1:5000/api/usuario');
$json_moneda = file_get_contents('http://127.0.0.1:5000/api/moneda');

$usuario_tiene_moneda = json_decode($json_usuario_tiene_moneda,true)["usuario moneda"];
$usuario = json_decode($json_usuario,true)["usuarios"];
$moneda = json_decode($json_moneda,true)["monedas"];

//Filtramos el json usuario_tiene_moneda

$usuario_tiene_moneda = array_filter($usuario_tiene_moneda, function ($var) use ($id_sep) {
    return ($var['id_usuario,id_moneda'] == $id);
});

foreach($usuario_tiene_moneda as $i => $value){ $usuario_tiene_moneda = $value; }

//Filtramos el json pais

$usuario = array_filter($usuario, function ($var) use ($id_sep) {
    return ($var['id'] == $id_sep[0]);
});

foreach($usuario as $i => $value){ $usuario = $value; }

//Filtramos el json pais


$moneda = array_filter($moneda, function ($var) use ($id_sep) {
    return ($var['id'] == $id_sep[1]);
});

foreach($moneda as $i => $value){ $moneda = $value; }

// Guardamos los valores
$id_usuario = $usuario["id"];
$nombre = $usuario["nombre"];
$apellido = $usuario["apellido"];
$id_moneda = $moneda["id"];
$moneda = $moneda["nombre"];
$balance = $usuario_tiene_moneda["balance"];


}else{
    pg_close($dbconn);
    header( "Location: /");
}


?>
