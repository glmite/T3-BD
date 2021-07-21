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

 $id = preg_replace('#/CRUD-simulacion/usuario_tiene_moneda/delete.html\?id=#', '', $_SERVER['REQUEST_URI']);
 $id_equal = explode ('=', $id);

$direccion= 'http://127.0.0.1:5000/api/usuario_tiene_moneda/' . $id_equal[1];

echo $direccion;

$update_plan = callAPI('DELETE', $direccion, false);

header( "Location: /CRUD-simulacion/usuario_tiene_moneda/all.html");
?>
