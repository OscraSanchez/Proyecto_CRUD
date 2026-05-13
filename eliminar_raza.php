<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

if (isset($_GET['id_raza']) && is_numeric($_GET['id_raza'])) {
    $id = (int)$_GET['id_raza'];

    $sql  = "DELETE FROM razas WHERE id_raza = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ./tabla_razas.php?mensaje=eliminado");
        } else {
            header("Location: ./tabla_razas.php?error=sql_error");
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: ./tabla_razas.php?error=prepare_error");
    }
} else {
    header("Location: ./tabla_razas.php?error=id_error");
}

mysqli_close($conn);
?>
