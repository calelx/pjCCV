<?php
// Verificar si el formulario ha sido enviado
if (!empty($_POST["btnregistro"])) {
    if (!empty($_POST["nameContac"]) && !empty($_POST["dateContac"]) && !empty($_POST["addresContac"]) && !empty($_POST["phoneContac"]) && !empty($_POST["emailContac"])) {
        $nombre = $_POST["nameContac"];
        $direccion = $_POST["addresContac"];
        $telefono = $_POST["phoneContac"];
        $email = $_POST["emailContac"];
        $fechanacimiento = $_POST["dateContac"];

        $serverName = "localhost";
        $connectionInfo = array("Database" => "pjCCV", "UID" => "pjCCV", "PWD" => "pjCCV");
        $conexion = sqlsrv_connect($serverName, $connectionInfo);

        // Verificar si la conexión se estableció correctamente
        if ($conexion === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Preparar la consulta usando parámetros
        $sql = "UPDATE contactos SET nombre = ?, direccion = ?, telefono = ?, fechaNac = ? WHERE Email = ?";
        $params = array($nombre, $direccion, $telefono, $fechanacimiento, $email);

        $stmt = sqlsrv_query($conexion, $sql, $params);

        // Verificar si la consulta se ejecutó correctamente
        if ($stmt) {
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conexion);
            header("Location: verContactos.php");
            echo "<div class='alert alert-warning'>Persona eliminado correctamete</div>";
            exit();
        } else {
            echo "<div class='alert alert-warning'>Error al modificar</div>";
        }

    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}
?>
