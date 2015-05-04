<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");
$link = Connect();

//Sanitizar
$rfc                    =       filter_var($_POST['rfc'], FILTER_SANITIZE_STRING);
$razon_social           =       filter_var($_POST['razonSocial'], FILTER_SANITIZE_STRING);
$nombre                 =       filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$numExterior            =       filter_var($_POST['numExterior'], FILTER_SANITIZE_STRING);
$numInterior            =       filter_var($_POST['numInterior'], FILTER_SANITIZE_STRING);
$localidad              =       filter_var($_POST['localidad'], FILTER_SANITIZE_STRING);
$pais                   =       filter_var($_POST['pais'], FILTER_SANITIZE_STRING);
$calle                  =       filter_var($_POST['calle'], FILTER_SANITIZE_STRING);
$colonia                =       filter_var($_POST['colonia'], FILTER_SANITIZE_STRING);
$municipio              =       filter_var($_POST['municipio'], FILTER_SANITIZE_STRING);
$estado                 =       filter_var($_POST['estado'], FILTER_SANITIZE_STRING);
$cp                     =       filter_var($_POST['cp'], FILTER_SANITIZE_NUMBER_INT);
$tel                    =       filter_var($_POST['tel'], FILTER_SANITIZE_STRING);
$email                  =       filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

//Validar
$rfc          =     mysql_real_escape_string($rfc);
$razon_social =     mysql_real_escape_string($razon_social);
$nombre       =     mysql_real_escape_string($nombre);
$numExterior  =     mysql_real_escape_string($numExterior);
$numInterior  =     mysql_real_escape_string($numInterior);
$localidad    =     mysql_real_escape_string($localidad);
$pais         =     mysql_real_escape_string($pais);
$calle        =     mysql_real_escape_string($calle);
$colonia      =     mysql_real_escape_string($colonia);
$municipio    =     mysql_real_escape_string($municipio);
$estado       =     mysql_real_escape_string($estado);
$cp           =     mysql_real_escape_string($cp);
$tel          =     mysql_real_escape_string($tel);
$email        =     mysql_real_escape_string($email);

//Guardar datos del cliente
$saveClient = mysql_query("INSERT INTO clientes (nombre, calle, colonia, 
                                                 num_exterior, num_interior, 
                                                 localidad, municipio, estado, 
                                                 pais, cp, telefono, email, rfc, razon_social) 
                            VALUES ('$nombre','$calle', '$colonia', 
                                    '$numExterior', '$numInterior', 
                                    '$localidad', '$municipio',  '$estado', 
                                    '$pais', '$cp', '$tel', '$email', '$rfc', '$razon_social')");

if($saveClient == true){
    header("Location:../index.php?register=ok");
}else{
    header("Location:../index.php?register=error");
}
?>