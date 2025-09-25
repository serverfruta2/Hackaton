
# Hackaton

Proyecto de demostracion simulada

🚀 Instalación y despliegue

Clonar el repositorio

git clone https://github.com/usuario/hackaton-trivia.git
cd Hackaton


Crear el archivo de progreso y asignar permisos

touch www/progreso.json 
contenido: 

{
    "profesor1": 0,
    "profesor2": 0,
    "profesor3": 0
}

Da permisos

chmod 666 www/progreso.json


Levantar el contenedor

docker compose up -d


Acceder desde el navegador

http://IP_DEL_SERVIDOR:8090


Ejemplo: http://localhost:8090 o http://mi-vps:8090

Se mostrara el index indicando los front para cada pc asignada a cada profesor y el link al front de la trivia.

COMIENZO DE LA TRIVIA

Se entra al link, la trivia comenzara con una categoria al azar y dando turno al profesor 1,
el profesor designado tendra que ejegir a un alumno para que responda la pregunta, pero antes , este debera poner su huella digital en el lector para registrar su participacion.
Una ves registrado procede a responder, si la respues es correcta la barra del front de profesor 1 avanzara 10 %(ajustable)y luego procede a profesor 2, el cual hara el mismo procedimiento al igual que el 3, 
Al completarse una barra al 100% la trivia muestra un cartel de felicitaciones y se resetea.

FIN