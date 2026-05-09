<?php
session_start();
if(!isset ($_SESSION["usuario"])) {
    header("Location: ./login.html");
}

include "includes/conexion.php";

if (isset($_GET['id_mascota']) && is_numeric($_GET['id_mascota'])){
    $id = $_GET['id_mascota'];

    $sql = "DELETE FROM mascota WHERE id = ?";
    $resultado = mysqli_prepare($conn, $sql);

    if ($resultado){
        mysqli_stmt_bind_param($resultado, "i", $id);    // Unir parametros (i = entero)
    
        if (mysqli_stmt_execute($resultado)){
            header("Location: ./tabla_mascotas?mensaje=eliminado");
        } else {
            header("Location: ./tabla_mascotas?error=sql_error");
        }

        mysqli_stmt_close($resultado); // cerrar sentencia
    }
} else {"Location: ./tabla_mascotas?error=id_error";}

mysqli_close($conn);
?>