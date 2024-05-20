<?php
require_once '../conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = Cconexion::ConexionBD();

    if ($conexion === false) {
        die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
    }

    $titulo = $_POST['title'];
    $fecha = $_POST['date'];
    $hora = $_POST['hour'];
    $tipo = $_POST['typeEvent'];
    $descrip = $_POST['descrip'];

    $querryIdEvent = "SELECT MIN(t1.idEvento) + 1 AS next_id FROM eventos t1 LEFT JOIN eventos t2 ON t1.idEvento + 1 = t2.idEvento WHERE t2.idEvento IS NULL";
    $querry = "insert into eventos (idEvento, idTipo, fecha, hora, titulo, descripcion) values (?,?,?,?,?,?)";

    $idEventoResult = sqlsrv_query($conexion, $querryIdEvent);
    $idEventoRow = sqlsrv_fetch_array($idEventoResult, SQLSRV_FETCH_ASSOC);
    $idEvento = $idEventoRow['next_id'];

    $paramsEventos = array($idEvento, $tipo, $fecha, $hora, $titulo, $descrip);
    $result = sqlsrv_query($conexion, $querry, $paramsEventos);
    if ($result === false) {
        die('Error al insertar en eventos: ' . print_r(sqlsrv_errors(), true));
    }



    sqlsrv_free_stmt($idEventoResult);
    sqlsrv_close($conexion);
    header("Location: agregarEvento.php");
    exit();
}
?>