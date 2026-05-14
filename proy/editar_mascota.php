<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

$id = $_GET['id'];

$sql = "SELECT m.*, r.nombre as 'Raza', v.nombre as 'Veterinario', p.nombre as 'Propietario' FROM Mascotas m
        LEFT JOIN razas r ON m.id_Raza = r.id_raza
        LEFT JOIN veterinarios v ON m.id_veterinario = v.id_veterinario
        LEFT JOIN Propietario p  ON m.id_Propietario = p.id_propietario
        WHERE m.id_mascota = '$id';";

$resultado = mysqli_query($conn, $sql);
$m = mysqli_fetch_assoc($resultado);

if (!$m) {
    die("Error: No se encontró la mascota con ID $id_a_editar");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Mascota</title>
</head>
<body>
    <h1>Editar Mascota: <?php echo htmlspecialchars($m['Nombre']); ?></h1>
    
    <form method="POST" action="./modificar_mascotas.php">

        <!-- Valores ocultos. Si no se modifica nada se usan estos valores -->
        <input type="hidden" name="id_masc" value="<?php echo $id; ?>">
        <input type="hidden" name="nombre_actual" value="<?php echo $m['Nombre']; ?>">
        <input type="hidden" name="chip_actual" value="<?php echo $m['Chip']; ?>">
        <input type="hidden" name="tipo_actual" value="<?php echo $m['tipo']; ?>">
        <input type="hidden" name="sexo_actual" value="<?php echo $m['Sexo']; ?>">
        <input type="hidden" name="raza_actual" value="<?php echo $m['id_Raza']; ?>">
        <input type="hidden" name="peso_actual" value="<?php echo $m['peso']; ?>">
        <input type="hidden" name="tamaño_actual" value="<?php echo $m['Tamaño']; ?>">
        <input type="hidden" name="comportamiento_actual" value="<?php echo $m['Comportamiento']; ?>">
        <input type="hidden" name="fecha_actual" value="<?php echo $m['Fecha']; ?>">
        <input type="hidden" name="veterinario_actual" value="<?php echo $m['id_veterinario']; ?>">
        <input type="hidden" name="propietario_actual" value="<?php echo $m['id_Propietario']; ?>">

        <label>Nombre: 
            <input type="text" name="nombre" placeholder="<?php echo $m['Nombre']; ?>">
        </label><br><br>

        <label>Chip: 
            <input type="text" name="chip" maxlength="15" placeholder="<?php echo $m['Chip']; ?>" disabled>
        </label><br><br>

        <label>Tipo:
            <select name="tipo" disabled>
                <option value=""><?php echo $m['tipo']; ?></option>
                <option value="Perro">Perro</option>
                <option value="Gato">Gato</option>
                <option value="Conejo">Conejo</option>
            </select>
        </label><br><br>

        <label>Sexo:
            <select name="sexo" disabled>
                <option value=""><?php echo $m['Sexo'] == 'M' ? 'Macho' : 'Hembra'; ?></option>
                <option value="M">Macho</option>
                <option value="F">Hembra</option>
            </select>
        </label><br><br>

        <label>ID Raza: 
            <input type="number" name="raza" placeholder="<?php echo $m['Raza']; ?>" disabled>
        </label><br><br>

        <label>Peso (kg): 
            <input type="number" step="0.01" name="peso" placeholder="<?php echo $m['peso']; ?>">
        </label><br><br>

        <label>Tamaño:
            <select name="tamaño">
                <option value="">-- Sin cambios (<?php echo $m['Tamaño']; ?>) --</option>
                <option value="Pequeño">Pequeño</option>
                <option value="Mediano">Mediano</option>
                <option value="Grande">Grande</option>
                <option value="Gigante">Gigante</option>
            </select>
        </label><br><br>

        <label>Comportamiento: 
            <input type="text" name="comportamiento" placeholder="<?php echo $m['Comportamiento']; ?>">
        </label><br><br>

        <label>Fecha nacimiento: 
            <input type="date" name="fecha" placeholder="<?php echo $m['Fecha']; ?>" disabled>
        </label><br><br>

        <label>Veterinario: 
            <select name="veterinario">
                <option value="">-- <?php echo $m['Veterinario']; ?> --</option>
                <?php
                    $sql_veterinario = "SELECT id_veterinario, nombre FROM veterinarios";
                    $res_veterinario = mysqli_query($conn, $sql_veterinario);
                    $filas_vet = mysqli_fetch_all($res_veterinario, MYSQLI_ASSOC);
                    foreach ($filas_vet as $fila) {
                        echo "<option value='{$fila['id_veterinario']}'>{$fila['nombre']} - {$fila['id_veterinario']} </option>";
                    }
                ?>
            </select>
        </label> <br><br>

        <label>ID Propietario: 
            <select name="propietario">
                <option value="">-- <?php echo $m['Propietario']; ?> --</option>
                <?php
                    $sql_propietario = "SELECT id_propietario, nombre FROM propietario";
                    $res_propietario = mysqli_query($conn, $sql_propietario);
                    $filas_pro = mysqli_fetch_all($res_propietario, MYSQLI_ASSOC);
                    foreach ($filas_pro as $fila) {
                        echo "<option value='{$fila['id_propietario']}'>{$fila['nombre']} - {$fila['id_propietario']} </option>";
                    }
                ?>
            </select>
        </label> <br><br>

        <button type="submit">Guardar cambios</button>
        <a href="./tabla_mascotas.php">Cancelar</a>
    </form>
</body>
</html>