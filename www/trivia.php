<?php
$preguntas = json_decode(file_get_contents("data/preguntas.json"), true)['categorias'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Trivia Proyector</title>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/trivia.css">

</head>
<body>
<h1>Trivia</h1>
<div id="categoria-container"></div>
<div id="pregunta-container"></div>

<script>
let categorias = <?php echo json_encode($preguntas); ?>;
let profesorActual = 1;            // Profesor inicial
let preguntasUsadas = new Set();   // Para evitar repetir preguntas
let preguntaActual = null;

// Función para reiniciar barras y trivia
function reiniciarTrivia(profesor) {
    alert(`¡Felicitaciones Profesor ${profesor}! Barra completa.`);
    // Resetear progreso
    fetch('actualizar.php?reset=1')
    .then(() => {
        preguntasUsadas.clear();
        profesorActual = 1;
        elegirPregunta();
    });
}

// Elegir pregunta aleatoria no repetida
function elegirPregunta() {
    let todasPreguntas = categorias.flatMap(c => c.preguntas.map((p,i) => ({categoria:c.nombre, ...p, clave: c.nombre + "_" + i})));

    if (preguntasUsadas.size >= todasPreguntas.length) {
        alert("¡Se acabaron todas las preguntas!");
        preguntasUsadas.clear();
    }

    do {
        let catIndex = Math.floor(Math.random() * categorias.length);
        let cat = categorias[catIndex];
        let pregIndex = Math.floor(Math.random() * cat.preguntas.length);
        preguntaActual = {categoria: cat.nombre, ...cat.preguntas[pregIndex], clave: cat.nombre + "_" + pregIndex};
    } while (preguntasUsadas.has(preguntaActual.clave));

    preguntasUsadas.add(preguntaActual.clave);
    mostrarCategoriaProfesor();
}

// Mostrar categoría primero para que el profesor asigne alumno
function mostrarCategoriaProfesor() {
    document.getElementById("categoria-container").innerHTML =
        `<h2>Categoría: ${preguntaActual.categoria}</h2>
         <p>Profesor asignado: ${profesorActual}</p>
         <button onclick="mostrarPregunta()">Siguiente</button>`;
    document.getElementById("pregunta-container").innerHTML = "";
}

// Mostrar la pregunta y opciones
function mostrarPregunta() {
    let p = preguntaActual;
    let html = `<h2>${p.pregunta}</h2>`;
    p.opciones.forEach((op,i) => {
        html += `<button onclick="responder(${i}, ${p.correcta})">${op}</button><br>`;
    });
    document.getElementById("pregunta-container").innerHTML = html;
}

// Responder pregunta
function responder(indice, correcta) {
    if (indice === correcta) {
        fetch(`actualizar.php?profesor=${profesorActual}`)
        .then(res => res.json())
        .then(data => {
            if(data.progreso >= 100){
                reiniciarTrivia(profesorActual);
            } else {
                alert("¡Correcto! Progreso Profesor: " + data.progreso + "%");
                siguienteTurno();
            }
        });
    } else {
        alert("Incorrecto");
        siguienteTurno();
    }
}

// Siguiente profesor y pregunta
function siguienteTurno() {
    profesorActual++;
    if(profesorActual > 3) profesorActual = 1;
    elegirPregunta();
}

// Comenzar trivia
elegirPregunta();
</script>
</body>
</html>
