<?php 
mysql_query ("set character_set_client='utf8'");
mysql_query ("set character_set_results='utf8'");
mysql_query ("set collation_connection='utf8_general_ci'");
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");

$link = Connect();
session_start();

//Get id of current user
$id		=	$_SESSION['id'];

if (!$_SESSION['status']) {      
	header("Location: ../");
	echo "...Regresando";
	exit;
}

include('expire-session.php');
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

$bills = mysql_query("SELECT * FROM clientes WHERE id_cliente ='$id' LIMIT 1") or die(mysql_error());
$result = mysql_fetch_array($bills);

$razonSocial 	= 	$result['razon_social'];
$rfc 			= 	$result['rfc'];
$email 			=	$result['email'];
$nombre 		=	$result['nombre'];
$calle 			=	$result['calle'];
$numExterior 	=	$result['num_exterior'];
$numInterior 	=	$result['num_interior'];
$tel 			=	$result['telefono'];
$localidad 		=	$result['localidad'];
$pais 			=	$result['pais'];
$colonia 		=	$result['colonia'];
$municipio 		=	$result['municipio'];
$estado 		=	$result['estado'];
$cp 			=	$result['cp'];
//-----------------------------------------------------------------
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

				

				<button id="btn-remove" class="btn btn-sm btn-primary">- Quitar operación</button> 
				<button id="btn-add" class="btn btn-sm btn-primary">+ Agregar operación</button>
				
				<form class="form-horizontal" method="post" action="saveBill.php" id="new-bill" role="form">
					<div class="form-inline bottom" role="form" >
						<div class="form-group">
							<div id="inputs"></div>							
						</div>

						<div class="form-group right">
							<a href="options.php"  class="btn btn-primary"><i class="fa fa-home"></i> Inicio</a>
							<a href="show-bills.php"  class="btn btn-primary"><i class="fa fa-paperclip"></i> Mis facturas</a>
							<a href="logout.php"  class="btn btn-primary"><i class="fa fa-sign-out"></i> Salir</a>
						</div>
					</div>

					<?php 
						if($_GET['conceptos'] == "error"){

							$compresion_concepto = explode(",", $_GET['n']);
							$comprimido_concepto = explode(",", $_GET['m']);
					?>
						<div class="alert alert-danger">
							<h4>Error. Las siguientes operaciones contienen conceptos diferentes.</h4>
							<ul>
							<?php foreach($compresion_concepto as $compresion){ ?>
								<li>- <?php echo "<strong>".$compresion."</strong>: Compresión de Gas Natural."; ?></li>
							<?php } ?>
							<?php foreach($comprimido_concepto as $comprimido){ ?>
								<li>- <?php echo "<strong>".$comprimido."</strong>: Gas Natural Comprimido."; ?></li>
							<?php } ?>
							</ul>
							<h5>Sólo puede facturar un concepto a la vez.</h5>
						</div>
					<?php } ?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title center">Verifique sus datos</h3>
						</div>
						<div class="panel-body center">
							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">RFC</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="rfc" name="rfc" disabled="disabled" value="<?php echo $rfc; ?>">
								</div>
							</div>
							<!--HIDDEN-->

							<input type="hidden" name="idclientes" value="<?php echo $id; ?>">

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">*RAZÓN SOCIAL</label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="razonSocial" name="razonSocial" value="<?php echo $razonSocial ?>">
								</div>
							</div>

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">NOMBRE</label>
								<div class="col-md-9">
									<input type="text" class="form-control"  id="nombre" name="nombre" value="<?php echo $nombre; ?>">
								</div>
							</div>

							<div class="form-group bottom">										
								<label for="" class="col-md-2 blue">CALLE</label>
								<div class="col-md-9">
									<input type="text" class="form-control"  id="calle" name="calle" value="<?php echo $calle; ?>">
								</div>
							</div>

							<div class="form-group bottom">
							    <label for="" class="col-md-2 blue">NÚMERO EXTERIOR</label>
							    <div class="col-md-4">
							        <input type="text" class="form-control"  id="numExterior" name="numExterior" value="<?php echo $numExterior ?>">
							    </div>

							    <label for="" class="col-md-1 blue">NÚMERO INTERIOR</label>
							    <div class="col-md-4">
							        <input type="text" class="form-control"  id="numInterior" name="numInterior" value="<?php echo $numInterior ?>">
							    </div>
							</div>

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">LOCALIDAD</label>
								<div class="col-md-4">
									<input type="text" class="form-control"  id="localidad" name="localidad" value="<?php echo $localidad ?>">
								</div>

								<label for="" class="col-md-1 blue">PAÍS</label>
								<div class="col-md-4 ">
									<input type="text" class="form-control"  id="pais" name="pais" value="<?php echo $pais; ?>">
								</div>
							</div>

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">COLONIA</label>
								<div class="col-md-4">
									<input type="text" class="form-control"  id="colonia " name="colonia" value="<?php echo $colonia; ?>">
								</div>

								<label for="" class="col-md-1 blue">MUNICIPIO</label>
								<div class="col-md-4 ">
									<input type="text" class="form-control"  id="municipio" name="municipio" value="<?php echo $municipio; ?>">
								</div>
							</div>

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">ESTADO</label>
								<div class="col-md-4">
									<input type="text" class="form-control"  id="estado" name="estado" value="<?php echo $estado; ?>">
								</div>

								<label for="" class="col-md-1 blue">C.P.</label>
								<div class="col-md-4 ">
									<input type="text" class="form-control"  id="cp" name="cp" value="<?php echo $cp ?>">
								</div>
							</div>
							
							<div class="form-group bottom">
							    <label for="" class="col-md-2 blue">TELÉFONO</label>
							    <div class="col-md-9">
							        <input type="text" class="form-control"  id="tel" name="tel" value="<?php echo $tel; ?>">
							    </div>
							</div>

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">*EMAIL</label>
								<div class="col-md-4">
									<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
								</div>
							</div>

							<div class="form-group bottom">
								<label for="" class="col-md-2 blue">*CONFIRMAR EMAIL</label>
								<div class="col-md-4">
									<input type="email" class="form-control" id="confirmaEmail" required name="confirmaEmail" autocomplete="off" onpaste="return false">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-9">
									<button type="submit" class="top btn btn-primary btn-lg large">FACTURAR</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<p class="blue note">NOTA: Usted cuenta con 5 días naturales a partir de la fecha de operación para solicitar su factura.
					<br>Recuerde que la fecha de la factura no corresponde al día que es generada.
					<br>Los campos marcados con * son obligatorios</p>
				</div>
			</div>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
		<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="../js/main.js"></script>
		<script src="../js/script.js"></script>
			</body>
			</html>