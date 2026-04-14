<?php
require('dbEvent.php');
require('FuncionesEventos.php');
session_start();


header('Content-Type: application/json');

global $conexion;

$id_user = $_SESSION["usuario"]["usuario_id"] ?? null;

if (!$id_user) {
    echo json_encode(["success" => false, "error" => "No autenticado"]);
    exit;
}

if (!isset($_POST['action'], $_POST['id_evento'])) {
    echo json_encode(["success" => false, "error" => "Petición inválida"]);
    exit;
}


$evento_id = $_POST['id_evento'];
$action = $_POST['action'];


// -----------------------
// UNIRSE
// -----------------------
if ($action === 'unirse') {

    $stmt = $conexion->prepare("
        INSERT INTO join_event (id_evento, id_usuario, join_action)
        VALUES (?, ?, 'unirse')
        ON DUPLICATE KEY UPDATE join_action='unirse'
    ");

    $stmt->bind_param("ii", $evento_id, $id_user);
    $stmt->execute();


// -----------------------
// ABANDONAR
// -----------------------
} elseif ($action === 'abandonar') {

    $stmt = $conexion->prepare("
        DELETE FROM join_event
        WHERE id_evento = ?
        AND id_usuario = ?
    ");

    $stmt->bind_param("ii", $evento_id, $id_user);
    $stmt->execute();

} else {
    echo json_encode(["success" => false, "error" => "Acción no válida"]);
    exit;
}


// -----------------------
// RESPUESTA
// -----------------------

echo json_encode([
    "success" => true,
    "unidos" => obtenerUnion($evento_id)
]);

exit;




