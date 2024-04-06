var list = document.getElementById('tasksList');
var count = 0;

function addFromStorage() {
  const storedTasks = localStorage.getItem('tasks');
  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    count = tasks.length;
    tasks.forEach(function(task) {
      agregar(task);
    });
  }
}

addFromStorage();

document.getElementById('addButton').addEventListener('click', function() {
  const input = document.getElementById('taskInput');
  if (input.value !== '') {
    count++;
    agregar(input.value);
    addStorage(input.value, count);
    input.value = '';
    input.placeholder = "Ingresa la tarea";
  } else {
    input.placeholder = "Debes agregar una tarea";
  }
});

function agregar(contenido) {
  const listaItem = document.createElement('li');
  listaItem.textContent = contenido;

  const borrarButton = document.createElement('button');
  borrarButton.textContent = 'X';
  borrarButton.classList.add('borrar');

  borrarButton.addEventListener('click', function() {
    list.removeChild(listaItem);
    removeFromStorage(contenido);
  });

  listaItem.appendChild(borrarButton);
  list.appendChild(listaItem);
}

function addStorage(elemento, count) {
    var clave = 'tasks';
    const tasks = JSON.parse(localStorage.getItem(clave)) || [];
    tasks.push(elemento);
    localStorage.setItem(clave, JSON.stringify(tasks));
}

function removeFromStorage(contenido) {
  const storedTasks = localStorage.getItem('tasks');
  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    const updatedTasks = tasks.filter(task => task !== contenido);
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
  }
}