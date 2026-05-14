<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nombre'], $_POST['apellido'], $_POST['num_telef'], $_POST['email'], $_POST['dni'])) {

        include "./includes/conexion.php";

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telef = $_POST['num_telef'];
        $email = $_POST['email'];
        $dni = $_POST['dni'];

        if (empty($nombre) || empty($apellido) || empty($telef) || empty($email) || empty($dni)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
            exit;
        }

        $sql  = "INSERT INTO Propietario (nombre, apellido, num_telef, email, Dni) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssiss", $nombre, $apellido, $telef, $email, $dni);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Registro exitoso!'); window.location.href='./tabla_propietarios.php';</script>";
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
    header("Location: ./form_propietario.html");
    exit;
}
?>
