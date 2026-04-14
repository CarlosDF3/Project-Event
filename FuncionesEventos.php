<?php
require ('dbEvent.php');
require ('Eventos.php');


function comprobarEventos(){

    global $error;
    $error = "";

    if(isset($_POST["crearEvento"]))
    {
        $nombre = trim($_POST["nomevent"] ?? "");
        $categoria = $_POST["categoria"] ?? "";
        $fecha = $_POST["fecha"] ?? "";
        $localizacion = trim($_POST["localizacion"] ?? "");
        $entrada = $_POST["entrada"] ?? "";
        $descripcion = trim($_POST["descripcion"] ?? "");
        $precio = $_POST["precio"] ?? null;
        $max_asistentes = $_POST["max_asistentes"] ?? null;

        $usuario_id = $_SESSION["usuario"]["usuario_id"];

        //  VALIDACIONES
        if (!$nombre || !$categoria || !$fecha || !$localizacion || !$entrada || !$descripcion) {
            $error = "Faltan campos obligatorios";
        }

        if ($fecha < date("Y-m-d")) {
            $error = "No puedes crear eventos en fechas pasadas";
        }

        if ($entrada === "Pago" && (!$precio || $precio <= 0)) {
            $error = "Precio inválido";
        }

        // SOLO SI NO HAY ERRORES
        if (empty($error)) {

            $ruta = null;

            if (!empty($_FILES["imagen"]["name"])) {
                $ruta = "Imagenes/" . $_FILES["imagen"]["name"];
                move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
            }

            $nuevoEvento = new Evento(
                null,
                $nombre,
                $categoria,
                $fecha,
                $localizacion,
                $entrada,
                $descripcion,
                $ruta,
                $usuario_id,
                $max_asistentes
            );

            crearEvento($nuevoEvento);
        }
    }
}


// INSERT CORREGIDO
function crearEvento($evento){

    global $conexion;

    $consulta = "INSERT INTO eventos 
    (nomevent, categoria, fecha, localizacion, entrada, descripcion, imagen, usuario_id, max_asistentes)
    VALUES (?,?,?,?,?,?,?,?,?)";

    $stmt = $conexion->prepare($consulta);

    if (!$stmt) {
        die("Error SQL: " . $conexion->error);
    }

    $stmt->bind_param(
        'sssssssii',
        $evento->nomevent,
        $evento->categoria,
        $evento->fecha,
        $evento->localizacion,
        $evento->entrada,
        $evento->descripcion,
        $evento->imagen,
        $evento->usuario_id,
        $evento->max_asistentes
    );

    return $stmt->execute();
}


// LISTAR TODOS LOS EVENTOS
function listarEventos($texto = null)
{
    global $conexion;

    $consulta = "SELECT eventos.*, usuarios.nombre AS creador
                 FROM eventos
                 INNER JOIN usuarios
                 ON eventos.usuario_id = usuarios.usuario_id";

    // Solo si hay busqueda
    if (!empty($texto)) {
        $consulta .= " WHERE eventos.nomevent LIKE ?
                        OR eventos.descripcion LIKE ?
                        OR eventos.categoria LIKE ?
                        OR eventos.localizacion LIKE ?";
    }

    $consulta .= " ORDER BY eventos.id DESC";

    $stmt = $conexion->prepare($consulta);

    if (!empty($texto)) {
        $like = "%$texto%";
        $stmt->bind_param("ssss", $like, $like, $like, $like);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    $eventos = [];

    while ($fila = $resultado->fetch_assoc()) {
        $eventos[] = new Evento(
            $fila["id"],
            $fila["nomevent"],
            $fila["categoria"],
            $fila["fecha"],
            $fila["localizacion"],
            $fila["entrada"],
            $fila["descripcion"],
            $fila["imagen"],
            $fila["usuario_id"],
            $fila["max_asistentes"]
        );
    }

    return $eventos;
}

function obtenerDetallesEvento($id) {
    global $conexion;

    $sql = "SELECT eventos.*, usuarios.nombre AS creador
            FROM eventos
            INNER JOIN usuarios
            ON eventos.usuario_id = usuarios.usuario_id
            WHERE eventos.id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return false;
}


// EVENTOS DEL PERFIL 
function listarEventosPerfil(){
    
    global $conexion;

    $id_user = $_SESSION["usuario"]["usuario_id"];

    $consulta = "SELECT * FROM eventos WHERE usuario_id = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $eventos = array();

    if ($resultado){
        
        while ($fila = $resultado->fetch_assoc())
        {
           $eventos[] = new Evento(
                $fila["id"],
                $fila["nomevent"],
                $fila["categoria"],
                $fila["fecha"],
                $fila["localizacion"],
                $fila["entrada"],
                $fila["descripcion"],
                $fila["imagen"],
                $fila["usuario_id"],
                $fila["max_asistentes"]
           );
        }
        return $eventos;
    }
}


// EVENTOS UNIDOS 
function listarEventosUnidos(){
    
    global $conexion;

    $id_user = $_SESSION["usuario"]["usuario_id"];

    $consulta = "SELECT * FROM eventos 
                 INNER JOIN join_event 
                 ON eventos.id = join_event.id_evento 
                 WHERE id_usuario = ?";

    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $eventos = [];

    while ($row = $resultado->fetch_object()) {
        $eventos[] = $row;
    }

    return $eventos;
}


// ÚLTIMOS EVENTOS
function ListarUltimosEventos(){
    
    global $conexion;

    $consulta = "SELECT * FROM eventos ORDER BY id DESC LIMIT 6";
    $resultado = mysqli_query($conexion, $consulta);

    $eventos = array();
    
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $eventos[] = new Evento(
                $fila["id"],
                $fila["nomevent"],
                $fila["categoria"],
                $fila["fecha"],
                $fila["localizacion"],
                $fila["entrada"],
                $fila["descripcion"],
                $fila["imagen"],
                $fila["usuario_id"],
                $fila["max_asistentes"]
            );
        }
        return $eventos;
    }
}

