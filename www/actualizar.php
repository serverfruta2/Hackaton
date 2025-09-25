<?php
$archivo = __DIR__ . "/progreso.json";  // Archivo directo, sin carpeta

// Reiniciar si viene ?reset=1
if(isset($_GET['reset']) && $_GET['reset'] == 1){
    $datos = [
        "profesor1" => 0,
        "profesor2" => 0,
        "profesor3" => 0
    ];
    file_put_contents($archivo, json_encode($datos, JSON_PRETTY_PRINT));
    echo json_encode(["ok"=>true, "mensaje"=>"Progreso reiniciado"]);
    exit;
}

// Para incrementar profesor
$profesor = intval($_GET['profesor'] ?? 0);

// Validar profesor
if ($profesor < 1 || $profesor > 3) {
    echo json_encode(["ok" => false, "error" => "Profesor no válido"]);
    exit;
}

// Leer datos existentes o inicializar
$datos = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Inicializar si no existe
if (!isset($datos["profesor".$profesor])) {
    $datos["profesor".$profesor] = 0;
}

// Sumar 20% sin pasar de 100
if ($datos["profesor".$profesor] < 100) {
    $datos["profesor".$profesor] += 10;
    if ($datos["profesor".$profesor] > 100) $datos["profesor".$profesor] = 100;
}

// Guardar cambios
file_put_contents($archivo, json_encode($datos, JSON_PRETTY_PRINT));

// Responder con JSON
echo json_encode(["ok" => true, "progreso" => $datos["profesor".$profesor]]);
