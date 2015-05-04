<body onload="window.print()" />

<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");
$link = Connect();

session_start();

$idCliente      =   $_SESSION['id'];

if (!$_SESSION['status']) {      
    header("Location: ../");
    echo "...Regresando";
    exit;
}

include('expire-session.php');
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

 $idFolio = $_REQUEST['id'];

 $bills = mysql_query("SELECT * FROM clientes WHERE id_cliente ='$idCliente' LIMIT 1") or die(mysql_error());
 $resultClient = mysql_fetch_array($bills);

 $razonSocial       =   $resultClient['razon_social'];
 $email             =   $resultClient['email'];
 $nombre            =   $resultClient['nombre'];
 $calle             =   $resultClient['calle'];
 $numExterior       =   $resultClient['num_exterior'];
 $numInterior       =   $resultClient['num_interior'];
 $tel               =   $resultClient['telefono'];
 $localidad         =   $resultClient['localidad'];
 $pais              =   $resultClient['pais'];
 $colonia           =   $resultClient['colonia'];
 $municipio         =   $resultClient['municipio'];
 $estado            =   $resultClient['estado'];
 $cp                =   $resultClient['cp'];
 $rfc               =   $resultClient['rfc'];




//Conocer el numero de operacion
$operationData     =   mysql_query("SELECT * FROM operacion_cliente 
                                    WHERE operacion_cliente.idOperacion ='$idFolio'") or die(mysql_error());
$resultOperation   =   mysql_fetch_array($operationData);

$numOp                = $resultOperation['numeroOperacion'];
$folio                = $resultOperation['idOperacion'];
$fechaExpedicion      = $resultOperation['fechaExpedicion'];
$tfdTimbre            = $resultOperation['tfdTimbre'];//version xml que inicie con <tfd:TimbreFiscalDigital
$uuid                 = $resultOperation['uuid']; //UUID
$fechaTimbrado        = $resultOperation['fechaTimbrado']; //FechaTimbrado
$selloCFD             = $resultOperation['selloCFD']; //Sello CFD
$numCertificadoSAT    = $resultOperation['numCertificadoSAT']; //Num certificado SAT
$selloSAT             = $resultOperation['selloSAT'];//Sello SAT
$schemaLocation       = $resultOperation['schemaLocation']; //schemaLocation
$xmlnsTFD             = $resultOperation['xmlnsTFD']; //xmlns:tfd
$xmlnsXSI             = $resultOperation['xmlnsXSI']; //xmlns:xsi

$tfdTimbre_pre         =   $resultOperation['tfdTimbre'];//version xml que inicie con <tfd:TimbreFiscalDigital 1
$uuid_pre              =   $resultOperation['uuid']; //UUID 2 
$fechaTimbrado_pre     =   $resultOperation['fechaTimbrado']; //FechaTimbrado 3 
$selloCFD_pre          =   $resultOperation['selloCFD']; //Sello CFD 4
$numCertificadoSAT_pre =   $resultOperation['numCertificadoSAT']; //Num certificado SAT 5
$selloSAT_pre          =   $resultOperation['selloSAT'];//Sello SAT 6
$schemaLocation_pre    =   $resultOperation['schemaLocation']; //schemaLocation 7
$xmlnsTFD_pre          =   $resultOperation['xmlnsTFD']; //xmlns:tfd 8
$xmlnsXSI_pre          =   $resultOperation['xmlnsXSI']; //xmlns:xsi9

//This extract content from double quotes " "
$sat0 = preg_match('/"([^"]+)"/', $tfdTimbre_pre, $tfdTimbre);
$sat1 = preg_match('/"([^"]+)"/', $uuid_pre, $uuid);
$sat2 = preg_match('/"([^"]+)"/', $fechaTimbrado_pre, $fechaTimbrado);
$sat3 = preg_match('/"([^"]+)"/', $selloCFD_pre, $selloCFD);
$sat4 = preg_match('/"([^"]+)"/', $numCertificadoSAT_pre, $numCertificadoSAT);
$sat5 = preg_match('/"([^"]+)"/', $selloSAT_pre, $selloSAT);
$sat6 = preg_match('/"([^"]+)"/', $schemaLocation_pre, $schemaLocation);
$sat7 = preg_match('/"([^"]+)"/', $xmlnsTFD_pre, $xmlnsTFD);
$sat8 = preg_match('/"([^"]+)"/', $xmlnsXSI_pre, $xmlnsXSI);

//--CROSS DOMAIN DATA--
  foreach ($operacion as $keyData) {

    //-----Cross domain a: ventas_general------------------------------------------------
    $url_sales = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$keyData";
    include('call-cross-domain.php');

  }//end provisional foreach
  include('operations.php');
 
//--END CROSS DOMAIN DATA--
 include("../lib/convertidor_numero_letras/CNumeroaLetra.php");

 $numalet= new CNumeroaletra;

 $numalet->setNumero($total);

 //cambia a minusculas
 $numalet->setMayusculas(1);

 //cambia moneda
 $numalet->setMoneda("Pesos");

 //cambia prefijo
 $numalet->setPrefijo("");

 //cambia sufijo
 $numalet->setSufijo("");

 //imprime numero con los cambios
 $nLetra = $numalet->letra()." M.N.";

/*
===========================================================

                            P D F

===========================================================
*/

$billPDF = '
<div class="row" style="padding-bottom: 0px;">

    <div class="col-xs-5">
        <img src="../img/logo3gas.jpg" width="150" alt=""/><br>
        <span class="">3EGASV S DE RL DE CV</span><br>
        <span class="">EGA100902M13</span><br>
        <span class="small palid-text">Periférico Paseo de la República No. 7875. 14 de Febrero</span><br>
        <span class="small palid-text">C.P.58147, Morelia, Michoacán</span><br>
    </div>

    <div class="col-xs-6">
            <table align="right">
                <tr> 
                    <td align="right"><span class="palid-text text-right" style="font-size:25px;">FACTURA</span></td> 
                </tr>
                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Folio</span>
                        <br>
                         <span class="palid-text text-right">'.$folio.'</span>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Folio fiscal</span><br>
                        <span class="palid-text text-right">'.$uuid[1].'</span>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Lugar de expedición</span><br>
                        <span class="palid-text text-right">Morelia, Michoacán de Ocampo</span>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Fecha de expedición</span><br>
                        <span class="palid-text text-right">'.$fechaExpedicion.'</span>
                    </td>
                </tr>
            </table>
    </div>
</div>

<div class="row" style="margin-top:20px;">
    <div class="col-xs-5">
        <span style="font-size:17px;">DATOS DEL CLIENTE</span>
        <div style="padding:10px 10px 10px 0; height:109px; font-size:14px;">
        '.$razonSocial.'<br>
        '.$rfc.'<br>
        '.$calle.' No. '.$numExterior.' Int. '.$numInterior.'<br>
        '.$colonia.','.$localidad.' C.P. '.$cp.'<br>
        '.$municipio.', '.$estado.'<br>
        </div>
    </div>

    <div class="col-xs-6" style="text-align:right;">
         <span style="font-size:17px;">CERTIFICADOS</span>
        <div style="height:100px; font-size:14px;" >
            <div style="padding: 5px; ">
                <strong>No.de certificado emisor</strong><br>
                <span>00001000000203345673</span> 
            </div>

            <div style="padding: 5px;">
                <strong>No. de certificado SAT</strong><br>
                <span>'.$numCertificadoSAT[1].'</span> 
            </div>

            <div style="padding: 5px;">
                <strong>Fecha de certificación</strong><br>
                <span>'.$fechaTimbrado[1].'</span>
            </div>           
      </div>
    </div>
    <div class="line"></div>
</div>

<div class="row">
    <div style="padding:10px;"> 
        <span style="font-size:17px;">DATOS DE LA FACTURA</span>
        <div class="line3"></div>
        <table style="width: 99%">
            <tr>
                <td align="" style="padding:10px; border: solid 3px white; width:110px; " class="">Cantidad</td>
                <td align="" style="padding:10px; border: solid 3px white; width:110px; " class="">U. de medida</td>
                <td align="" style="padding:10px; border: solid 3px white;" class="">Descripción</td>
                <td align="" style="padding:10px; border: solid 3px white; width:120px; " class="">P. por unidad</td>
                <td align="" style="padding:10px; border: solid 3px white; width:110px; " class="">Subtotal</td>
            </tr>
            <tr>
              <td align="" class="" style="padding: 10px; border: solid 3px white; height: 100px; vertical-align: top;">'.$volumen.'</td>
              <td align="" class="" style="padding: 10px; border: solid 3px white; height: 100px; vertical-align: top;">m3</td>
              <td align="" class="" style="padding: 10px; border: solid 3px white; height: 100px; vertical-align: top;">'.$concepto.'</td>
              <td align="" class="" style="padding: 10px; border: solid 3px white; height: 100px; vertical-align: top;">$'.$precioPorUnidad.'</td>
              <td align="" class="" style="padding: 10px; border: solid 3px white; height: 100px; vertical-align: top;">$'.$subtotal.'</td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div style="padding-left:13px;">    
        <table style="width: 99%">
            <tr>
                <td align="right" style="padding:5px; border: solid 3px white; width:100px;" class="">
                    <span style="text-align:left;">I.V.A.</span> $' . $iva . '</td>
            </tr>
            <tr>
                <td align="right" style="padding:5px; border: solid 3px white; width:100px;" class="">
                    <span style="text-align:left;">TOTAL</span> $'.$total.'</td>
            </tr>
            <tr>
                <td align="right" style="padding:5px; border: solid 3px white; width:100px; position:fixed;" class="">'.$nLetra.'</td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div style="padding:13px;">
        <table style="width: 99%">
            <tr>
                <td style="width:30px; padding-bottom:10px; font-size:17px;">INFORMACIÓN DEL PAGO</td>
                <td style="padding-bottom:10px; width:30px;"></td>
                <td align="" style="text-align:right; padding-bottom:10px; rder-left: solid 30px white; width:320px; font-size:17px;">OBSERVACIONES</td>
            </tr>
            <tr>
                <td align="" style="width:30px;" class="">
                    <strong>Forma de pago</strong> <br>
                    Pago en una sola exhibición
                </td>
                <td style="padding:5px; width:30px;" class=""></td>
                <td align="" style="padding:5px; border-left: solid 30px white; width:290px;" class="">'.$notas.'</td>
            </tr>
            <tr>
                <td align="" style="width:30px;" class="">
                    <strong>Método de pago</strong>
                    <br> Efectivo
                </td>
                <td align="" style="padding:5px; width:30px;" class=""></td>
                <td align="" style="padding:5px; border-left: solid 30px white; width:290px;" class=""></td>
            </tr>
            <tr>
                <td align="" style="width:30px;" class="">
                    <strong>Régimen fiscal</strong> 
                    <br>Regimen general de ley de personas morales
                </td>
                <td align="" style="padding:5px; width:30px;" class=""></td>
                <td align="" style="padding:5px; border-left: solid 30px white; width:290px;" class=""></td>
            </tr>
        </table>
    </div>
    <div class="line2"></div>
    <div class="line3"></div>
</div>

<div class="row">
    <div class="col-xs-3">
        <img src="../img/qr3gas.jpg"  alt=""/>
    </div>
    <div class="col-xs-8">
        <strong class="small">Cadena Original del Complemento de Certificación Digital del SAT</strong><br>
        <span class="small">
            ||' . $tfdTimbre[1] . '|' . $uuid[1] . '|' . $fechaTimbrado[1] . '|<br>' . $selloCFD[1] . '|' . $numCertificadoSAT[1] . '||
        </span><br>

        <strong class="small">Sello Digital del Emisor</strong>
        <span class="small ">
            '.$selloCFD[1].'
        </span><br>

        <strong class="small">Sello Digital del SAT</strong>
        <span class="small">
            '.$selloSAT[1].'
        </span><br>
    </div>
</div>

<span class="small">ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI</span>';

//==============================================================

//==============================================================

//==============================================================
include("../lib/pdf/mpdf.php");



$mpdf = new mPDF('c',   // mode - default ''
                        'A4',    // format - A4, for example, default ''
                        5,    // margin_left
                        5,    // margin right
                        5,    // margin top
                        5,    // margin bottom
                        5,     // margin header
                        5     // margin footer
                        );

$mpdf->SetJS('this.print();');
$stylesheet = file_get_contents('../css/pdf.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($billPDF, 2);
$mpdf->Output();
/*
===========================================================

                            P D F

===========================================================
*/

?>

</body>