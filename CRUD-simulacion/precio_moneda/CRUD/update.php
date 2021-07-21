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
#Se obtiene id moneda de url
$patrones= array();
$patrones[0]='/\/CRUD-simulacion\/precio_moneda\/update.html\?id\=/';
$patrones[1] ='/\/update.html\?fecha\=.*/';

$sustituciones=array();
$sustituciones[0]= '';
$sustituciones[1]= '';

$id_moneda = preg_replace($patrones, $sustituciones, $_SERVER['REQUEST_URI']);

#se obtiene fecha de url
$patron= '/\/CRUD-simulacion\/precio_moneda\/update.html\?id\=[0-9]+\/update.html\?fecha=/';
$fecha= preg_replace($patron, '', $_SERVER['REQUEST_URI']);


#Método para actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../../db_config.php';
    #se obtienen id moneda 
    $id_moneda= $_POST['id_moneda'];
    $id_moneda= str_replace(' ', '', $id_moneda);
    #se obtiene fecha
    $fecha= $_POST['fecha'];
    $fecha = str_replace(' ', '%20', $fecha);
    $fecha= ltrim($fecha, '%20');
    $fecha= rtrim($fecha, '%20');

    #dirección para actualizar
    $direccion= 'http://127.0.0.1:5000/api/precio/' . $id_moneda . '/' . $fecha;
    #valor a actualizar
    $data_array =  array( 'valor'   => $_POST['value']);

    #actualiza y vuelve a la tabla
    $update_plan = callAPI('PUT', $direccion , json_encode($data_array));
    header("Location: /CRUD-simulacion/precio_moneda/all.html");
} 
elseif($id_moneda != '' and $fecha != '') {
$json_precios = file_get_contents('http://127.0.0.1:5000/api/precio');

$precios = json_decode($json_precios,true)["precios"];

//Filtramos el json usuario 
$precio = array_filter($precios, function ($var) use ($id_moneda, $fecha) {
    return ($var['id_moneda'] == $id_moneda and $var["fecha"]== $fecha);
});

foreach($precio as $i => $value){ 
    #$usuario = $value; $id = $i; 
}

} else {
#header("Location: /");
}
?>