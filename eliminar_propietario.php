<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

if (isset($_GET['id_propietario']) && is_numeric($_GET['id_propietario'])) {
    $id = (int)$_GET['id_propietario'];

    $sql  = "DELETE FROM Propietario WHERE id_propietario = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ./tabla_propietarios.php?mensaje=eliminado");
        } else {
            header("Location: ./tabla_propietarios.php?error=sql_error");
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: ./tabla_propietarios.php?error=prepare_error");
    }
} else {
    header("Location: ./tabla_propietarios.php?error=id_error");
}

mysqli_close($conn);
?>
