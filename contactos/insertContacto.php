<?php
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = Cconexion::ConexionBD();

    if ($conexion === false) {
        die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
    }

    $nombre = $_POST['nameContac'];
    $fechaNacimiento = $_POST['dateContac'];
    $direccion = $_POST['addresContac'];
    $telefono = $_POST['phoneContac'];
    $email = $_POST['emailContac'];

    // Consulta para obtener el próximo idEvento disponible
    $numEventoQuery = "SELECT COALESCE(MIN(t1.idEvento) + 1, 1) AS next_id FROM eventos t1 LEFT JOIN eventos t2 ON t1.idEvento + 1 = t2.idEvento WHERE t2.idEvento IS NULL;
    ";
    $idEventoResult = sqlsrv_query($conexion, $numEventoQuery);

    if ($idEventoResult === false) {
        die('Error en la consulta SELECT: ' . print_r(sqlsrv_errors(), true));
    }

    // Obter el idEvento a usar
    $idEventoRow = sqlsrv_fetch_array($idEventoResult, SQLSRV_FETCH_ASSOC);
    if (!$idEventoRow) {
        die('Error al obtener el próximo idEvento: ' . print_r(sqlsrv_errors(), true));
    }
    $idEvento = $idEventoRow['next_id'];

    // Liberar el resultado de la consulta
    sqlsrv_free_stmt($idEventoResult);

    // Parámetros para las consultas INSERT
    $paramsContactos = array($email, $telefono, $fechaNacimiento, $direccion, $nombre);
    $paramsEventos = array($idEvento, 1, $fechaNacimiento, '06:00:00.0000000', "Cumple de " . $nombre, "Cumple de " . $nombre);
    $paramsCumple = array($idEvento, $email);

    // Consultas INSERT
    $valuesContactos = "INSERT INTO contactos (Email, telefono, fechaNac, direccion, nombre) VALUES (?, ?, ?, ?, ?)";
    $valuesEventos = "INSERT INTO eventos (idEvento, idTipo, fecha, hora, titulo, descripcion) VALUES (?, ?, ?, ?, ?, ?)";
    $valuesCumple = "INSERT INTO cumple (idEvento, Email) VALUES (?, ?)";

    // Ejecutar la consulta para insertar en contactos
    $resultContactos = sqlsrv_query($conexion, $valuesContactos, $paramsContactos);

    // Ejecutar la consulta para insertar en eventos
    $resultEventos = sqlsrv_query($conexion, $valuesEventos, $paramsEventos);

    // Ejecutar la consulta para insertar en cumple
    $resultCumple = sqlsrv_query($conexion, $valuesCumple, $paramsCumple);
    if ($resultCumple === false || $resultEventos === false || $resultContactos === false) {
        header("Location: agregarContactos.html?status=error");
        exit();
    }

    // Liberar los resultados de las consultas
    sqlsrv_free_stmt($resultContactos);
    sqlsrv_free_stmt($resultEventos);
    sqlsrv_free_stmt($resultCumple);
    sqlsrv_close($conexion);

    header("Location: agregarContactos.html?status=success");
    exit();
}
?>