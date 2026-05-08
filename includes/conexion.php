<?php
include "config.php";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    echo "<script>alert('No se puede conectar a la base de datos')</script>";
    die("Error de conexion: " . mysqli_connect_error());
}

?>