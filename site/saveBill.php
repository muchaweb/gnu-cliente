<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");
$link = Connect();

session_start();

$rfc    =   $_SESSION['rfc'];

if (!$_SESSION['status']) {      
  header("Location: ../");
  echo "...Regresando";
  exit;
}

include('expire-session.php');
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
$operacion  =  $_REQUEST['operacion'];

if ( $operacion == "" OR $operacion == NULL){
    header("Location:options.php?op=no_existe1");
    exit;
  }


include('validate-chips.php');

//General
$idclientes             =       $_POST['idclientes'];
$idFacturacion_data     =       $_POST['idFacturacion'];

if($idFacturacion_data == ""){
  $saveBillClient = mysql_query("INSERT INTO facturacion_cliente (idclientes, razonSocial, email) 
                                 VALUES ('$idclientes', '$razonSocial', '$email')");
}

//$idFacturacion = mysql_insert_id();

$selectFact = mysql_query("SELECT idFacturacion FROM operacion_cliente ORDER BY idOperacion DESC LIMIT 1");

$r = mysql_fetch_array($selectFact);
$idFacturacion = $r['idFacturacion']+1;


//Sanitizar y validar
$idclientes   = filter_var($idclientes, FILTER_SANITIZE_NUMBER_INT);
$idclientes   = mysql_real_escape_string($idclientes);

//Datos cliente
$razonSocial            =       $_REQUEST['razonSocial'];
$email                  =       $_POST['email']; 
$nombre                 =       $_POST['nombre'];
$calle                  =       $_POST['calle'];
$numExterior            =       $_POST['numExterior'];
$tel                    =       $_POST['tel'];
$pais                   =       $_POST['pais'];
$colonia                =       $_POST['colonia'];
$municipio              =       $_POST['municipio'];
$estado                 =       $_POST['estado'];
$cp                     =       $_POST['cp'];


if($_POST['numInterior'] == "" OR $_POST['numInterior'] == null){
  $numInterior            = 0;
}else{
  $numInterior            = $_POST['numInterior'] ;
}

if($_POST['localidad']   == "" OR $_POST['localidad'] == null){
  $localidad              = "No disponible";
}else{
  $localidad              = $_POST['localidad'] ;
}

//Viabilidad en fecha de facturación
foreach ($operacion as $keyDate) {
  $checkOp = mysql_query("SELECT * FROM operacion_cliente WHERE numeroOperacion = '$keyDate'");
  $countOp = mysql_num_rows($checkOp);

  if($countOp != 0){
    header("Location:options.php?op=facturado_anteriormente");
    exit;
  }
  
  //-----Cross domain a: ventas_general------------------------------------------------
  $url = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$keyDate";
  $ch2 = curl_init();
  curl_setopt($ch2, CURLOPT_URL, $url);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch2, CURLOPT_TIMEOUT, 200);
  curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
  $json_object2 = curl_exec($ch2);
  curl_close($ch2); 

  //Variables
  $array2             =   json_decode($json_object2, true);
  
  $dataID = $array2['rows'][1]['idVenta'];
  
  //----------------------------------------------------------------------

  if($dataID == null or $dataID == ""){
    
    header("Location:options.php?op=no_existe2");
    exit;

  }else{

    $fechaVenta         =   $array['rows'][1]['fecha'];
    $dateBill           =   strtotime($fechaVenta);
    $today              =   strtotime("now");
    $now                =   date("Y-m-d");
    $today              =   date_create($now); 
    $billDate           =   $array['rows'][1]['fecha'];
    $billDateService    =   date_create($billDate);
    $interval           =   date_diff($billDateService, $today);
    $days               =   $interval->format('%a');

    if($days > 5){

      echo "<script type='text/javascript'>window.location.href = 'options.php?limit=no'; </script>";
      exit;

    }
  }
}
//Begin foreach_0
foreach ($operacion as $key) {

  $saveOperation = mysql_query("INSERT INTO operacion_cliente (numeroOperacion, idCliente) 
                                VALUES ('$key', '$idclientes')");

}
//End foreach_0

//Guardar timbrado
//Begin foreach_1
foreach ($operacion as $keyData) {

 
  $getFolio = mysql_query("SELECT * FROM operacion_cliente WHERE numeroOperacion ='$keyData'")or die(mysql_error());
  $resOp    = mysql_fetch_array($getFolio);
  $folioID  =   $resOp['idOperacion'];

  //-----Cross domain a: ventas_general------------------------------------------------
  $url_sales = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$keyData";

  include('call-cross-domain.php');

}//end provisional foreach

  include('operations.php');
  include('call_impress.php');
  include('call_cfdi.php');    



foreach ($operacion as $keyOp) {
  //Guardar valores del timbrado generado
  $updateCResponse = mysql_query("UPDATE operacion_cliente 
                                  SET tfdTimbre           =   '$tfdTimbre',
                                  uuid                    =   '$uuid',
                                  fechaTimbrado           =   '$fechaTimbrado',
                                  selloCFD                =   '$selloCFD',
                                  numCertificadoSAT       =   '$numCertificadoSAT',
                                  selloSAT                =   '$selloSAT',
                                  schemaLocation          =   '$schemaLocation',
                                  xmlnsTFD                =   '$xmlnsTFD',
                                  xmlnsXSI                =   '$xmlnsXSI',
                                  email_enviado           =    '$email',
                                  idFacturacion           =    '$idFacturacion'
                                  WHERE numeroOperacion   =   '$keyOp'");
}
//End foreach_1



//XML Y PDF
include("../lib/convertidor_numero_letras/CNumeroaLetra.php");
$numalet= new CNumeroaletra;

include("../lib/pdf/mpdf.php");
$mpdf = new mPDF('c','A4', 5, 5, 5, 5, 5, 5);

//Begin foreach_2
foreach ($operacion as $keyXMLPDF) {
  
  //-----Cross domain a: ventas_general------------------------------------------------
  $url_sales = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$keyXMLPDF";
  include('call-cross-domain.php');


  
  $operationData    =   mysql_query("SELECT * FROM operacion_cliente 
                                     WHERE numeroOperacion ='$keyXMLPDF'");
  $resultOperation  =   mysql_fetch_array($operationData);
  $folio            =   $resultOperation['idOperacion'];

  $numalet->setNumero($total);
  $numalet->setMayusculas(1);
  $numalet->setMoneda("Pesos");
  $numalet->setPrefijo("");
  $numalet->setSufijo("");
  $nLetra = $numalet->letra()." M.N.";
   
  //valores del timbrado
  $tfdTimbre_pre         =   $resultOperation['tfdTimbre'];
  $uuid_pre              =   $resultOperation['uuid']; 
  $fechaTimbrado_pre     =   $resultOperation['fechaTimbrado']; 
  $selloCFD_pre          =   $resultOperation['selloCFD']; 
  $numCertificadoSAT_pre =   $resultOperation['numCertificadoSAT']; 
  $selloSAT_pre          =   $resultOperation['selloSAT'];
  $schemaLocation_pre    =   $resultOperation['schemaLocation']; 
  $xmlnsTFD_pre          =   $resultOperation['xmlnsTFD']; 
  $xmlnsXSI_pre          =   $resultOperation['xmlnsXSI']; 

  //Obteniendo contenido de las comillas
  $sat0 = preg_match('/"([^"]+)"/', $tfdTimbre_pre, $tfdTimbre);
  $sat1 = preg_match('/"([^"]+)"/', $uuid_pre, $uuid);
  $sat2 = preg_match('/"([^"]+)"/', $fechaTimbrado_pre, $fechaTimbrado);
  $sat3 = preg_match('/"([^"]+)"/', $selloCFD_pre, $selloCFD);
  $sat4 = preg_match('/"([^"]+)"/', $numCertificadoSAT_pre, $numCertificadoSAT);
  $sat5 = preg_match('/"([^"]+)"/', $selloSAT_pre, $selloSAT);
  $sat6 = preg_match('/"([^"]+)"/', $schemaLocation_pre, $schemaLocation);
  $sat7 = preg_match('/"([^"]+)"/', $xmlnsTFD_pre, $xmlnsTFD);
  $sat8 = preg_match('/"([^"]+)"/', $xmlnsXSI_pre, $xmlnsXSI);

  include('xml.php');
  include('pdf.php');
  

  $getRFC = mysql_query("SELECT * FROM clientes WHERE id_cliente ='$idclientes' LIMIT 1") or die(mysql_error());
  $resultrfc = mysql_fetch_array($getRFC);
  $rfc_factura       =   $resultrfc['rfc'];
   
  $updateXMLPDF = mysql_query("UPDATE operacion_cliente 
                               SET xml     =  '$namexml',
                               pdf         =  '$pathPDF',
                               rfc_factura =  '$rfc_factura' 
                               WHERE idCliente = '$idclientes' 
                               AND numeroOperacion = '$keyXMLPDF'");

  $url = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$keyXMLPDF";
  include('call-cross-domain.php');

  if($idventaServicio == null){
    header("Location:options.php?op=no_existe3");
    exit;
  }
 } 
  require_once("../lib/mail/class.phpmailer.php");
  require_once("../lib/mail/class.smtp.php");

  //require '../lib/mail/PHPMailerAutoload.php';

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

  $mail->FromName = iconv('UTF-8', 'ISO-8859-1',"Facturación GNU");
  $mail->Subject = iconv('UTF-8', 'ISO-8859-1', "Datos de facturación | Operación ".$idFacturacion);
  $mail->AddAddress($email , iconv('UTF-8', 'ISO-8859-1',"GNU")); 
  $body = iconv('UTF-8', 'ISO-8859-1',$txt);
  $mail->Body = $body;
  $mail->AddAttachment($pathXML);
  $mail->AddAttachment($fullPathPDF);
  $mail->IsHTML(true);
  $mail->Send();

  if (!$mail->Send()) {
    echo "<script type='text/javascript'>window.location.href = 'options.php?operacion=no_completada&email=$email'; </script>";
  }else{
    echo "<script type='text/javascript'>window.location.href = 'show-bills.php?op=completado'; </script>";
  }
?>