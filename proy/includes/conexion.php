<?php

include "config.php"; //incluye el contenido de config.php

$conn = mysqli_connect($servername, $usuario, $password, $dbname);

// Verificamos si la conexión ha sido estable
if (!$conn) {
    echo "<script>alert('Error de conexion')</script>";
    die("Error de conexion: " . mysqli_connect_error());
}

?>