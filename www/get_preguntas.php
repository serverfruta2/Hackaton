<?php
$preguntas = json_decode(file_get_contents('../data/preguntas.json'), true);

echo json_encode($preguntas);
