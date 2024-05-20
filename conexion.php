<?php
class Cconexion {
    public static function ConexionBD() {
        $serverName = "localhost";
        $connectionInfo = array("Database"=>"pjCCV", "UID"=>"Skelett", "PWD"=>"Skelett337626");
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
