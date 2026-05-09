<?php

if(!isset ($_SESSION["usuario"])) {
    header("Location: ./login.html");
}
include "includes/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id_mascotas']
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
    
    if (!empty($password)){
        // Si el usuario escribió algo en el campopassword, lo hasheamos
        $pass_hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE alumnos SET nombre_completo = ?, usuario = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $nombre_completo, $usuario, $pass_hash, $id);
    } else {
        // Si no escribió nada, actualizamos solo el nombre y el usuario
        $sql = "UPDATE alumnos SET nombre_completo = ?, usuario = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $nombre_completo, $usuario, $id);
    }

    if (mysqli_stmt_execute($stmt)){
        header("Location: ../procesos/bienvenida.php?mensaje=actualizado");
    } else {
        echo "Error al actualizar: " . mysqli_error($conn);
    }
}




?>