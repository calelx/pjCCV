<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.html">Calendario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="nuevoTipoEvento.html"> Nuevo tipo de Evento </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agregarEvento.php"> Crear Evento </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Contactos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../contactos/agregarContactos.html">Agregar nuevo
                                    contacto</a></li>
                            <li><a class="dropdown-item" href="../contactos/verContactos.php">Ver contactos</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="w-50 mx-auto p-3 bg-light rounded shadow-lg p-3 mb-5 bg-body rounded">
            <h1 class="mb-4">Crear nuevo evento</h1>
            <form class="row g-3" method="post" action="insertEvento.php">
                <div class="col-md-6">
                    <label class="form-label">Titulo</label>
                    <input type="text" maxlength="90" class="form-control" placeholder="Titulo (Maximo de caractesres 90)" name="title" autocomplete="off" required>
                </div>
                <div class="col-md-6">
                    <labe class="form-label">Fecha de evento</labe>
                    <input type="date" class="form-control" name="date" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Hora del evento</label>
                    <input type="time" class="form-control" placeholder="hour" name="hour" required>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom04" class="form-label">Tipo de evento</label>
                    <select class="form-select" id="validationCustom04" name="typeEvent" required>
                        <option selected disabled value="">Elige...</option>

                        <?php
                        require_once '../conexion.php';
                        $conexion = Cconexion::ConexionBD();
                        if ($conexion === false) {
                            die('Error de conexión: ' . print_r(sqlsrv_errors(), true));
                        }
                        $querry = "select idTipo, nombre from tiposEventos";
                        $dataEventos = sqlsrv_query($conexion, $querry);
                        if ($dataEventos === false) {
                            die('Error en la consulta SELECT: ' . print_r(sqlsrv_errors(), true));
                        }
                        while ($fila = sqlsrv_fetch_array($dataEventos, SQLSRV_FETCH_ASSOC)) {
                            $nombreEvento = $fila['nombre'];
                            $idEvento = $fila['idTipo'];
                            echo "<option value = '$idEvento'> $nombreEvento </option>";
                        }
                        ?>

                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" placeholder="Texto requerido" name="descrip" autocomplete="off" required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                alert('Evento creado exitosamente.');
            } else if (status === 'error') {
                alert('Error al crear el evento.');
            }
        });
    </script>

</body>

</html>