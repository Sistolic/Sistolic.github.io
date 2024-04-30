<!Doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tareas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="manifest" href="manifest.json">
  </head>
  <body>
   <div class="session">
      <button onclick="sign_Up()">Registrate</button>
      <button onclick="sign_In()">Iniciar sesión</button>
      <button class="log_Out" onclick="log_Out()">Salir</button>
   </div>
    <h1>Lista de tareas</h1>
    <input id="taskInput" placeholder="Ingresa una tarea">
    <button id="addButton">Agregar</button>
    <button onclick="showDone()">Tareas realizadas</button>

    <nav class="done"><ul>
      <button class="deleteButton close" onclick="hideDone()"></button>
    </ul></nav>
    
    <ul id="tasksList"></ul>

    <script type="text/javascript" src="script.js"></script>

    <script>
      if('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js')
      }
    </script>
  </body>
</html>
