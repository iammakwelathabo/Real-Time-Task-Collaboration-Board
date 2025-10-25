document.addEventListener("DOMContentLoaded", async () => {

    // Function to update all statistics
    async function updateAllStats() {
        try {
            const response = await fetch('/tasks/all');
            if (response.ok) {
                const tasks = await response.json();

                // Calculate statistics
                const totalTasks = tasks.length;
                const completedTasks = tasks.filter(task => task.status === 'done').length;
                const inProgressTasks = tasks.filter(task => task.status === 'in-progress').length;
                const reviewTasks = tasks.filter(task => task.status === 'review').length;
                const backlogTasks = tasks.filter(task => task.status === 'backlog').length;
                const overdueTasks = tasks.filter(task => {
                    if (!task.due_date) return false;
                    const dueDate = new Date(task.due_date);
                    const today = new Date();
                    return dueDate < today && task.status !== 'done';
                }).length;

                // Update all stat elements
                updateStatElement('totalTasksCount', totalTasks);
                updateStatElement('completedTasksCount', completedTasks);
                updateStatElement('inProgressTasksCount', inProgressTasks);
                updateStatElement('reviewTasksCount', reviewTasks);
                updateStatElement('backlogTasksCount', backlogTasks);
                updateStatElement('overdueTasksCount', overdueTasks);
            }
        } catch (error) {
            console.error('Error updating stats:', error);
        }
    }

    // Helper function to update statistic elements
    function updateStatElement(elementId, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = value;
        }
    }

    // Update task status in database
    async function updateTaskStatus(taskId, status) {
        try {
            const response = await fetch(`/tasks/${taskId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: status,
                    _method: 'PATCH'
                })
            });

            if (!response.ok) {
                throw new Error('Failed to update task status');
            }
        } catch (error) {
            console.error('Error updating task status:', error);
            throw error;
        }
    }

    // Create individual task card
    function createTaskCard(task) {
        const li = document.createElement("li");
        li.className = "task-card";
        li.draggable = true;
        li.dataset.id = task.id;

        li.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded p-3 shadow cursor-move border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">${task.title}</h4>
                    <div class="flex space-x-1">
                        <button onclick="openEditModal(${task.id})" class="text-gray-400 hover:text-blue-500 dark:hover:text-blue-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                ${task.description ? `<p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${task.description}</p>` : ''}
                ${task.due_date ? `<p class="text-xs text-gray-500 mt-2">Due: ${new Date(task.due_date).toLocaleDateString()}</p>` : ''}
                ${task.priority ? `<span class="font-semibold inline-block px-2 py-1 text-xs rounded-full mt-2 ${
            task.priority === 'high' || task.priority === 'urgent' ? 'text-blue-100 bg-red-100 text-red-800' :
                task.priority === 'medium' ? 'text-blue-100  bg-yellow-100 text-yellow-800' :
                    'text-blue-100 bg-green-100 text-green-800'
        }">${task.priority}</span>` : ''}
                ${task.assignee ? `<div class="flex items-center mt-2">
                    <span class="text-xs text-gray-500">Assigned to: ${task.assignee.name}</span>
                </div>` : ''}
            </div>
        `;

        li.addEventListener("dragstart", (e) => {
            e.dataTransfer.setData("text/plain", task.id);
        });

        return li;
    }


    function renderTasks(tasks) {
        const columns = ['backlog', 'inprogress', 'review', 'done'];
        columns.forEach(columnId => {
            const column = document.getElementById(columnId);
            if (column) {
                column.innerHTML = '';
            }
        });

        tasks.forEach(task => {

            let columnId = task.status;
            if (task.status === 'in-progress') {
                columnId = 'inprogress';
            }

            const column = document.getElementById(columnId);
            if (!column) {
                console.warn(`Column not found for status: ${task.status} (looking for: ${columnId})`);
                return;
            }

            const taskCard = createTaskCard(task);
            column.appendChild(taskCard);
        });

        // Update statistics
        updateAllStats();
    }

    // Initialize drag and drop
    function initializeDragAndDrop() {
        const columns = {
            backlog: document.getElementById("backlog"),
            "in-progress": document.getElementById("inprogress"),
            review: document.getElementById("review"),
            done: document.getElementById("done"),
        };

        Object.entries(columns).forEach(([status, col]) => {
            if (!col) {
                console.warn(`Column not found: ${status}`);
                return;
            }

            col.addEventListener("dragover", (e) => e.preventDefault());

            col.addEventListener("drop", async (e) => {
                e.preventDefault();
                const id = e.dataTransfer.getData("text/plain");
                const dragged = document.querySelector(`[data-id='${id}']`);

                if (dragged && col) {
                    col.appendChild(dragged);
                    try {
                        await updateTaskStatus(id, status);
                        await updateAllStats();
                    } catch (error) {
                        console.error('Error in drop handler:', error);
                    }
                }
            });
        });
    }

    // Fetch tasks from the database
    async function loadTasks() {
        try {
            const response = await fetch('/tasks/all');
            if (response.ok) {
                const tasks = await response.json();
                window.tasks = tasks;
                renderTasks(tasks);
                initializeDragAndDrop();
                return tasks;
            } else {
                console.error('Failed to fetch tasks');
                return [];
            }
        } catch (error) {
            console.error('Error fetching tasks:', error);
            return [];
        }
    }

    // Initialize form handlers
    function initializeFormHandlers() {
        const saveTaskBtn = document.getElementById("saveTaskBtn");
        if (saveTaskBtn) {
            saveTaskBtn.addEventListener("click", async () => {
                const title = document.getElementById("taskTitle").value.trim();
                const status = document.getElementById("taskStatus").value;

                if (!title) return alert("Please enter a task title.");

                try {
                    const response = await fetch('/tasks', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            title: title,
                            status: status
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Refresh the tasks instead of manually adding to avoid duplicates
                        await loadTasks();
                        closeModal("createTask");
                        document.getElementById("taskTitle").value = "";
                    } else {
                        alert('Failed to create task: ' + (result.message || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Error creating task:', error);
                    alert('An error occurred while creating the task');
                }
            });
        }
    }

    // Load tasks and initialize
    await loadTasks();
    initializeFormHandlers();

    // Modal Functions
    window.openModal = function (id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.documentElement.style.overflow = 'hidden';
    };

    window.closeModal = function (id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.documentElement.style.overflow = '';
    };

    // Add real-time event listeners
    function initializeRealtimeListeners() {
        // Listen for new tasks
        window.Echo.channel('tasks')
            .listen('.TaskCreated', (e) => {
                console.log('New task created:', e.task);
                // Add the new task to the board
                addTaskToBoard(e.task);
                updateAllStats();
            })
            .listen('.TaskUpdated', (e) => {
                console.log('Task updated:', e.task);
                // Update the task on the board
                updateTaskOnBoard(e.task);
                updateAllStats();
            })
            .listen('.TaskDeleted', (e) => {
                console.log('Task deleted:', e.taskId);
                // Remove the task from the board
                removeTaskFromBoard(e.taskId);
                updateAllStats();
            });
    }

    // Helper function to add a task to the board
    function addTaskToBoard(task) {
        const columnId = getColumnIdFromStatus(task.status);
        const column = document.getElementById(columnId);

        if (column && !document.querySelector(`[data-id='${task.id}']`)) {
            const taskCard = createTaskCard(task);
            column.appendChild(taskCard);
        }
    }

    // Helper function to update a task on the board
    function updateTaskOnBoard(updatedTask) {
        const existingTask = document.querySelector(`[data-id='${updatedTask.id}']`);

        if (existingTask) {
            // Remove from current position
            existingTask.remove();

            // Add to correct column
            addTaskToBoard(updatedTask);
        } else {
            // Task doesn't exist yet, add it
            addTaskToBoard(updatedTask);
        }
    }

    // Helper function to remove a task from the board
    function removeTaskFromBoard(taskId) {
        const taskElement = document.querySelector(`[data-id='${taskId}']`);
        if (taskElement) {
            taskElement.remove();
        }
    }

    // Helper function to map status to column ID
    function getColumnIdFromStatus(status) {
        const statusMap = {
            'backlog': 'backlog',
            'in-progress': 'inprogress',
            'review': 'review',
            'done': 'done'
        };
        return statusMap[status] || 'backlog';
    }

    // Update your existing renderTasks function to avoid duplicates
    function renderTasks(tasks) {
        const columns = ['backlog', 'inprogress', 'review', 'done'];
        columns.forEach(columnId => {
            const column = document.getElementById(columnId);
            if (column) {
                column.innerHTML = '';
            }
        });

        tasks.forEach(task => {
            addTaskToBoard(task);
        });

        // Update statistics
        updateAllStats();
    }

    // Update your existing loadTasks function
    async function loadTasks() {
        try {
            const response = await fetch('/tasks/all');
            if (response.ok) {
                const tasks = await response.json();
                window.tasks = tasks;
                renderTasks(tasks);
                initializeDragAndDrop();
                initializeRealtimeListeners(); // Add this line
                return tasks;
            } else {
                console.error('Failed to fetch tasks');
                return [];
            }
        } catch (error) {
            console.error('Error fetching tasks:', error);
            return [];
        }
    }

});

// Global functions (outside DOMContentLoaded)
function openModal(modalName) {
    const modal = document.getElementById(modalName);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.documentElement.style.overflow = 'hidden';
    }
}
