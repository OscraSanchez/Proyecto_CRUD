<?php
session_start();
if(!isset ($_SESSION["usuario"])) {
    header("Location: ./login.html");
}

if($_SERVER["REQUEST METHOD"] == "POST"){

    if (isset($_POST['nombre']) && isset($_POST['chip']) && isset($_POST['tipo']) && isset($_POST['sexo']) && isset($_POST['raza']) && isset($_POST['peso']) && isset($_POST['tamaño']) && isset($_POST['comportamiento']) && isset($_POST['fecha']) && isset($_POST['veterinario']) && isset($_POST['propietario'])){
    include "includes/conexion.php";

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

        if(empty($nombre) || empty($chip) || empty($tipo) || empty($sexo) || empty($raza) || empty($peso) || empty($tamaño) || empty($comportamiento) || empty($fecha) || empty($veterinario) || empty($propietario)){
            echo "<script>alerts('Todos los campos son obligatorios');
            window.history.back();</script>";
        }

        $sql = "INSERT INTO mascotas (chip, tipo, sexo, raza, peso, tamaño, comportamiento, fecha, veterinario, propietario) VALUES ('$chip', '$tipo', '$sexo', '$raza', '$peso', '$tamaño', '$comportamiento', '$fecha', '$veterinario', '$propietario')";
        $resultado = mysqli_query($conn, $sql);

        if($resultado){ // si es que si
            mysqli_stmt_bind_param($resultado, issisiiisss, $chip, $nombre, $sexo, $tipo, $fecha, $raza, $propietario, $veterinario, $peso, $tamaño, $comportamiento);
        

            if (mysqli_stmt_execute($resultado)){
                echo "<script>alert('Registro exitoso!'); window.location.href='./tabla_mascotas'</script>";
            } else {
                echo "Error al registrar:" . mysqli_error($conn);
            }

            mysqli_stmt_close($result);
        } else {
            echo "Error al preparar la consulta:" . mysqli_error($conn);
        }
    } else {
        echo "Faltan datos en el formulario";
    }
} else {
   
    header("Location: ..(./XXX.html");
    exit;
}
?>