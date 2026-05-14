<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id_raza'];
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : $_POST['nombre_actual'];
    $comportamiento = !empty($_POST['comportamiento']) ? $_POST['comportamiento'] : $_POST['comportamiento_actual'];
    $tamaño = !empty($_POST['tamaño']) ? $_POST['tamaño'] : $_POST['tamaño_actual'];
    $peso = !empty($_POST['peso']) ? $_POST['peso'] : $_POST['peso_actual'];
    $caract = !empty($_POST['caract']) ? $_POST['caract'] : $_POST['caract_actual'];
    $vida = !empty($_POST['vida']) ? $_POST['vida'] : $_POST['vida_actual'];

    $sql  = "UPDATE razas SET nombre = ?, Comportamiento_raza = ?, Tamaño_raza = ?, Peso_raza = ?, Caract_generales = ?, esperanza_vida = ? WHERE id_raza = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $comportamiento, $tamaño, $peso, $caract, $vida, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ./tabla_razas.php?mensaje=actualizado");
        } else {
            echo "Error al actualizar: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($conn);
    }
}
?>
