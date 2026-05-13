<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nombre'], $_POST['chip'], $_POST['tipo'], $_POST['sexo'], $_POST['raza'], $_POST['peso'], $_POST['tamaño'], $_POST['comportamiento'], $_POST['fecha'], $_POST['veterinario'], $_POST['propietario'])) {

        include "./includes/conexion.php";

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

        if (empty($nombre) || empty($chip) || empty($tipo) || empty($sexo) || empty($raza) || empty($peso) || empty($tamaño) || empty($comportamiento) || empty($fecha) || empty($veterinario) || empty($propietario)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
            exit;
        }

        $sql = "INSERT INTO Mascotas (Chip, Nombre, Sexo, tipo, id_Raza, peso, Tamaño, Comportaminto, Fecha, id_veterinario, id_Propietario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Tipos: s=Chip, s=Nombre, s=Sexo, s=tipo, i=id_Raza, d=peso, s=Tamaño, s=Comportamiento, s=Fecha, i=id_veterinario, i=id_Propietario
            mysqli_stmt_bind_param($stmt, "ssssissssii", $chip, $nombre, $sexo, $tipo, $raza, $peso, $tamaño, $comportamiento, $fecha, $veterinario, $propietario);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Registro exitoso!'); window.location.href='./tabla_mascotas.php';</script>";
            } else {
                echo "Error al registrar: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($conn);
        }

    } else {
        echo "Faltan datos en el formulario.";
    }

} else {
    // FIX: sintaxis de header corregida (estaba rota: "..(./XXX.html")
    header("Location: ./form_mascota.html");
    exit;
}
?>
