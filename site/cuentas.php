<?php 
$volumen           			=   2.30;
$precioPorUnidadConIVA   	=   1000;
$precioPorUnidadSinIVA      =   ($precioPorUnidadConIVA/1.16);

$subtotal 		      		=   number_format(($precioPorUnidadSinIVA * $volumen),2);

echo "volumen: ".$volumen;
echo "<br>ppu iva: ".$precioPorUnidadConIVA;
echo "<br>ppu sin iva: ".$precioPorUnidadSinIVA;
echo "<br>";
echo $subtotal;

echo $total 			  = number_format(($subtotal * 1.16),2);


?>