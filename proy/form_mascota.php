<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Mascota</title>
</head>
<body>
    <h1>Añadir Mascota</h1>
    <form method="POST" action="./inser_mascota.php">

        <label>Nombre: <input type="text" name="nombre" required></label><br><br>
        <label>Chip: <input type="text" name="chip" maxlength="15" required></label><br><br>

        <label>Tipo:
            <select name="tipo" required>
                <option value="">-- Selecciona --</option>
                <option value="Perro">Perro</option>
                <option value="Gato">Gato</option>
                <option value="Conejo">Conejo</option>
            </select>
        </label><br><br>

        <label>Sexo:
            <select name="sexo" required>
                <option value="">-- Selecciona --</option>
                <option value="M">Macho</option>
                <option value="F">Hembra</option>
            </select>
        </label><br><br>

        <label>ID Raza: 
            <select name="raza">
                <option value="">-- Selecciona --</option>
                <?php
                    $sql_raza = "SELECT id_raza, nombre FROM razas";
                    $res_raza = mysqli_query($conn, $sql_raza);
                    $filas_raza = mysqli_fetch_all($res_raza, MYSQLI_ASSOC);
                    foreach ($filas_raza as $fila) {
                        echo "<option value='{$fila['id_raza']}'>{$fila['nombre']} - {$fila['id_raza']} </option>";
                    }
                ?>
            </select>
        </label><br><br>

        <label>Peso (kg): <input type="number" step="0.01" name="peso" required></label><br><br>

        <label>Tamaño:
            <select name="tamaño" required>
                <option value="">-- Selecciona --</option>
                <option value="Pequeño">Pequeño</option>
                <option value="Mediano">Mediano</option>
                <option value="Grande">Grande</option>
                <option value="Gigante">Gigante</option>
            </select>
        </label><br><br>

        <label>Comportamiento: <input type="text" name="comportamiento" required></label><br><br>
        <label>Fecha nacimiento: <input type="date" name="fecha" required></label><br><br>

        <!-- Veterinario y propietario: introduce el id numérico -->
        <label>ID Veterinario: 
            <select name="propietario">
                <option value="">-- Selecciona --</option>
                <?php
                    $sql_veterinario = "SELECT id_veterinario, nombre FROM veterinarios";
                    $res_veterinario = mysqli_query($conn, $sql_veterinario);
                    $filas_vet = mysqli_fetch_all($res_veterinario, MYSQLI_ASSOC);
                    foreach ($filas_vet as $fila) {
                        echo "<option value='{$fila['id_veterinario']}'>{$fila['nombre']} - {$fila['id_veterinario']} </option>";
                    }
                ?>
            </select>
        </label><br><br>
        <label>ID Propietario: 
            <select name="veterinario">
                <option value="">-- Selecciona --</option>
                <?php
                    $sql_propietario = "SELECT id_propietario, nombre FROM propietario";
                    $res_propietario = mysqli_query($conn, $sql_propietario);
                    $filas_propietario = mysqli_fetch_all($res_propietario, MYSQLI_ASSOC);
                    foreach ($filas_propietario as $fila) {
                        echo "<option value='{$fila['id_propietario']}'>{$fila['nombre']} - {$fila['id_propietario']} </option>";
                    }
                ?>
            </select>
        </label><br><br>

        <button type="submit">Guardar mascota</button>
        <a href="./tabla_mascotas.php">Cancelar</a>
    </form>
</body>
</html>
