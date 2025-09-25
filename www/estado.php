<?php
header("Content-Type: application/json");

// Recibe ?profesor=1,2 o 3
$profesor = intval($_GET['profesor'] ?? 0);

// Validar profesor
if ($profesor < 1 || $profesor > 3) {
    echo json_encode(["ok" => false, "error" => "Profesor no válido"]);
    exit;
}

// Archivo de progreso
$archivo = __DIR__ . "/progreso.json";

// Leer datos existentes
$datos = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Inicializar si no existe
if (!isset($datos["profesor".$profesor])) {
    $datos["profesor".$profesor] = 0;
}

// Devolver JSON
echo json_encode([
    "ok" => true,
    "profesor" => $profesor,
    "progreso" => $datos["profesor".$profesor]
]);
