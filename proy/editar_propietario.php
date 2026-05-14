<?php
session_start();
$_SESSION["usuario"] = 'Oscar';
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

$id = $_GET['id'];

$sql      = "SELECT * FROM Propietario WHERE id_propietario = '$id'";
$resultado = mysqli_query($conn, $sql);
$p        = mysqli_fetch_assoc($resultado);

if (!$p) {
    die("Error: No se encontró el propietario con ID $id");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propietario</title>
</head>
<body>
    <h1>Editar Propietario: <?php echo htmlspecialchars($p['nombre']); ?></h1>

    <form method="POST" action="./modificar_propietario.php">

        <!-- Valores ocultos. Si no se modifica nada se usan estos valores -->
        <input type="hidden" name="id_propietario"   value="<?php echo $id; ?>">
        <input type="hidden" name="nombre_actual"    value="<?php echo $p['nombre']; ?>">
        <input type="hidden" name="apellido_actual"  value="<?php echo $p['apellido']; ?>">
        <input type="hidden" name="telef_actual"     value="<?php echo $p['num_telef']; ?>">
        <input type="hidden" name="email_actual"     value="<?php echo $p['email']; ?>">
        <input type="hidden" name="dni_actual"       value="<?php echo $p['Dni']; ?>">

        <label>Nombre:
            <input type="text" name="nombre" placeholder="<?php echo $p['nombre']; ?>">
        </label><br><br>

        <label>Apellido:
            <input type="text" name="apellido" placeholder="<?php echo $p['apellido']; ?>">
        </label><br><br>

        <label>Teléfono:
            <input type="number" name="num_telef" placeholder="<?php echo $p['num_telef']; ?>">
        </label><br><br>

        <label>Email:
            <input type="email" name="email" placeholder="<?php echo $p['email']; ?>">
        </label><br><br>

        <label>DNI:
            <input type="text" name="dni" maxlength="9" placeholder="<?php echo $p['Dni']; ?>" disabled>
        </label><br><br>

        <button type="submit">Guardar cambios</button>
        <a href="./tabla_propietarios.php">Cancelar</a>
    </form>
</body>
</html>
