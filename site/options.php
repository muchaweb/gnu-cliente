<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

include ("../lib/connect.php");
$link = Connect();

session_start();

//Get id of current user
$id			=	$_SESSION['id'];
$rfc		=	$_SESSION['rfc'];

if (!$_SESSION['status']) {      
    header("Location: ../");
    echo "...Regresando";
    exit;
}
include('expire-session.php');

//------------------------------------------------------------------------------------------------------------------

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
    <script src="../js/vendor/modernizr-2.7.1.min.js"></script>

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
		<div class="content-divisor col-md-push-2"></div>
		<div class="container col-md-push-3 col-md-6">
			<h2 class="title center">Facturación en línea</h2>
			<p class="blue center bottom">R.F.C.: <?php echo $rfc; ?></p>
			<?php 
				if($_GET['op'] == "no_existe"){
			?>
				<div class="alert alert-danger">
					<strong>Error.</strong> El número de operación no existe. Intente nuevamente.
				</div>
			<?php } ?>

			<?php 
				if($_GET['op'] == "facturado_anteriormente"){
			?>
				<div class="alert alert-danger">
					<strong>Error.</strong> El número de operación se ha facturado anteriormente.
				</div>
			<?php } ?>

            <?php 
                if($_GET['limit'] == "no"){
            ?>
                <div class="alert alert-danger">
                    <strong>Error.</strong> Ya han pasado más de 5 días naturales a partir de su fecha operación,
                    por lo que no es posible generar la factura actualmente.
                </div>
            <?php } ?>

            <?php 
                if($_GET['operacion'] == "no_completada"){
            ?>
                <div class="alert alert-danger">
                    <strong>Error.</strong> La facturación no se ha realizado correctamente, intente mas tarde.
                </div>
            <?php } ?>

			<?php 
				if($_GET['op'] == "completado"){
			?>
			<div class="alert alert-success">
				Operación completada, revise su correo.
			</div>
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title center">Seleccione una opción</h3>
				</div>
				<center>
					<div class="panel-body">
						  <div class="btn-group">
						    	<a href="bill.php" class="btn large btn-primary">Nueva captura</a>
						  </div>
						  <div class="btn-group ">
						    <a href="show-bills.php" class="btn large btn-primary" >Mis facturas</a>
						  </div>
					</div>
				 </center>
			</div>
		</div>
	</div>
</div>



















<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script src="../js/main.js"></script>

</body>

</html>