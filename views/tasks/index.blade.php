<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa - Local Storage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5" style="max-width: 700px">
        <h2 class="text-center mb-4">Daftar Siswa Local Storage</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="taskForm">
                    <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nameInput" class="form-label fw-semibold"> Nama Siswa</label>
                        <input type="text" id="nameInput" class="form-control" placeholder="masukkan nama siswa.." required>
                    </div>
                    <div class="col-md-6">
                        <label for="classInput" class="from-label fw-semibold">Kelas</label>
                        <input type="text" id="classInput" class="form-control" placeholder="masukkan kelas...." required>
                    </div>
                    <div class="col-12">
                        <label for="ageInput" class="form-label fw-semibold">Umur</label>
                        <input type="number" id="ageInput" class="form-control" placeholder="masukkan umur...">
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-primary w-100" type="submit">Tambah Siswa</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <ul id="taskList" class="list-group list-group-flush">

        </ul>
    </div>

    <!-- Script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', loadTasks);
        const taskForm = document.getElementById('taskForm');
        const nameInput = document.getElementById('nameInput');
        const classInput = document.getElementById('classInput');
        const ageInput = document.getElementById('ageInput');
        const taskList = document.getElementById('taskList');

        taskForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = nameInput.value.trim();
            const studentClass = classInput.value.trim();
            const age = ageInput.value.trim();

            if (name === '' || studentClass === '' || age === '') return;

            addTasksToLocalStorage(name, studentClass, age);

            nameInput.value = '';
            classInput.value = '';
            ageInput.value = '';

            loadTasks();
        });

        function getTasks() {
            let tasks = localStorage.getItem('siswa_list');
            return tasks ? JSON.parse(tasks) : [];
        }

        function addTasksToLocalStorage(name, studentClass, age) {
            let tasks = getTasks();
            tasks.push({ name: name, class: studentClass, age: age, completed: false });
            localStorage.setItem('siswa_list', JSON.stringify(tasks));
        }

        function loadTasks() {
            let tasks = getTasks();
            taskList.innerHTML = '';

            if (tasks.length === 0) {
                taskList.innerHTML = '<li class="list-group-item text-center text-muted py-3">Belum ada siswa.</li>';
                return;
            }

            tasks.forEach((task, index) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center py-3';
                li.innerHTML = `
                <div class="d-flex align-items-center">
                    <span class="fw-bold me-3 text-secondary fs-5">${index + 1}.</span>
                    <div>
                        <span style="${task.completed ? 'text-decoration: line-through; color: gray;' : ''}" class="fs-6 fw-bold d-block">${task.name}</span>
                        <small class="text-muted">Kelas: ${task.class} | Umur: ${task.age} tahun</small>
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm ${task.completed ? 'btn-secondary' : 'btn-success'} me-2 px-3" onclick="toggleTask(${index})">
                        ${task.completed ? 'Batal' : 'Selesai'}
                    </button>
                    <button class="btn btn-sm btn-danger px-3" onclick="deleteTask(${index})">Hapus</button>
                </div>
                `;
                taskList.appendChild(li);
            });
        }

        function toggleTask(index) {
            let tasks = getTasks();
            tasks[index].completed = !tasks[index].completed;
            localStorage.setItem('siswa_list', JSON.stringify(tasks));
            loadTasks();
        }

        function deleteTask(index) {
            let tasks = getTasks();
            tasks.splice(index, 1);
            localStorage.setItem('siswa_list', JSON.stringify(tasks));
            loadTasks();
        }
    </script>
</body>
</html>