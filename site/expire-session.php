<?php 
$time = 1800; //segundos
if(isset($_SESSION["status"])){ 
  if(isset($_SESSION["expire"]) && time() > $_SESSION["expire"] + $time){ 
    unset($_SESSION["expire"]); 
    session_destroy();
    echo "<script type='text/javascript'>window.location.href = '../'; </script>";
  }else{ 
    $_SESSION["expire"] = time(); 
  } 
} 
?>