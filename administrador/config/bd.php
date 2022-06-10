<?php

/* echo $txtID . "<br>";
echo $txtNombre . "<br>";
echo $txtImagen . "<br>";
echo $accion . "<br>"; */

$host="localhost";
$db='sitio';
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$db",$usuario,$contrasenia );
    if($conexion) {
        //echo "Conectando... a sistema";
    }
} catch ( Exception $ex) {

    echo $ex->getMessage();
    //throw $th;
}


?>