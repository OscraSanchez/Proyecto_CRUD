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
$fil_apellido = isset($_GET['apellido']) ? trim($_GET['apellido']) : '';
$fil_email = isset($_GET['email']) ? trim($_GET['email']) : '';
$fil_dni = isset($_GET['dni']) ? trim($_GET['dni']) : '';
$fil_telef = isset($_GET['telef']) ? trim($_GET['telef']) : '';

$condiciones = [];

if ($fil_nombre != '') $condiciones[] = "nombre LIKE '%$fil_nombre%'";
if ($fil_apellido != '') $condiciones[] = "apellido LIKE '%$fil_apellido%'";
if ($fil_email != '') $condiciones[] = "email LIKE '%$fil_email%'";
if ($fil_dni != '') $condiciones[] = "Dni LIKE '%$fil_dni%'";
if ($fil_telef != '') $condiciones[] = "num_telef LIKE '%$fil_telef%'";

$sql = "SELECT * FROM Propietario";

if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY id_propietario ASC";

$resultado = mysqli_query($conn, $sql);
$propietarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

$hay_filtros = $fil_nombre != '' || $fil_apellido != '' || $fil_email != '' || $fil_dni != '' || $fil_telef != '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Propietarios</title>
</head>
<body>
    <h1>Propietarios</h1>

    <form method="GET" action="">
        <input type="text" name="nombre" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($fil_nombre) ?>">
        <input type="text" name="apellido" placeholder="Buscar por apellido..." value="<?= htmlspecialchars($fil_apellido) ?>">
        <input type="text" name="email" placeholder="Buscar por email..." value="<?= htmlspecialchars($fil_email) ?>">
        <input type="text" name="dni" placeholder="Buscar por DNI..." value="<?= htmlspecialchars($fil_dni) ?>">
        <input type="text" name="telef" placeholder="Buscar por teléfono..." value="<?= htmlspecialchars($fil_telef) ?>">
        <button type="submit">Buscar</button>
        <a href="./tabla_propietarios.php">Limpiar filtros</a>
    </form>

    <?php if ($hay_filtros): ?>
        <p><?= count($propietarios) ?> resultado(s) encontrado(s)</p>
    <?php endif; ?>

    <br>
    <a href="./form_propietario.html">+ Añadir propietario</a>
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
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>DNI</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (!empty($propietarios)):
            foreach ($propietarios as $fila):
        ?>
        <tr>
            <td><?= htmlspecialchars($fila['id_propietario']) ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
            <td><?= htmlspecialchars($fila['num_telef']) ?></td>
            <td><?= htmlspecialchars($fila['email']) ?></td>
            <td><?= htmlspecialchars($fila['Dni']) ?></td>
            <td>
                <a href="./editar_propietario.php?id=<?= $fila['id_propietario'] ?>">Modificar</a> |
                <a href="./eliminar_propietario.php?id_propietario=<?= $fila['id_propietario'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este propietario?')">Eliminar</a>
            </td>
        </tr>
        <?php
            endforeach;
        else:
        ?>
        <tr><td colspan="7">No hay propietarios registrados.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
