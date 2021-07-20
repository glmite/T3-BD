<?php

function callAPI($method, $url, $data){
   $curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: 111111111111111111111',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

/* Este archivo debe manejar la lógica de actualizar los datos de un usuario como admin */

$id = preg_replace('#/CRUD-simulacion/usuario/update.html\?id=#', '', $_SERVER['REQUEST_URI']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../../db_config.php';

    // takes raw data from the request 
    $json = file_get_contents('php://input');
    $ide = str_replace(' ', '', $_POST['id']);
    $update_plan = callAPI('PUT', 'http://127.0.0.1:5000/api/usuario/' .$ide , json_encode($_POST));
    
    header("Location: /CRUD-simulacion/usuario/all.html");
} 
elseif($id != '') {

$json_usuario = file_get_contents('http://127.0.0.1:5000/api/usuario');
$json_pais = file_get_contents('http://127.0.0.1:5000/api/pais');

$usuario = json_decode($json_usuario,true)["usuarios"];
$paises = json_decode($json_pais,true)["paises"];

//Filtramos el json usuario 

$usuario = array_filter($usuario, function ($var) use ($id) {
    return ($var['id'] == $id);
});

foreach($usuario as $i => $value){ $usuario = $value; $id = $i; }

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
$identificador = $usuario["id"];


} else {
header("Location: /");
}
?>
