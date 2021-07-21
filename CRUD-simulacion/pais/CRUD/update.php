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

$id = preg_replace('#/CRUD-simulacion/pais/update.html\?id=#', '', $_SERVER['REQUEST_URI']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // takes raw data from the request 
    $ide = str_replace(' ', '', $_POST['cod_pais']);
    $update_plan = callAPI('PUT', 'http://127.0.0.1:5000/api/pais/' .$ide , json_encode($_POST));
    
    header("Location: /CRUD-simulacion/pais/all.html");
} 
elseif($id != '') {

   $json_pais = file_get_contents('http://127.0.0.1:5000/api/pais' );


   $paises = json_decode($json_pais,true)["paises"];

   $pais = array_filter($paises, function ($var) use ($id) {
      return ($var['cod_pais'] == $id);
  });
  
  foreach($pais as $i => $value){ $nombre = $value["nombre"]; }
   $cod_pais = $id;


} else {
header("Location: /");
}
?>
