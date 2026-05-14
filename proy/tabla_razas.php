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
$fil_nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
$fil_tamaño = isset($_GET['tamaño']) ? trim($_GET['tamaño']) : '';
$fil_compor = isset($_GET['comportamiento']) ? trim($_GET['comportamiento']) : '';
$fil_vida = isset($_GET['vida']) ? trim($_GET['vida']) : '';

$condiciones = [];

if ($fil_nombre != '') $condiciones[] = "nombre LIKE '%$fil_nombre%'";
if ($fil_tamaño != '') $condiciones[] = "Tamaño_raza LIKE '%$fil_tamaño%'";
if ($fil_compor != '') $condiciones[] = "Comportamiento_raza LIKE '%$fil_compor%'";
if ($fil_vida != '') $condiciones[] = "esperanza_vida LIKE '%$fil_vida%'";

$sql = "SELECT * FROM razas";

if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY id_raza ASC";

$resultado = mysqli_query($conn, $sql);
$razas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

$hay_filtros = $fil_nombre != '' || $fil_tamaño != '' || $fil_compor != '' || $fil_vida != '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Razas</title>
</head>
<body>
    <h1>Razas</h1>

    <form method="GET" action="">
        <input type="text" name="nombre" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($fil_nombre) ?>">
        <input type="text" name="tamaño" placeholder="Buscar por tamaño..." value="<?= htmlspecialchars($fil_tamaño) ?>">
        <input type="text" name="comportamiento" placeholder="Buscar por comportamiento..." value="<?= htmlspecialchars($fil_compor) ?>">
        <input type="text" name="vida" placeholder="Buscar por esperanza vida..." value="<?= htmlspecialchars($fil_vida) ?>">
        <button type="submit">Buscar</button>
        <a href="./tabla_razas.php">Limpiar filtros</a>
    </form>

    <?php if ($hay_filtros): ?>
        <p><?= count($razas) ?> resultado(s) encontrado(s)</p>
    <?php endif; ?>

    <br>
    <a href="./form_raza.html">+ Añadir raza</a>
    <br><br>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'): ?>
        <p style="color:green;">Raza eliminada correctamente.</p>
    <?php endif; ?>
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado'): ?>
        <p style="color:green;">Raza actualizada correctamente.</p>
    <?php endif; ?>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Comportamiento</th>
            <th>Tamaño</th>
            <th>Peso</th>
            <th>Características</th>
            <th>Esperanza de vida</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (!empty($razas)):
            foreach ($razas as $fila):
        ?>
        <tr>
            <td><?= htmlspecialchars($fila['id_raza']) ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['Comportamiento_raza']) ?></td>
            <td><?= htmlspecialchars($fila['Tamaño_raza']) ?></td>
            <td><?= htmlspecialchars($fila['Peso_raza']) ?></td>
            <td><?= htmlspecialchars($fila['Caract_generales']) ?></td>
            <td><?= htmlspecialchars($fila['esperanza_vida']) ?></td>
            <td>
                <a href="./editar_raza.php?id=<?= $fila['id_raza'] ?>">Modificar</a> |
                <a href="./eliminar_raza.php?id_raza=<?= $fila['id_raza'] ?>" onclick="return confirm('¿Seguro que quieres eliminar esta raza?')">Eliminar</a>
            </td>
        </tr>
        <?php
            endforeach;
        else:
        ?>
        <tr><td colspan="8">No hay razas registradas.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
