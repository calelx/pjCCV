<?php
class Cconexion {
    public static function ConexionBD() {
        $serverName = "localhost";
        $connectionInfo = array("Database"=>"pjCCV", "UID"=>"acalel", "PWD"=>"acalel");
        $conexion = sqlsrv_connect($serverName, $connectionInfo);

        if($conexion) {
            return $conexion;
        } else {
            echo "Error al conectar a la base de datos.";
            return null;
        }
    }
}
?>
