<?php 
include '../db_config.php';

// Lo siguiente guarda en variables lo que escribio el usuario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_usr = $_POST["email"];
    $contrasena = $_POST["pwd"];
    $query = 'SELECT contraseña FROM usuario WHERE correo = $1';
    $contrasena_hasheada = pg_query_params($dbconn, $query, array($email_usr));
    $contrasena_hasheada = pg_fetch_assoc($contrasena_hasheada);
    $contrasena_hasheada = $contrasena_hasheada["contraseña"];
 
//Comprobamos que la contraseña sea correcta. Si la contraseña o el usuario no existe php tirará un warning 

    if(password_verify($contrasena, $contrasena_hasheada)){
	session_start();
	$_SESSION["usuario"] = $email_usr;
	header('Status: 301 Moved Permanently');
	header('Location: ../index.html');
        

}
    else{echo 'Contraseña o email incorrecto intente nuevamente <br>';}
    
}

pg_close($dbconn);?>
