<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Profesor 2</title>
<style>
.barra-container { width: 100%; background: #ddd; border-radius: 10px; overflow: hidden; margin-top:20px; }
.barra { height: 30px; width: 0%; background: orange; text-align: center; color: white; line-height: 30px; transition: width 0.5s; }
</style>
</head>
<body>
<h1>Profesor 2</h1>
<div class="barra-container">
    <div id="barra" class="barra">0%</div>
</div>

<script>
function actualizarBarra() {
    fetch("estado.php?profesor=2")
    .then(res => res.json())
    .then(data => {
        let barra = document.getElementById("barra");
        barra.style.width = data.progreso + "%";
        barra.textContent = data.progreso + "%";
    });
}

setInterval(actualizarBarra, 2000);
actualizarBarra();
</script>
</body>
</html>
