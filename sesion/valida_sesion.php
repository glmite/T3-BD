<?php 
include $_SERVER['DOCUMENT_ROOT']. '/db_config.php';
session_start();

//En las siguientes lineas veremos si el usuario es admin o no. En caso de ser admin $type_user = True
if(isset($_SESSION["usuario"])!=FALSE){
    $query_type_user = 'SELECT Administrador FROM usuario WHERE correo = $1';
    $query_type_user  = pg_query_params($dbconn, $query_type_user, array($_SESSION["usuario"]));
    $query_type_user  = pg_fetch_assoc($query_type_user);
    $type_user = $query_type_user["administrador"];

        if(preg_match_all("/admin/",$_SERVER['REQUEST_URI']) !=0) {
                if($type_user=='f') {
                    header( "Location: /");
                }
            }elseif(preg_match_all("#user/wallet#",$_SERVER['REQUEST_URI']) !=0) {
                if($type_user=='t') {
                    header( "Location: /");
                }
            }
        }elseif($_SERVER['REQUEST_URI'] != "/sesion/log-in.html" && $_SERVER['REQUEST_URI'] != "/sesion/sign-up.html" &&$_SERVER['REQUEST_URI'] != "/" ){
            header( "Location: /");
}

/* Este archivo debe usarse para comprobar si existe una sesión válida 
   Considerar qué pasa cuando la sesión es válida/inválida para cada página:
   - Página principal
   - Mi perfil
   - Mi billetera
   - Administración de usuarios y todo el CRUD
   - Iniciar Sesión
   - Registrarse
*/
?>
