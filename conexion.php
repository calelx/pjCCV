<?php
class Cconexion {
    public static function ConexionBD() {
        $serverName = "localhost";
        $connectionInfo = array("Database"=>"pjCCV", "UID"=>"pjCCV", "PWD"=>"pjCCV");
        $conexion = sqlsrv_connect($serverName, $connectionInfo);

        if($conexion) {
            return $conexion;
        } else {
            echo "Error al conectar a la base de datos.";
            return false;
        }
    }
}
?>
