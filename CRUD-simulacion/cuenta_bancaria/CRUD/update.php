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

$id = preg_replace('#/CRUD-simulacion/cuenta_bancaria/update.html\?id=#', '', $_SERVER['REQUEST_URI']);
$idef = explode('=',$id);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // takes raw data from the request
    $json = file_get_contents('php://input');
    $ide = str_replace(' ', '', $_POST['id']);
    $update_plan = callAPI('PUT', 'http://127.0.0.1:5000/api/cuenta_bancaria/' . $ide , json_encode($_POST));

    header("Location: /CRUD-simulacion/cuenta_bancaria/all.html");
}
elseif($id != '') {

$json_cuenta = file_get_contents('http://127.0.0.1:5000/api/cuenta_bancaria');

$cuenta = json_decode($json_cuenta,true)["cuentas"];

//Filtramos el json moneda

$cuenta = array_filter($cuenta, function ($var) use ($id) {
    return ($var['numero_cuenta'] == $id);
});

foreach($cuenta as $i => $value){ $cuenta = $value; }

// Guardamos los valores

$balance = $cuenta["balance"];

} else {
header("Location: /");
}
?>
