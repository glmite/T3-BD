<?php
include '../../../db_config.php';
$numbers = preg_replace('/[^0-9]/', '', $_SERVER['REQUEST_URI']);
$sql = "DELETE FROM usuario WHERE id=$numbers";
if(pg_query($dbconn, $sql)){
    echo "Record was deleted successfully.";
}
else{
    echo "ERROR: Could not able to execute $sql. ". mysqli_error($dbconn);
}
header( "Location: ../all.html");
?>