//BUSCAR EVENTOS
function buscarEventos($texto)
{
    global $conexion;

    $sql = "SELECT eventos.*, usuarios.nombre AS creador
            FROM eventos
            INNER JOIN usuarios
            ON eventos.usuario_id = usuarios.usuario_id
            WHERE eventos.nomevent LIKE ?
               OR eventos.descripcion LIKE ?
               OR eventos.categoria LIKE ?
               OR eventos.localizacion LIKE ?
            ORDER BY eventos.id DESC";

    $stmt = $conexion->prepare($sql);

    $like = "%" . $texto . "%";

    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();

    $result = $stmt->get_result();

    $eventos = [];

    while ($fila = $result->fetch_assoc()) {
        $eventos[] = new Evento(
            $fila["id"],
            $fila["nomevent"],
            $fila["categoria"],
            $fila["fecha"],
            $fila["localizacion"],
            $fila["entrada"],
            $fila["descripcion"],
            $fila["imagen"],
            $fila["usuario_id"],
            $fila["max_asistentes"]
        );
    }

    return $eventos;
}


// EVENTOS DESTACADOS
function ListarEventosDestacados(){
    
    global $conexion;

    $consulta = "SELECT * FROM eventos 
                 INNER JOIN join_event 
                 ON eventos.id = join_event.id_evento 
                 WHERE join_action = 'unirse' 
                 GROUP BY id_evento 
                 HAVING COUNT(*) > 2 
                 LIMIT 8";

    $resultado = mysqli_query($conexion, $consulta);

    $eventos = array();
    
    if ($resultado){
        while ($fila = mysqli_fetch_assoc($resultado))
        {
           $eventos[] = new Evento(
                $fila["id"],
                $fila["nomevent"],
                $fila["categoria"],
                $fila["fecha"],
                $fila["localizacion"],
                $fila["entrada"],
                $fila["descripcion"],
                $fila["imagen"],
                $fila["usuario_id"],
                $fila["max_asistentes"]
           );
        }
        return $eventos;
    }
}

//OBTENER EVENTOS POR ID 
function obtenerEventoPorId($id) {

    global $conexion;

    $stmt = $conexion->prepare("SELECT * FROM eventos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    return $resultado->fetch_object();
}


// ELIMINAR EVENTO
function eliminarEventosPerfil($id){

    global $conexion;

    $id = (int)$id;

    $consulta = "DELETE FROM eventos WHERE id = ?";
    $stmt = $conexion->prepare($consulta);

    if (!$stmt) {
        die("Error en la consulta: " . $conexion->error);
    }

    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: PaginaPerfil.php");
        exit;
    } else {
        echo "No se eliminó: " . $stmt->error;
    }
}

//EDITAR EVENTOS PERFIL
function actualizarEvento($evento){

    global $conexion;

    // ================= SIN IMAGEN =================
    if ($evento->imagen == null) {

        $consulta = "UPDATE eventos SET 
        nomevent=?, categoria=?, fecha=?, localizacion=?, entrada=?, descripcion=?, max_asistentes=?
        WHERE id=?";

        $stmt = $conexion->prepare($consulta);

        $stmt->bind_param(
            'ssssssii',
            $evento->nomevent,
            $evento->categoria,
            $evento->fecha,
            $evento->localizacion,
            $evento->entrada,
            $evento->descripcion,
            $evento->max_asistentes,
            $evento->id
        );

    } 

    // ================= CON IMAGEN =================
    else {

        $consulta = "UPDATE eventos SET 
        nomevent=?, categoria=?, fecha=?, localizacion=?, entrada=?, descripcion=?, imagen=?, max_asistentes=?
        WHERE id=?";

        $stmt = $conexion->prepare($consulta);

        $stmt->bind_param(
            'sssssssii',
            $evento->nomevent,
            $evento->categoria,
            $evento->fecha,
            $evento->localizacion,
            $evento->entrada,
            $evento->descripcion,
            $evento->imagen,
            $evento->max_asistentes,
            $evento->id
        );
    }

    return $stmt->execute();
}

function obtenerUnion($id)
{
    global $conexion;

    $stmt = $conexion->prepare("
        SELECT COUNT(*)
        FROM join_event
        WHERE id_evento = ?
        AND join_action = 'unirse'
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_row();

    return (int)$row[0];
}

function UsuarioUnido($evento_id, $id_user)
{
    global $conexion;

    $stmt = $conexion->prepare("
        SELECT 1
        FROM join_event
        WHERE id_evento = ?
        AND id_usuario = ?
        AND join_action = 'unirse'
        LIMIT 1
    ");

    $stmt->bind_param("ii", $evento_id, $id_user);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;
}