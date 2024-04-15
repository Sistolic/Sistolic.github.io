function showDone() {
  const tasksDone = document.querySelector('.tasksDone');
  tasksDone.style.display = 'flex';
}

function hideDone() {
  const tasksDone = document.querySelector('.tasksDone');
  tasksDone.style.display = 'none';
}

var list = document.getElementById('tasksList');

function addFromStorage() {
  const storedTasks = localStorage.getItem('tasks');
  var count = 0;

  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    tasks.forEach(function(task) {
      var index = tasks[count];

      if (index.isChecked) {
        addToDone(task.content)
      } else {
        addList(task.content, task.isChecked);
      }
      count++;
    });
  }
}

addFromStorage();

document.getElementById('addButton').addEventListener('click', function() {
  const input = document.getElementById('taskInput');
  if (input.value !== '') {
    addList(input.value, false);
    addStorage(input.value, false);
    input.value = '';
    input.placeholder = 'Ingresa una tarea'; 
  } else {
    input.placeholder = 'Debes agregar una tarea';
  }
});

function addList(content, isChecked) {
  const task = document.createElement('li');

  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.checked = isChecked;

  checkbox.addEventListener('change', function() {
    updateStorage(content, checkbox.checked);
    
    if (checkbox.checked) {
      addToDone(content);
      list.removeChild(task);
    }
  });

  const text = document.createTextNode(content);
  task.appendChild(checkbox);
  task.appendChild(text);

  const deleteButton = document.createElement('button');
  deleteButton.textContent = 'X';
  deleteButton.classList.add('deleteButton');
  deleteButton.addEventListener('click', function() {
    list.removeChild(task);
    removeFromStorage(content);
  });

  task.appendChild(deleteButton);
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
  const done = document.querySelector('.tasksDone');
  const task = document.createElement('li');
  const text = document.createTextNode(content);

  const deleteButton = document.createElement('button');
  deleteButton.textContent = 'X';
  deleteButton.classList.add('deleteButton');
  deleteButton.addEventListener('click', function() {
    done.removeChild(task);
    removeFromStorage(content);
  });

  task.appendChild(deleteButton);
  task.appendChild(text);
  done.appendChild(task);
}

function updateStorage(content, isChecked) {
  const storedTasks = localStorage.getItem('tasks');
  if (storedTasks) {
    const tasks = JSON.parse(storedTasks);
    const updatedTasks = tasks.map(task => {
      if (task.content === content) {
        return { content: task.content, isChecked: isChecked };
      }
      return task;
    });
    localStorage.setItem('tasks', JSON.stringify(updatedTasks));
  }
}
