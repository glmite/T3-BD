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
          case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
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

$patrones= array();
$patrones[0]='/\/CRUD-simulacion\/precio_moneda\/CRUD\/delete.php\?id\=/';
$patrones[1] ='/delete.php\?fecha\=/';

$sustituciones=array();
$sustituciones[0]= '/';
$sustituciones[1]= '';


$numbers = preg_replace($patrones, $sustituciones, $_SERVER['REQUEST_URI']);

$direccion= 'http://127.0.0.1:5000/api/precio' . $numbers;

$update_plan = callAPI("DELETE", $direccion,false);

header( "Location: /CRUD-simulacion/precio_moneda/all.html");
?>




