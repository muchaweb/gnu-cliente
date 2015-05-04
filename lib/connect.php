<?php 
date_default_timezone_set("Mexico/General");  
// error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(E_ALL ^ E_DEPRECATED);

// date_default_timezone_set('America/Mexico_City');
// error_reporting(0);

/*function Connect(){
  if (!($link=mysql_connect("192.168.1.69","root","berna"))) {
  echo "Error conectando a la base de datos.";
  exit();
  }

  if (!mysql_select_db("gnu_v3",$link)){
  echo "Error seleccionando la base de datos.";
  exit();
  }
  return $link;
  }*/
  function Connect(){
    if (!($link=mysql_connect("localhost","root",""))) {
    echo "Error conectando a la base de datos.";
    exit();
    }

    if (!mysql_select_db("gnu_v4",$link)){
    echo "Error seleccionando la base de datos.";
    exit();
    }
    return $link;
    }
  mysql_query("SET names UTF8");
  $link=Connect();

  mysql_close($link);
  ?>