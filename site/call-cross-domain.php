<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_sales);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 200);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$json_object = curl_exec($ch);
curl_close($ch); 

//Variables
$array             			=   json_decode($json_object, true);

$fechaVenta        			=   $array['rows'][1]['fecha']; 
$descuento         			=   $array['rows'][1]['descuento']; 
$vehiculo          			=   $array['rows'][1]['vehiculo'];
$idventaServicio   			=   $array['rows'][1]["idVenta"];

$volumen_array         		+=  $array['rows'][1]['volumen'];
$precioPorUnidadConIVA   	=   $array['rows'][1]['precioUnitario']; //Siempre es unico
$subtotalIVA          		+=  $array['rows'][1]['subtotal'];

?>