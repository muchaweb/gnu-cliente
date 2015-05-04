<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");
$link = Connect();

session_start();
		$idCliente		=	$_SESSION['idclientes'];
	 	//$email 			=   $_SESSION['email_init'];

if (!$_SESSION['status']) {      
    header("Location: ../");
    echo "...Regresando";
    exit;
}
include('expire-session.php');
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------


$idFolio = $_REQUEST['id'];
$rfc 	 = $_REQUEST['rfc'];

$operationFormats = mysql_query("SELECT * FROM operacion_cliente

							     WHERE operacion_cliente.idOperacion ='$idFolio'") or die(mysql_error());

$resultFormats = mysql_fetch_array($operationFormats);



$pathXML   =  "xml/".$resultFormats['xml'];

$pathPDF   =  "pdf/".$resultFormats['pdf'];

$keyXMLPDF =  $resultFormats[numeroOperacion];
$idClienteEmail = $resultFormats['idCliente'];

//Obtengo al cliente
$getEmail = mysql_query("SELECT * FROM clientes WHERE id_cliente ='$idClienteEmail' LIMIT 1") or die(mysql_error());
$resultemail = mysql_fetch_array($getEmail);

$email_factura       =   $resultemail['email'];

//ENVIO CORREO CON LA INFORMACION DEL PDF Y XML
/*require_once("../lib/mail/class.phpmailer.php");

require_once("../lib/mail/class.smtp.php");*/
require '../lib/mail/PHPMailerAutoload.php';
$txt = "Estimado usuario le hacemos llegar los datos de facturación solicitados.";

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'mail.gnu.mx';
$mail->SMTPAuth = true;
$mail->Username = 'ecs@gnu.mx';
$mail->Password = 'eC452519S';
$mail->SMTPSecure = 'tls';
$mail->Port = 25;
$mail->From = "ecs@gnu.mx";
$mail->SMTPDebug = 1;

$mail->FromName = iconv('UTF-8', 'ISO-8859-1',"Facturación GNU");
$mail->Subject = iconv('UTF-8', 'ISO-8859-1', "Datos de facturación | Operación: ".$keyXMLPDF);
$mail->AddAddress($email_factura , iconv('UTF-8', 'ISO-8859-1',"GNU")); 
$body = iconv('UTF-8', 'ISO-8859-1',$txt);
$mail->Body = $body;
$mail->AddAttachment($pathXML);
$mail->AddAttachment($pathPDF);
$mail->IsHTML(true);
$mail->Send();

if (!$mail->Send()) {
	echo "<script type='text/javascript'>window.location.href = 'show-bills.php?status_email=no-sent&email=$email&rfc=$rfc'; </script>";
}else{
	echo "<script type='text/javascript'>window.location.href = 'show-bills.php?status_email=sent&email=$email&rfc=$rfc'; </script>";
}









?>