<?php
class Cconexion {
    public static function ConexionBD() {
        $serverName = "localhost";
        $connectionInfo = array("Database"=>"lab5", "UID"=>"Skelett", "PWD"=>"Skelett337626");
        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if($conn) {
            $consulta = "SELECT * FROM edificio";

            $resultado = sqlsrv_query($conn, $consulta);

            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                echo $fila['id_e'] . ', ' . $fila['dir']. ', '  . $fila['tipo'] . ', ' . $fila['nivel_calidad'] . '<br>';
            }

            sqlsrv_free_stmt($resultado);
            sqlsrv_close($conn);
        } else {
            echo "Error al conectar a la base de datos.";
        }
    }
}
?>
