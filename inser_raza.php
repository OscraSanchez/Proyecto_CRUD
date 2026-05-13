<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nombre'], $_POST['comportamiento'], $_POST['tamaño'], $_POST['peso'], $_POST['caract'], $_POST['vida'])) {

        include "./includes/conexion.php";

        $nombre = $_POST['nombre'];
        $comportamiento = $_POST['comportamiento'];
        $tamaño = $_POST['tamaño'];
        $peso = $_POST['peso'];
        $caract = $_POST['caract'];
        $vida = $_POST['vida'];

        if (empty($nombre) || empty($comportamiento) || empty($tamaño) || empty($peso) || empty($caract) || empty($vida)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
            exit;
        }

        $sql  = "INSERT INTO razas (nombre, Comportamiento_raza, Tamaño_raza, Peso_raza, Caract_generales, esperanza_vida) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $comportamiento, $tamaño, $peso, $caract, $vida);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Registro exitoso!'); window.location.href='./tabla_razas.php';</script>";
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
    header("Location: ./form_raza.html");
    exit;
}
?>
