<?php

if(!isset ($_SESSION["usuario"])) {
    header("Location: ./login.html");
}
include "includes/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id_mascotas'];
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
    
    if (!(empty($nombre) || empty($chip) || empty($tipo) || empty($sexo) || empty($raza) || empty($peso) || empty($tamaño) || empty($comportamiento) || empty($fecha) || empty($veterinario) || empty($propietario))){
        if(is_string($raza)){
            $sql = "SELECT m.id_raza FROM mascotas m where r.name = $raza";
            $resultado = mysqli_query($conn, $sql);
            $razas = mysqli_fetch_all($resultado, MYSQL_ASSOC);
            foreach ($razas as  $fila){
                if($fila['raza'] == $raza){
                    $raza = $fila['id_raza'];
                }
            }
        }
        if(is_string($veterinario)){
            $sql = "SELECT v.id_veterinario FROM veterinarios v where v.nombre = $veterinario";
            $resultado = mysqli_query($conn, $sql);
            $veterinarios = mysqli_fetch_all($resultado, MYSQL_ASSOC);
            foreach ($veterinarios as  $fila){
                if($fila['veterinario'] == $veterinario){
                    $veterinario = $fila['id_vetrerinario'];
                }
            }
        }
        if(is_string($propietario)){
            $sql = "SELECT p.id_propietario FROM propietarios where p.nombre = $propietario";
            $resultado = mysqli_query($conn, $sql);
            $propietarios = mysqli_fetch_all($resultado, MYSQL_ASSOC);
            foreach ($propietarios as  $fila){
                if($fila['propietario'] == $propietario){
                    $propietario = $fila['id_propietario'];
                }
            }

        $sql = "UPDATE mascotas SET nombre = ?, chip = ?, tipo = ?, sexo = ?, raza = ?, peso = ?, tamaño = ?, comportamiento = ?, fecha = ?, veterinario = ?, propietario = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sissiisssis", $nombre, $chip, $tipo, $sexo, $raza, $peso, $tamaño, $comportamiento, $fecha, $veterinario, $propietario, $id);
        }
    }

    if (mysqli_stmt_execute($stmt)){
        header("Location: ./tabla_mascotas.php?mensaje=actualizado");
    } else {
        echo "Error al actualizar: " . mysqli_error($conn);
    }
}




?>