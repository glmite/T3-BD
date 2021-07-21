<?php

$id = preg_replace('#/CRUD-simulacion/pais/read.html\?id=#', '', $_SERVER['REQUEST_URI']);

if($id != '') {

    $json_pais = file_get_contents('http://127.0.0.1:5000/api/pais' );

    $paises = json_decode($json_pais,true)["paises"];
    
    $paises = array_filter($paises, function ($var) use ($id) {
        return ($var['cod_pais'] == $id);
    });
    
    foreach($paises as $i => $value){ $pais = $value; }
    
    $cod_pais = $id;
    $nombre = $pais["nombre"];

}else{
    header( "Location: /");
}
    

?>
