<?php
session_start();
$_SESSION["usuario"] = 'Oscar';
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

$usuario_logeado = $_SESSION["usuario"];

// Filtros
$fil_tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
$fil_chip = isset($_GET['chip']) ? trim($_GET['chip']) : '';
$fil_nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
$fil_propietario = isset($_GET['propietario']) ? trim($_GET['propietario']) : '';
$fil_compor = isset($_GET['comportamiento']) ? trim($_GET['comportamiento']) : '';
$fil_fechaN = isset($_GET['fechaN']) ? trim($_GET['fechaN']) : '';
$fil_veter = isset($_GET['veter']) ? trim($_GET['veter']) : '';

$condiciones = [];

if ($fil_tipo != '') {
    $condiciones[] = "m.tipo LIKE '%$fil_tipo%'";
}
if ($fil_chip != '') {
    $condiciones[] = "m.Chip LIKE '%$fil_chip%'";
}
if ($fil_nombre != '') {
    $condiciones[] = "m.Nombre LIKE '%$fil_nombre%'";
}
if ($fil_propietario != '') {
    $condiciones[] = "p.nombre LIKE '%$fil_propietario%'";
}
if ($fil_compor != '') {
    $condiciones[] = "m.Comportamiento LIKE '%$fil_compor%'";
}
if ($fil_fechaN != '') {
    $condiciones[] = "m.Fecha LIKE '%$fil_fechaN%'";
}
if ($fil_veter != '') {
    $condiciones[] = "v.nombre LIKE '%$fil_veter%'";
}

$sql = "SELECT m.*, r.nombre as 'Raza', v.nombre as 'Veterinario', p.nombre as 'Propietario' FROM Mascotas m
        LEFT JOIN razas r ON m.id_Raza = r.id_raza
        LEFT JOIN veterinarios v ON m.id_veterinario = v.id_veterinario
        LEFT JOIN Propietario p  ON m.id_Propietario = p.id_propietario";

if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY m.Chip ASC";

$resultado = mysqli_query($conn, $sql);
$mascotas  = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

$hay_filtros = $fil_chip != '' || $fil_compor != '' || $fil_fechaN != '' || $fil_nombre != '' || $fil_propietario != '' || $fil_tipo != '' || $fil_veter != '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Mascotas</title>
</head>
<body>
    <h1>Mascotas</h1>

    <form method="GET" action="">
        <input type="text" name="chip" placeholder="Buscar por chip..." value="<?= htmlspecialchars($fil_chip) ?>">
        <input type="text" name="tipo" placeholder="Buscar por tipo..." value="<?= htmlspecialchars($fil_tipo) ?>">
        <input type="text" name="nombre" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($fil_nombre) ?>">
        <input type="text" name="propietario" placeholder="Buscar por propietario..." value="<?= htmlspecialchars($fil_propietario) ?>">
        <input type="text" name="comportamiento" placeholder="Buscar por comportamiento..." value="<?= htmlspecialchars($fil_compor) ?>">
        <input type="text" name="fechaN" placeholder="Buscar por fecha nacimiento..." value="<?= htmlspecialchars($fil_fechaN) ?>">
        <input type="text" name="veter" placeholder="Buscar por veterinario..." value="<?= htmlspecialchars($fil_veter) ?>">
        <button type="submit">Buscar</button>
        <a href="./tabla_mascotas.php">Limpiar filtros</a>
    </form>

    <?php if ($hay_filtros): ?>
        <p><?= count($mascotas) ?> resultado(s) encontrado(s)</p>
    <?php endif; ?>

    <br>
    <a href="./form_mascota.php">+ Añadir mascota</a>
    <br><br>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'): ?>
    <p style="color:green;">Propietario eliminado correctamente.</p>
    <?php endif; ?>
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado'): ?>
        <p style="color:green;">Propietario actualizado correctamente.</p>
    <?php endif; ?>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Chip</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Sexo</th>
            <th>Raza</th>
            <th>Propietario</th>
            <th>Peso</th>
            <th>Tamaño</th>
            <th>Comportamiento</th>
            <th>Fecha nacimiento</th>
            <th>Veterinario</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (!empty($mascotas)):
            foreach ($mascotas as $fila):
        ?>
        <tr>
            <td><?= htmlspecialchars($fila['id_mascota']) ?></td> <!-- htmlspecialchars convierte caracteres especiales HTML como <, >, ", & en sus equivalentes seguros (&lt;, &gt;) -->
            <td><?= htmlspecialchars($fila['Chip']) ?></td>
            <td><?= htmlspecialchars($fila['Nombre']) ?></td>
            <td><?= htmlspecialchars($fila['tipo']) ?></td>
            <td><?= htmlspecialchars($fila['Sexo']) ?></td>
            <td><?= htmlspecialchars($fila['Raza']) ?></td>
            <td><?= htmlspecialchars($fila['Propietario']) ?></td>
            <td><?= htmlspecialchars($fila['peso']) ?></td>
            <td><?= htmlspecialchars($fila['Tamaño']) ?></td>
            <td><?= htmlspecialchars($fila['Comportamiento']) ?></td>
            <td><?= htmlspecialchars($fila['Fecha']) ?></td>
            <td><?= htmlspecialchars($fila['Veterinario']) ?></td>
            <td>
                <a href="./editar_mascota.php?id=<?= $fila['id_mascota'] ?>">Modificar</a> |
                <a href="./eliminar_mascotas.php?id_mascota=<?= $fila['id_mascota'] ?>" onclick="return confirm('¿Seguro que quieres eliminar esta mascota?')">Eliminar</a>
            </td>
        </tr>
        <?php
            endforeach;
        else:
        ?>
        <tr><td colspan="13">No hay mascotas registradas.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
