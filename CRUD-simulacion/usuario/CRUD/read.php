<?php

$id = preg_replace('#/CRUD-simulacion/usuario/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

if($id != '') {

$json_usuario = file_get_contents('http://127.0.0.1:5000/api/usuario');
$json_pais = file_get_contents('http://127.0.0.1:5000/api/pais');


$usuario = json_decode($json_usuario,true)["usuarios"];
$paises = json_decode($json_pais,true)["paises"];

//Filtramos el json usuario 

$usuario = array_filter($usuario, function ($var) use ($id) {
    return ($var['id'] == $id);
});

foreach($usuario as $i => $value){ $usuario = $value; }

//Filtramos el json pais

$cod = $usuario["pais"];

$paises = array_filter($paises, function ($var) use ($cod) {
    return ($var['cod_pais'] == $cod);
});

foreach($paises as $i => $value){ $paises = $value; }

// Guardamos los valores

$nombre = $usuario["nombre"];
$apellido = $usuario["apellido"];
$correo = $usuario["correo"];
$fecha = $usuario["fecha_registro"];
$cod_pais = $usuario["pais"];
$pais = $paises["nombre"];


}else{
    pg_close($dbconn);   
    header( "Location: /");
}
    

?>
