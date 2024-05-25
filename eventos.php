<?php
require_once 'conexion.php';

class Eventos {
    public function obtenerEventos() {
        $conexion = Cconexion::ConexionBD();

        if ($conexion === false) {
            die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
        }

        $querryEventos = "select * from eventos e left join tiposEventos t on e.idTipo = t.idTipo; ";

        $stmt = sqlsrv_query($conexion, $querryEventos);

        if ($stmt === false) {
            die('Error en la consulta: ' . print_r(sqlsrv_errors(), true));
        }

        $eventos = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {    
            $fecha = $row['fecha']->format('Y-m-d');
            $hora = $row['hora']->format('H:i:s');
            $fecha_hora = $fecha . 'T' . $hora;
            $evento = array(
                'idEvento' => $row['idEvento'],
                'idTipo' => $row['idTipo'],
                'title' => trim($row['titulo']),
                'start' => $fecha_hora,
                'rrule' => array(
                    'freq' => trim($row['frecuencia']), 
                    'interval' => 1,
                    'dtstart' => $fecha_hora
                )
            );
            $eventos[] = $evento;
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexion);

        header('Content-Type: application/json');
        echo json_encode($eventos);
    }
}

