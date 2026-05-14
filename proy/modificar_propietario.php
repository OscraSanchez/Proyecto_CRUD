<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id_propietario'];
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : $_POST['nombre_actual'];
    $apellido = !empty($_POST['apellido']) ? $_POST['apellido'] : $_POST['apellido_actual'];
    $telef = !empty($_POST['num_telef'])? $_POST['num_telef']: $_POST['telef_actual'];
    $email = !empty($_POST['email']) ? $_POST['email'] : $_POST['email_actual'];
    $dni = !empty($_POST['dni']) ? $_POST['dni'] : $_POST['dni_actual'];

    $sql  = "UPDATE Propietario SET nombre = ?, apellido = ?, num_telef = ?, email = ?, Dni = ? WHERE id_propietario = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssissi", $nombre, $apellido, $telef, $email, $dni, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ./tabla_propietarios.php?mensaje=actualizado");
        } else {
            echo "Error al actualizar: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($conn);
    }
}
?>
