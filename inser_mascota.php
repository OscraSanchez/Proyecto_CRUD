<?php
session_start();
if(!isset ($_SESSION["usuario"])) {
    header("Location: ./login.html");
}

if($_SERVER["REQUEST METHOD"] == "POST"){

    if (isset($_POST['nombre']) && isset($_POST['chip']) && isset($_POST['tipo']) && isset($_POST['sexo']) && isset($_POST['raza']) && isset($_POST['peso']) && isset($_POST['tamaño']) && isset($_POST['comportamiento']) && isset($_POST['fecha']) && isset($_POST['veterinario']) && isset($_POST['propietario'])){
    include "includes/conexion.php";

    $nombre = $_POST['nombre'];
    $chip = $_POST['chip'];
    $tipo = $_POST['tipo'];
    $sexo = $_POST['sexo'];
    $raza = $_POST['raza'];
    $peso = $_POST['peso'];
    $tamaño = $_POST['tamaño'];
    $comportamiento = $_POST['comportamiento'];
    $fecha = $_POST['fecha'];
    $veterinario = $_POST['veterinario'];
    $propietario = $_POST['propietario'];

        if(empty($nombre) || empty($chip) || empty($tipo) || empty($sexo) || empty($raza) || empty($peso) || empty($tamaño) || empty($comportamiento) || empty($fecha) || empty($veterinario) || empty($propietario)){
            echo "<script>alerts('Todos los campos son obligatorios');
            window.history.back();</script>";
        }

        $sql = "INSERT INTO mascotas (chip, tipo, sexo, raza, peso, tamaño, comportamiento, fecha, veterinario, propietario) VALUES ('$chip', '$tipo', '$sexo', '$raza', '$peso', '$tamaño', '$comportamiento', '$fecha', '$veterinario', '$propietario')";
        $resultado = mysqli_query($conn, $sql);

        if($resultado){
            echo "";
        }
    }
}
?>