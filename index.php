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

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<div class="wrapper">
		<header>
			<h1 class="logo center">
				<img src="img/logo.png" width="150" alt="">
			</h1>
		</header>
		<div class="header-divisor"></div>

	<div class="main-body">
		<div class="container col-md-push-3 col-md-6">
			<h2 class="title center">Facturación en línea</h2>
			<?php 
				if($_GET['access'] == "false"){
					$alertClass = "has-error";
			?>

			<div class="alert alert-danger">
				<div class="col-md-1 icon">
					<i class="fa fa-exclamation-circle"></i>
				</div>
				<strong>Lo sentimos.</strong> Los datos ingresados no aparecen en nuestros registros.
				<br>Revise la información e intente de nuevo.
			</div>

			<?php 
				}else if($_GET['register'] == "error"){
					$alertClass = "has-error";
			?>

			<div class="alert alert-danger">
				<div class="col-md-1 icon">
					<i class="fa fa-exclamation-circle"></i>
				</div>
				<strong>Lo sentimos.</strong> Ha ocurrido algo inusual.
				<br>Intente nuevamente.
			</div>

			<?php 
				}else if($_GET['register'] == "ok"){
			?>
			
			<div class="alert alert-success">
				<div class="col-md-1 icon">
					<i class="fa fa-check-circle"></i>
				</div>
				<strong>Gracias.</strong> Se ha registrado a nuestro sistema.
				<br>Puede realizar su proceso de facturación a continuación.
			</div>

			<?php }else{ ?>
			<div class="well">
				<p>Este servicio te permite consultar, imprimir y descargar tu factura electrónica,</p>
				<p>la cual tiene validez fiscal para utilizarla en cualquier trámite administrativo.</p>
			</div>
			<?php } ?>
			<div class="message"></div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title center">Ingrese sus datos</h3>
				</div>
				<div class="panel-body center">
					<form class="form-inline" action="login.php" method="post" role="form" id="login-in">
					  <div class="form-group <?php echo $alertClass; ?>">
					    <input type="text" class="form-control" name="rfc" id="rfc" placeholder="R.F.C.">
					  </div>
					  <button type="submit" class="btn btn-primary" onclick="return validateRFC()">Continuar</button>
					</form>
				</div>
			</div>
			<p class="blue note">NOTA: Usted cuenta con 5 días posteriores a su operación para realizar la facturación por este medio.</p>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>