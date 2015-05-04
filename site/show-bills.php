<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");

$link = Connect();
session_start();
$idCliente		=	$_SESSION['id'];

if (!$_SESSION['status']) {      
    header("Location: ../");
    echo "...Regresando";
    exit;
}

include('expire-session.php');
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

$getRFC = mysql_query("SELECT * FROM clientes WHERE id_cliente ='$idCliente' LIMIT 1") or die(mysql_error());
$resultrfc = mysql_fetch_array($getRFC);
$rfc =  $resultrfc['rfc'];

 $bills = mysql_query("SELECT DISTINCT facturacion_cliente.email, 
 									   facturacion_cliente.idFacturacion, 
 									   operacion_cliente.idOperacion, 
 									   operacion_cliente.numeroOperacion, 
 									   operacion_cliente.xml,
 									   operacion_cliente.pdf,
 									   operacion_cliente.email_enviado
 							 	FROM facturacion_cliente
 								INNER JOIN operacion_cliente ON(operacion_cliente.idCliente = facturacion_cliente.idclientes) 
 								WHERE (operacion_cliente.rfc_factura = '$rfc') AND operacion_cliente.idCliente = '$idCliente'
 								GROUP BY operacion_cliente.idOperacion") or die(mysql_error());

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GNU | Facturación</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="../lib/fancybox/source/jquery.fancybox.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="wrapper">
		<header>
			<h1 class="logo center">
				<img src="../img/logo.png" width="150" alt="">
			</h1>
		</header>
		<div class="header-divisor"></div>

	<div class="main-body">
		<div class="container col-md-push-2 col-md-8">
			<h2 class="title center">Facturación en línea</h2>
			<?php 
				if($_GET['status_email'] == "no-sent"){
			?>
			<div class="alert alert-danger">
				<strong>Error.</strong> No se ha podido enviar el correo, intente nuevamente.
			</div>
			<?php }else if($_GET['status_email'] == "sent"){ ?>
			<div class="alert alert-success">
				<strong>Completado.</strong> Sus datos de facturación han sido enviados, favor de revisar su correo.
			</div>
			<?php } ?>

			<?php 
				if($_GET['op'] == "completado"){
			?>
			<div class="alert alert-success">
				Operación completada, revise su correo.
			</div>
			<?php } ?>
			
			<div class="">
			<p>
				<a href="logout.php"  class="btn btn-primary right-left"><i class="fa fa-sign-out"></i> Salir</a>
				<a href="bill.php" class="btn btn-medium btn-primary right-left  bottom"><i class="fa fa-plus"></i> Nueva captura</a>
				<a href="options.php" class="btn btn-medium btn-primary right bottom"><i class="fa fa-home"></i> Inicio</a>
				</p>
			<br><br><br>

				<table class="table table-bordered table-hover" id="example">
					<thead>
						<th><label for="" class="blue">FECHA</label></th>

						<th><label for="" class="blue">No. DE FACTURA</label></th>

						<th><label for="" class="blue">No. OPERACIÓN</label></th>

						<th><label for="" class="blue">MONTO</label></th>

						<th></th>

					</thead>

					<tbody>

					<?php 

					while($resultClient = mysql_fetch_array($bills)){

						$idFacturacion 	= 	$resultClient['idFacturacion'];
						$folio 			=  	$resultClient['idOperacion'];
						$file_pdf 		=  	"pdf/".$resultClient['pdf'];
						$file_xml 		=  	"xml".$resultClient['xml'];
						$total 			=	$resultClient['Total'];
						$operacion 		= 	$resultClient['numeroOperacion'];

						//-----Third cross domain------------------------------------------------
						$url = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$operacion";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_TIMEOUT, 200);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						$json_object = curl_exec($ch);
						curl_close($ch); 

						$array 	= json_decode($json_object, true);

						$fechaOperacion 		= $array['rows'][1]['fecha'];
						$totalVenta 			= $array['rows'][1]['subtotal'];

						//----------------------------------------------------------------------

					?>

						<tr>

							<td align="center"><p class="strong"><?php echo date("d-m-Y", strtotime($fechaOperacion)); ?></p></td>

							<td align="center"><p class="blue strong"><a href="<?php echo $file_pdf; ?>" class="fancybox fancybox.iframe"><?php echo $idFacturacion; ?></a></p></td>

							<td align="center"><p class="strong"><?php echo $operacion; ?></p></td>

							<td align="center"><p class="strong">$<?php echo number_format($totalVenta, 2); ?> MXN</p></td>

							<td align="center">

							<?php 


							$now 				= 	date("Y-m-d");

							$today 				= 	date_create($now); 

							$billDate 			= 	$resultTotal['Fecha'];

							$billDateService 	= 	date_create($billDate);

							$interval 			= 	date_diff($billDateService, $today);

							$days 				= 	$interval->format('%a');



							  if($days > 5){

								echo "<p class='blue strong'>No es posible facturar</p>";

								

							}else{

							?>

								<a title="Ver PDF" href="<?php echo $file_pdf; ?>" class="fancybox fancybox.iframe"><i class="space-right border space-left normal fa fa-eye"></i>PDF</a> 
								
								<a title="Descargar XML" href="download.php?f=<?php echo $file_xml; ?>"><i class="space-right border space-left normal fa fa-code"></i>XML</a> 

								<a title="Enviar Facturas" href="sent.php?id=<?php echo $folio; ?>&rfc=<?php echo $rfc; ?>"><i class="space-right border space-left normal fa fa-envelope"></i></a>

								<a title="Imprimir Factura" href="<?php echo $file_pdf; ?>" target="_blank"><i class="space-right border space-left normal fa fa-print"></i></a>

							<?php } ?>

							</td>

						</tr>

					<?php }  ?>

					</tbody>

				</table>

			</div>



			<p class="blue note">NOTA: Usted cuenta con 5 días naturales a partir de la fecha de operación para solicitar su factura.

			<br>Recuerde que la fecha de la factura no corresponde al día que es generada.</p>

		</div>

	</div>

</div>



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>

    jQuery(function ($) {

        $('#fecha').datepicker({dateFormat: 'dd-mm-yy'});

    });

</script>

<script type="text/javascript" language="javascript" src="../assets/datatables/jquery.dataTables.js"></script>

<script type="text/javascript" src="../assets/datatables/DT_bootstrap.js"></script>

<script src="../lib/fancybox/source/jquery.fancybox.pack.js"></script>

<script>
	$(document).ready(function () {
    $(".fancybox").fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        closeBtn: 'true',
        padding: 0,
        margin: 20
    });
});
</script>
</body>

</html>