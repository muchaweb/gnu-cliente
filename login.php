<?php 
header("Content-Type: application/json; charset=UTF-8");
session_start();

include('lib/connect.php');
$link = Connect();

$rfc    = $_POST['rfc'];
//Sanitizar
$rfc   = filter_var($rfc, FILTER_SANITIZE_STRING);
//Validate
$rfc   = mysql_real_escape_string($rfc);

$access = mysql_query("SELECT * FROM clientes WHERE rfc ='$rfc' LIMIT 1");

if ($row= mysql_fetch_array($access)) {
        $_SESSION['id']             =   $row['id_cliente'];
        $_SESSION['rfc']            =   $row['rfc'];
        $_SESSION['status']         =   "in";   
        $_SESSION['fecha_usuario']  =   date("Y-n-j");
        $_SESSION['email_init']     =   $email;

        header("Location:site/options.php");
    }else {
        header("Location:site/new_client.php");
    } 

?>