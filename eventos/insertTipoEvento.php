<?php
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = Cconexion::ConexionBD();

    $nombre = $_POST['title'];
    $frecuencia = $_POST['frecuencia'];

    // Nueva consulta para obtener el próximo ID disponible
    $querryIdEvent = "SELECT ISNULL(MAX(idTipo), 0) + 1 AS next_id FROM tiposEventos";
    $idEventoResult = sqlsrv_query($conexion, $querryIdEvent);

    if ($idEventoResult === false) {
        die('Error al obtener el próximo ID: ' . print_r(sqlsrv_errors(), true));
    }

    $idEventoRow = sqlsrv_fetch_array($idEventoResult, SQLSRV_FETCH_ASSOC);
    if ($idEventoRow === false) {
        die('Error al obtener el valor del próximo ID: ' . print_r(sqlsrv_errors(), true));
    }

    $idEvento = $idEventoRow['next_id'];
    if (is_null($idEvento)) {
        die('Error: el próximo ID es nulo.');
    }

    sqlsrv_free_stmt($idEventoResult);

    // Consulta para insertar el nuevo evento
    $querry = "INSERT INTO tiposEventos (idTipo, nombre, frecuencia) VALUES (?,?,?)";
    $paramsEvento = array($idEvento, $nombre, $frecuencia);
    $resultEvento = sqlsrv_query($conexion, $querry, $paramsEvento);

    if ($resultEvento === false) {
        sqlsrv_free_stmt($resultEvento);
        sqlsrv_close($conexion);
        header("Location: nuevoTipoEvento.html?status=error");
        exit();
    }

    sqlsrv_free_stmt($resultEvento);
    sqlsrv_close($conexion);

    header("Location: nuevoTipoEvento.html?status=success");
    exit();
}
?>
