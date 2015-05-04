<?php 
$compresion = array();
$comprimido = array();

foreach ($operacion  as $operacionConcepto) {
	$url_chip = "http://gnuvehicular.mine.nu:8580/ventas_general.php?operacion=$operacionConcepto";
	
	$ch_1 = curl_init();
	curl_setopt($ch_1, CURLOPT_URL, $url_chip);
	curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch_1, CURLOPT_TIMEOUT, 200);
	curl_setopt($ch_1, CURLOPT_SSL_VERIFYPEER, false);
	$json_object_1 = curl_exec($ch_1);
	curl_close($ch_1); 

	//Variables
	$array_1   =   json_decode($json_object_1, true);
	$chip   =   $array_1['rows'][1]['vehiculo'];

	$knowConcept_2 = mysql_query("SELECT * FROM chips WHERE chip = '$chip'");
	$count_1 = mysql_num_rows($knowConcept_2);

	if($count_1 > 0){
	   array_push($compresion, $operacionConcepto);
	}else{
		array_push($comprimido, $operacionConcepto);
	}

}//End foreach
foreach ($compresion as $value) {
	$data .= $value.",";
}

$data = trim($data, ",");

foreach ($comprimido as $value_2) {
	$data_2 .= $value_2.",";
}

$data_2 = trim($data_2, ",");

if((count($compresion) > 0) && (count($comprimido) > 0)){
	header("Location:bill.php?conceptos=error&n=".$data."&m=".$data_2);
	exit;
}
elseif (count($compresion) > 0) {
	$concepto_original = "COMPRESION DE GAS NATURAL";
}elseif(count($comprimido) > 0){
	$concepto_original = "GAS NATURAL COMPRIMIDO";
}

?>