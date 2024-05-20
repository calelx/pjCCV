<?php
require_once '../conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = Cconexion::ConexionBD();

    $nombre = $_POST['title'];
    $frecuencia = $_POST['frecuencia'];

    $querryIdEvent = "SELECT MIN(t1.idTipo) + 1 AS next_id FROM tiposEventos t1 LEFT JOIN tiposEventos t2 ON t1.idTipo + 1 = t2.idTipo WHERE t2.idTipo IS NULL";
    $idEventoResult = sqlsrv_query($conexion, $querryIdEvent);
    $idEventoRow = sqlsrv_fetch_array($idEventoResult, SQLSRV_FETCH_ASSOC);
    $idEvento = $idEventoRow['next_id'];

    $querry = "insert into tiposEventos (idTipo, nombre, frecuencia) values (?,?,?)";

    $paramsEvento = array($idEvento, $nombre, $frecuencia);

    $resultEvento = sqlsrv_query($conexion, $querry, $paramsEvento);
    if ($resultContactos === false) {
        die('Error al insertar en contactos: ' . print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($resultEvento);
    sqlsrv_close($conexion);

    header("Location: nuevoTipoEvento.html");
    exit();
}
?>