<?php include 'db_config.php';

//Este php es para cerrar la sesión. Al cerrar la sesión redirecciona a index.html

session_start();   
session_destroy(); 
header("location: ../index.html");
exit();
?>
