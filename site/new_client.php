<?php 
//-----------------------------------------------CONEXIÓN Y SESIÓN--------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
include ("../lib/connect.php");
$link = Connect();

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
                <div class="message"></div>
                <form class="form-horizontal" method="post" action="saveClient.php" id="new-customer" role="form">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title center">Registro de nuevo cliente</h3>
                        </div>
                        <div class="panel-body center">
                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">RFC</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="rfc" name="rfc">
                                </div>
                            </div>
                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">*RAZÓN SOCIAL</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="razonSocial" name="razonSocial">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">NOMBRE</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"  id="nombre" name="nombre">
                                </div>
                            </div>

                            <div class="form-group bottom">                                     
                                <label for="" class="col-md-2 blue">CALLE</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"  id="calle" name="calle">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">NÚMERO EXTERIOR</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control"  id="numExterior" name="numExterior">
                                </div>

                                <label for="" class="col-md-1 blue">NÚMERO INTERIOR</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control"  id="numInterior" name="numInterior">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">LOCALIDAD</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control"  id="localidad" name="localidad">
                                </div>

                                <label for="" class="col-md-1 blue">PAÍS</label>
                                <div class="col-md-4 ">
                                    <input type="text" class="form-control"  id="pais" name="pais">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">COLONIA</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control"  id="colonia " name="colonia">
                                </div>

                                <label for="" class="col-md-1 blue">MUNICIPIO</label>
                                <div class="col-md-4 ">
                                    <input type="text" class="form-control"  id="municipio" name="municipio">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">ESTADO</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control"  id="estado" name="estado">
                                </div>

                                <label for="" class="col-md-1 blue">C.P.</label>
                                <div class="col-md-4 ">
                                    <input type="text" class="form-control"  id="cp" name="cp">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">TELÉFONO</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"  id="tel" name="tel">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">*EMAIL</label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>

                            <div class="form-group bottom">
                                <label for="" class="col-md-2 blue">*CONFIRMAR EMAIL</label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" id="confirmaEmail" name="confirmaEmail" autocomplete="off" onpaste="return false">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-9">
                                    <button type="submit" class="top btn btn-primary btn-lg large" onclick="return validateRFC()">REGISTRAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="blue note">NOTA: Los campos marcados con * son obligatorios</p>
            </div>
        </div>
    </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../js/main.js"></script>
    </body>
</html>