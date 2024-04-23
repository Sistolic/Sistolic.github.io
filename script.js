// function sign_Up() {
//   window.location.href = "php/sign_Up.php";
// }
// function sign_In() {
//   window.location.href = "php/sign_In.php";
// }
// function log_Out() {
//   window.location.href = "php/config/log_Out.php";
// }
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
    input.placeholder = 'Debes agregar una tarea';
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
    var newContent = prompt("Editar", text.nodeValue);

    if(newContent !== '') {
      text.nodeValue = newContent.trim();
      updateStorage(content, newContent, false);
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
