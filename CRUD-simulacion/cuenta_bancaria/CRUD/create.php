<?php
include $_SERVER['DOCUMENT_ROOT']. '/include/header.html';
include $_SERVER['DOCUMENT_ROOT']. '/sesion/valida_sesion.php';


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
             curl_setopt($curl, CURLOPT_POST, "DELETE");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Las siguientes lineas son para obtener el id del ultimo registrado
$data_array =  array( 'id_usuario'   => $_POST['id_usuario'],
      'balance'   => $_POST['balance'],);
$update_plan = callAPI('POST', 'http://127.0.0.1:5000/api/cuenta_bancaria', json_encode($data_array));
}
header("Location: /CRUD-simulacion/cuenta_bancaria/all.html");
?>
