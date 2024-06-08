function signUp() {
  window.location.href = "php/sign_Up.php";
}
function signIn() {
  window.location.href = "index.php";
}
function logOut() {
  fetch('php/config/session.php')
  .then(response => response.json())
  .then(data => {
    if(data.sesion_activa) {
      if(window.confirm("Restaurar tareas / Salir")) {
        userTasks();
      } else {
        saveToDB();
        deleteValue();
        window.location.href = "php/config/log_Out.php";
      }
    } else {
      alert("No has iniciado sesión.");
    }
  })
  .catch(error => {
    console.error(error);
  });
}

const done = document.querySelector('.done');

function showDone() {
  done.style.display = 'flex';
}
function hideDone() {
  done.style.display = 'none';
}
//----------------------------------------------\\
var list = document.getElementById('tasksList');
var input = document.getElementById('taskInput');

function addFromStorage() {
  const storedTasks = localStorage.getItem('tasks');

  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    tasks.forEach(function(task) {
      if (task.isChecked) {
        addToDone(task.content);
      } else {
        addList(task.content, task.isChecked);
      }
    });
  }
}

addFromStorage();

document.getElementById('addButton').addEventListener('click', function() {
  if (input.value !== '') {
    addList(input.value);
    addStorage(input.value, false);
    input.value = '';
    input.placeholder = 'Ingresa una tarea';
  } else {
    alert("Debes agregar una tarea");
  }
});

function addList(content) {
  const task = document.createElement('li');

  const checkButton = document.createElement('button');
  checkButton.classList.add('checkButton');
  checkButton.addEventListener('click', function() {
    addToDone(content);
    list.removeChild(task);
    updateStorage(content, content, true);
  });

  const text = document.createTextNode(content);
  task.appendChild(checkButton);
  task.appendChild(text);

  const editButton = document.createElement('button');
  editButton.classList.add('editButton');
  editButton.addEventListener('click', function() {
    const newContent = prompt('Editar tarea:', text.nodeValue.trim());
    
    if (newContent !== '') {
      text.nodeValue = newContent.trim();
      updateStorage(content, newContent.trim(), false);
      location.reload();
    }
  });

  const deleteButton = document.createElement('button');
  deleteButton.classList.add('deleteButton');
  deleteButton.addEventListener('click', function() {
    if (window.confirm("¿Eliminar?")) {
      list.removeChild(task);
      removeFromStorage(content);
    }
  });

  task.appendChild(deleteButton);
  task.appendChild(editButton);
  list.appendChild(task);
}

function addStorage(content, isChecked) {
  var key = 'tasks';
  const tasks = JSON.parse(localStorage.getItem(key)) || [];
  tasks.push({ content: content, isChecked: isChecked});
  localStorage.setItem(key, JSON.stringify(tasks));
}

function removeFromStorage(content) {
  const storedTasks = localStorage.getItem('tasks');
  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    const updatedTasks = tasks.filter(task => task.content !== content);
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
  }
}

function addToDone(content) {
  const done = document.querySelector('.done');
  const task = document.createElement('li');
  const text = document.createTextNode(content);

  const undoButton = document.createElement('button');
  undoButton.classList.add('undoButton');
  undoButton.addEventListener('click', function() {
    addList(content, false);
    updateStorage(content, content, false);
    done.removeChild(task);
  });

  const deleteButton = document.createElement('button');
  deleteButton.classList.add('deleteButton');
  deleteButton.addEventListener('click', function() {
    if (window.confirm("¿Eliminar?")) {
      done.removeChild(task);
      removeFromStorage(content);
    }
  });
  
  task.appendChild(text);

  task.appendChild(deleteButton);
  task.appendChild(undoButton);
  done.appendChild(task);
}

function updateStorage(oldContent, newContent, isChecked) {
  const storedTasks = localStorage.getItem('tasks');
  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    const updatedTasks = tasks.map(task => {
      if (task.content === oldContent) {
        return { content: newContent, isChecked: isChecked };
      }
      return task;
    });
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
  }
}

function deleteValue() {
  var tasks = JSON.parse(localStorage.getItem('tasks'));

  if (tasks) {
    tasks = [];
    localStorage.setItem('tasks', JSON.stringify(tasks));
  }
}

function saveToDB() {
  var tasksByUser = JSON.parse(localStorage.getItem('tasks'));

  try {
    if (tasksByUser.length !== 0) {
      tasksByUser.map(task => {
        var tasksToDB = {
          task: task.content,
          isChecked: task.isChecked
        }
        
        fetch('php/config/config.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(tasksToDB),
        })
        .then(response => response.text())
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          console.error('Error al enviar datos al servidor:', error);
        });
      });
    }
  } catch(e) {
    console.log("No hay tareas que agregar.")
  }
}

function userTasks() {
  fetch('php/config/config.php')
  .then(response => response.json())
  .then(data => {
    if (!data.empty) {
      data.forEach(item => {
        intBool = bool(item.is_checked);
        addStorage(item.task, intBool);
      });
      location.reload();
    } else {
      alert("No has guardado tareas.")
    }
  })
  .catch(error => {
    console.error("Error al obtener los datos", error);
  });
}

function bool(int) {
  if (int == 1) {
    return true;
  } else if (int == 0) {
    return false;
  }
}
