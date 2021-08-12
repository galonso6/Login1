<?php
session_start();

if (empty($_SESSION["correo"])) {
   
    header("Location: login.html");
  
    exit();
}
echo "BIENVENIDO.";

?>
<br>
<br>
<br>
<br>
<br>

<a href="logout.php">Salir</a>
