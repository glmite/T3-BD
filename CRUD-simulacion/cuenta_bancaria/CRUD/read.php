<?php

$id = preg_replace('#/CRUD-simulacion/cuenta_bancaria/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

if($id != '') {

$json_cuenta_bancaria = file_get_contents('http://127.0.0.1:5000/api/cuenta_bancaria');
$json_usuario = file_get_contents('http://127.0.0.1:5000/api/usuario');

$cuenta = json_decode($json_cuenta_bancaria,true)["cuentas"];
$usuario = json_decode($json_usuario,true)["usuarios"];

//Filtramos el json cuenta

$cuenta = array_filter($cuenta, function ($var) use ($id) {
    return ($var['numero_cuenta'] == $id);
});

foreach($cuenta as $i => $value){ $cuenta = $value; }

//Filtramos el json usuario

$cod = $cuenta["id_usuario"];

$usuario = array_filter($usuario, function ($var) use ($cod) {
    return ($var['id'] == $cod);
});

foreach($usuario as $i => $value){ $usuario = $value; }

// Guardamos los valores
$apellido = $usuario["apellido"];
$nombre = $usuario["nombre"];
$balance = $cuenta["balance"];

}else{
    pg_close($dbconn);
    header( "Location: /");
}


?>
