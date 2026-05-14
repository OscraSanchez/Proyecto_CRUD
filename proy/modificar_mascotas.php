<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Si el campo viene vacío, usamos el valor actual enviado
    $id = $_POST['id_masc'];
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : $_POST['nombre_actual'];
    $chip = !empty($_POST['chip']) ? $_POST['chip'] : $_POST['chip_actual'];
    $tipo = !empty($_POST['tipo']) ? $_POST['tipo'] : $_POST['tipo_actual'];
    $sexo = !empty($_POST['sexo']) ? $_POST['sexo'] : $_POST['sexo_actual'];
    $raza = !empty($_POST['raza']) ? $_POST['raza'] : $_POST['raza_actual'];
    $peso = !empty($_POST['peso']) ? $_POST['peso'] : $_POST['peso_actual'];
    $tamaño = !empty($_POST['tamaño']) ? $_POST['tamaño'] : $_POST['tamaño_actual'];
    $comportamiento = !empty($_POST['comportamiento']) ? $_POST['comportamiento'] : $_POST['comportamiento_actual'];
    $fecha = !empty($_POST['fecha']) ? $_POST['fecha'] : $_POST['fecha_actual'];
    $veterinario = !empty($_POST['veterinario']) ? $_POST['veterinario'] : $_POST['veterinario_actual'];
    $propietario = !empty($_POST['propietario']) ? $_POST['propietario'] : $_POST['propietario_actual'];


    $sql = "UPDATE Mascotas SET Nombre = ?, Chip = ?, tipo = ?, Sexo = ?, id_Raza = ?, peso = ?, Tamaño = ?, Comportamiento = ?, Fecha = ?, id_veterinario = ?, id_Propietario = ? WHERE id_mascota = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssidsssiii", $nombre, $chip, $tipo, $sexo, $raza, $peso, $tamaño, $comportamiento, $fecha, $veterinario, $propietario, $id);

        if (mysqli_stmt_execute($stmt)) {
             header("Location: ./tabla_mascotas.php?mensaje=actualizado");
        } else {
            echo "Error al actualizar: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($conn);
    }
}
?>