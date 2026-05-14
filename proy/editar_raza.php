<?php
session_start();
$_SESSION["usuario"] = 'Oscar';
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

$id = $_GET['id'];

$sql      = "SELECT * FROM razas WHERE id_raza = '$id'";
$resultado = mysqli_query($conn, $sql);
$r        = mysqli_fetch_assoc($resultado);

if (!$r) {
    die("Error: No se encontró la raza con ID $id");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Raza</title>
</head>
<body>
    <h1>Editar Raza: <?php echo htmlspecialchars($r['nombre']); ?></h1>

    <form method="POST" action="./modificar_raza.php">

        <!-- Valores ocultos. Si no se modifica nada se usan estos valores -->
        <input type="hidden" name="id_raza"             value="<?php echo $id; ?>">
        <input type="hidden" name="nombre_actual"       value="<?php echo $r['nombre']; ?>">
        <input type="hidden" name="comportamiento_actual" value="<?php echo $r['Comportamiento_raza']; ?>">
        <input type="hidden" name="tamaño_actual"       value="<?php echo $r['Tamaño_raza']; ?>">
        <input type="hidden" name="peso_actual"         value="<?php echo $r['Peso_raza']; ?>">
        <input type="hidden" name="caract_actual"       value="<?php echo $r['Caract_generales']; ?>">
        <input type="hidden" name="vida_actual"         value="<?php echo $r['esperanza_vida']; ?>">

        <label>Nombre:
            <input type="text" name="nombre" placeholder="<?php echo $r['nombre']; ?>">
        </label><br><br>

        <label>Comportamiento:
            <input type="text" name="comportamiento" placeholder="<?php echo $r['Comportamiento_raza']; ?>">
        </label><br><br>

        <label>Tamaño:
            <select name="tamaño">
                <option value="">-- Sin cambios (<?php echo $r['Tamaño_raza']; ?>) --</option>
                <option value="Pequeño">Pequeño</option>
                <option value="Mediano">Mediano</option>
                <option value="Grande">Grande</option>
                <option value="Gigante">Gigante</option>
            </select>
        </label><br><br>

        <label>Peso (rango):
            <input type="text" name="peso" placeholder="<?php echo $r['Peso_raza']; ?>">
        </label><br><br>

        <label>Características generales:
            <input type="text" name="caract" placeholder="<?php echo $r['Caract_generales']; ?>">
        </label><br><br>

        <label>Esperanza de vida:
            <input type="text" name="vida" placeholder="<?php echo $r['esperanza_vida']; ?>">
        </label><br><br>

        <button type="submit">Guardar cambios</button>
        <a href="./tabla_razas.php">Cancelar</a>
    </form>
</body>
</html>
