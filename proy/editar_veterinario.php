<?php
session_start();
$_SESSION["usuario"] = 'Oscar';
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.html");
    exit;
}

include "./includes/conexion.php";

$id = $_GET['id'];

$sql      = "SELECT * FROM veterinarios WHERE id_veterinario = '$id'";
$resultado = mysqli_query($conn, $sql);
$v        = mysqli_fetch_assoc($resultado);

if (!$v) {
    die("Error: No se encontró el veterinario con ID $id");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Veterinario</title>
</head>
<body>
    <h1>Editar Veterinario: <?php echo htmlspecialchars($v['nombre']); ?></h1>

    <form method="POST" action="./modificar_veterinario.php">

        <!-- Valores ocultos. Si no se modifica nada se usan estos valores -->
        <input type="hidden" name="id_veterinario"      value="<?php echo $id; ?>">
        <input type="hidden" name="nombre_actual"       value="<?php echo $v['nombre']; ?>">
        <input type="hidden" name="apellido_actual"     value="<?php echo $v['apellido']; ?>">
        <input type="hidden" name="telef_actual"        value="<?php echo $v['num_telef']; ?>">
        <input type="hidden" name="email_actual"        value="<?php echo $v['email']; ?>">
        <input type="hidden" name="dni_actual"          value="<?php echo $v['Dni']; ?>">
        <input type="hidden" name="especialidad_actual" value="<?php echo $v['Especialidad']; ?>">
        <input type="hidden" name="sal_actual"          value="<?php echo $v['sal']; ?>">

        <label>Nombre:
            <input type="text" name="nombre" placeholder="<?php echo $v['nombre']; ?>">
        </label><br><br>

        <label>Apellido:
            <input type="text" name="apellido" placeholder="<?php echo $v['apellido']; ?>">
        </label><br><br>

        <label>Teléfono:
            <input type="number" name="num_telef" placeholder="<?php echo $v['num_telef']; ?>">
        </label><br><br>

        <label>Email:
            <input type="email" name="email" placeholder="<?php echo $v['email']; ?>">
        </label><br><br>

        <label>DNI:
            <input type="text" name="dni" maxlength="9" placeholder="<?php echo $v['Dni']; ?>" disabled>
        </label><br><br>

        <label>Especialidad:
            <input type="text" name="especialidad" placeholder="<?php echo $v['Especialidad']; ?>">
        </label><br><br>

        <label>Salario (€):
            <input type="number" step="0.01" name="sal" placeholder="<?php echo $v['sal']; ?>">
        </label><br><br>

        <button type="submit">Guardar cambios</button>
        <a href="./tabla_veterinarios.php">Cancelar</a>
    </form>
</body>
</html>
