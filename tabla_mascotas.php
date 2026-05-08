<?php
session_start();

if(!isset ($_SESSION["usuario"])) {
    header("Location: ./login.html");
}

include "includes/conexion.php";
$usuario_logeado = $_SESION["usuario"];

//Filtros
$fil_tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
$fil_chip = isset($_GET['chip']) ? trim($_GET['chip']) : '';
$fil_nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
$fil_propietario = isset($_GET['propietario']) ? trim ($_GET['propietario']) : '';
$fil_compor = isset($_GET['comportamiento']) ? trim($_GET['comportamiento']) : '';
$fil_fechaN = isset($_GET['fechaN']) ? trim($_GET['fechaN']) : '';
$fil_veter = isset($_GET['veter']) ? trim($_GET['veter']) : '';

$condiciones = [];

if($fil_tipo != ''){
    $condicioens[] = "m.tipo LIKE '%$fil_tipo%'";
}
if($fil_chip != ''){
    $condiciones[] = "m.chip LIKE '%$fil_chip%'";
}
if($fil_nombre != ''){
    $condiciones[] = "m.Nombre LIKE '%$fil_nombre%'";
}
if($fil_propietario != ''){
    $condiciones[] = "p.nombre LIKE '%$fil_propietario%'";
}
if($fil_compor != ''){
    $condiciones[] = "m.Comportamiento LIKE '%$fil_compor%'";
}
if($fil_fechaN != ''){
    $condiciones[] = "m.fecha LIKE '%$fil_fechaN%'";
}
if($fil_veter != ''){
    $condiciones[] = "v.nombre LIKE '%$fil_veter%'";
}

$sql = "SELECT * FROM mascotas";

if(empty($condiciones)){
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY chip ASC";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Mascotas</h1>
    <form method="GET" action="">
        <?php
        echo '
        <input type="text" name="chip" placeholder="Buscar chip por..." value="' . $fil_chip . '">
        <input type="text" name="tipe" placeholder="Buscar tipo por..." value="' . $fil_tipo . '">
        <input type="text" name="nombre" placeholder="Buscar nombre por..." value="' . $fil_nombre . '">
        <input type="text" name="propietario" placeholder="Buscar propietario por..." value="' . $fil_propietario . '">
        <input type="text" name="comportamiento" placeholder="Buscar comportamiento por..." value="' . $fil_compor . '">
        <input type="text" name="fechaN" placehoder="Buscar fecha nacimiento por..." value="' . $fil_fechaN . '">
        <input type="text" name="veter" placeholder="Buscar veterinario por..." value="' . $fil_veter . '">
        
        <button type="submit">Buscar</button>
        <a href="./tabla_mascotas.php">Limpiar filtros</a>
        ';

        $resultado = mysqli_query($conn, $sql);
        $mascotas = mysqli_fetch_all($resultado, MYSQL_ASSOC);
        
        $hay_filtros = $fil_chip != "" || $fil_compor != '' || $fil_fechaN != '' || $fil_nombre != '' || $fil_propietario != '' || $fil_tipo != '' || $fil_veter != '';

        if($hay_filtros){

        }

        ?>
    </form>
    <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Chip</th>
            <th>Nombre</th>
            <th>Sexo</th>
            <th>Raza</th>
            <th>Propietario</th>
            <th>Peso</th>
            <th>Tamaño</th>
            <th>Comportamiento</th>
            <th>Fecha nacimiento</th>
            <th>Veterinario</th>
        </tr>
        <?php
        if($resultado){
            $mascotas = mysqli_fetch_all($resultado, MYSQL_ASSOC);
            foreach ($mascots as  $fila){
                echo "<tr>";
                echo "<td>{$fila['id']}</td>";
                echo "<td>{$fila['tipo']}</td>";
                echo "<td>{$fila['chip']}</td>";
                echo "<td>{$fila['nombre']}</td>";
                echo "<td>{$fila['sexo']}</td>";
                echo "<td>{$fila['Raza']}</td>";
                echo "<td>{$fila['Propietario']}</td>";
                echo "<td>{$fila['Peso']}</td>";
                echo "<td>{$fila['Tamaño']}</td>";
                echo "<td>{$fila['Comportamiento']}</td>";
                echo "<td>{$fila['Fecha nacimiento']}</td>";
                echo "<td>{$fila['Veterinario']}</td>";
                echo " <a href='./editar_mascota.php?id={$fila['id']}'>Modificar</a>
                        <a href='./eliminar_mascota.php?id={$fila['id']}'>Eliminar</a>";
            }
        }
        ?>
    </table>
</body>
</html>