<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kanban Dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <button onclick="openModal('createTask')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Add Task</span>
                </button>
                <button onclick="openFilterModal()" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Overview -->
            <div class="space-y-4 mb-6">
                <!-- Total Tasks - Full Width -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">TOTAL TASKS</p>
                            <p id="totalTasksCount" class="text-4xl font-bold">0</p>
                        </div>
                        <div class="bg-blue-400 rounded-lg p-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Breakdown - 5 columns -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Backlog Tasks -->
                    <div class="bg-gradient-to-r from-gray-500 to-gray-600 rounded-xl p-4 text-white shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-100 text-sm">Backlog</p>
                                <p id="backlogTasksCount" class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-gray-400 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-4 text-white shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-yellow-100 text-sm">In Progress</p>
                                <p id="inProgressTasksCount" class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-yellow-400 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Review Tasks -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-purple-100 text-sm">In Review</p>
                                <p id="reviewTasksCount" class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-purple-400 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-green-100 text-sm">Completed</p>
                                <p id="completedTasksCount" class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-green-400 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Overdue -->
                    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-4 text-white shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-red-100 text-sm">Overdue</p>
                                <p id="overdueTasksCount" class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-red-400 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanban Board -->
            <div id="kanban-board" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="kanban-column bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-bold mb-2 text-blue-100">Backlog</h4>
                    <div id="backlog" class="kanban-dropzone min-h-[200px] space-y-2"></div>
                </div>
                <div class="kanban-column bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-bold mb-2 text-blue-100">In Progress</h4>
                    <div id="inprogress" class="kanban-dropzone min-h-[200px] space-y-2"></div>
                </div>
                <div class="kanban-column bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-bold mb-2 text-blue-100">Review</h4>
                    <div id="review" class="kanban-dropzone min-h-[200px] space-y-2"></div>
                </div>
                <div class="kanban-column bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-bold mb-2 text-blue-100">Done</h4>
                    <div id="done" class="kanban-dropzone min-h-[200px] space-y-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div id="createTask" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-md max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Create New Task</h3>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                                <input type="text" name="title" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter task title">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Enter task description"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                                <select name="status" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Status</option>
                                    <option value="backlog">Backlog</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                                <select name="priority"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date</label>
                                <input type="date" name="due_date"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- In your create task modal, add this field: -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assign To</label>
                                <select name="assigned_to" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Labels</label>
                                <input type="text" name="labels"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter labels (comma separated)">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('createTask')" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">Cancel</button>
                    <button type="submit" form="createTaskForm" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                        <span>Create Task</span>
                        <div id="createTaskSpinner" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-md max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Edit Task</h3>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <form id="editTaskForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="task_id" id="edit_task_id">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                                <input type="text" name="title" id="edit_title" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter task title">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea name="description" id="edit_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Enter task description"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                                <select name="status" id="edit_status" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Status</option>
                                    <option value="backlog">Backlog</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                                <select name="priority" id="edit_priority"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date</label>
                                <input type="date" name="due_date" id="edit_due_date"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- In your edit task modal, add this field: -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assign To</label>
                                <select name="assigned_to" id="edit_assigned_to" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Labels</label>
                                <input type="text" name="labels" id="edit_labels"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter labels (comma separated)">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->

            <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex justify-between space-x-3">
                    <button type="button" onclick="deleteTask()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                        <span>Delete</span>
                    </button>
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeModal('editTaskModal')" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">Cancel</button>
                        <button type="submit" form="editTaskForm" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                            <span>Update Task</span>
                            <div id="editTaskSpinner" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Filter Modal -->
    <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-md max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Filter Tasks</h3>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <form id="filterForm">
                        <div class="space-y-4">
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="status[]" value="backlog" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Backlog</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="status[]" value="in-progress" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">In Progress</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="status[]" value="review" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Review</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="status[]" value="done" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Done</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Priority Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="priority[]" value="low" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Low</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="priority[]" value="medium" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Medium</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="priority[]" value="high" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">High</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="priority[]" value="urgent" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" checked>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Urgent</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Due Date Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Due Date</label>
                                <select name="due_date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Dates</option>
                                    <option value="today">Today</option>
                                    <option value="tomorrow">Tomorrow</option>
                                    <option value="week">This Week</option>
                                    <option value="overdue">Overdue</option>
                                    <option value="upcoming">Upcoming</option>
                                </select>
                            </div>

                            <!-- Assignee Filter (if you have this field) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Labels</label>
                                <input type="text" name="labels" placeholder="Filter by labels..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex justify-between space-x-3">
                    <button type="button" onclick="clearFilters()" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                        Clear All
                    </button>
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeModal('filterModal')" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="button" onclick="applyFilters()" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>

    // Handle edit form submission
    document.addEventListener('DOMContentLoaded', function() {

        const editTaskForm = document.getElementById('editTaskForm');

        if (editTaskForm) {
            editTaskForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = e.target;
                const submitButton = document.querySelector('#editTaskModal button[form="editTaskForm"][type="submit"]');

                const spinner = document.getElementById('editTaskSpinner');
                const taskId = document.getElementById('edit_task_id').value;

                // Check if elements exist before using them
                if (!submitButton) {
                    console.error('Submit button not found');
                    return;
                }

                // Show loading state
                submitButton.disabled = true;
                if (spinner) {
                    spinner.classList.remove('hidden');
                }

                try {
                    const formData = new FormData(form);

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showNotification('Task updated successfully!', 'success');
                        closeModal('editTaskModal');

                        // Refresh the page to show updated tasks
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);

                    } else {
                        if (result.errors) {
                            showFormErrors(result.errors);
                        } else {
                            showNotification(result.message || 'Failed to update task', 'error');
                        }
                    }

                } catch (error) {
                    console.error('Error updating task:', error);
                    showNotification('An error occurred while updating the task', 'error');
                } finally {
                    // Reset loading state
                    submitButton.disabled = false;
                    if (spinner) {
                        spinner.classList.add('hidden');
                    }
                }
            });
        }
    });

    // Form submission handling
    const createTaskForm = document.getElementById('createTaskForm');

    if (createTaskForm) {
        createTaskForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;

            const submitButton = document.querySelector('#createTask button[form="createTaskForm"][type="submit"]');
            //const submitButton = form.querySelector('button[type="submit"]');
            const spinner = document.getElementById('createTaskSpinner');

            //submitButton.disabled = true;
            if (spinner) {
                spinner.classList.remove('hidden');
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();
                if (response.ok) {
                    showNotification('Task created successfully!', 'success');
                    closeModal('createTask');
                    form.reset();

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);

                } else {

                    if (result.errors) {
                        showFormErrors(result.errors);
                    } else {
                        showNotification(result.message || 'Failed to create task', 'error');
                    }
                }

            } catch (error) {
                console.error('Error creating task:', error);
                showNotification('An error occurred while creating the task: ' + error.message, 'error');
            } finally {
                // Reset loading state
                submitButton.disabled = false;
                if (spinner) {
                    spinner.classList.add('hidden');
                }
            }
        });
    } else {
        console.warn('Create task form not found');
    }

    function showFormErrors(errors) {
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-gray-300', 'dark:border-gray-600');
        });

        Object.keys(errors).forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.remove('border-gray-300', 'dark:border-gray-600');
                input.classList.add('border-red-500');

                const errorDiv = document.createElement('p');
                errorDiv.className = 'error-message text-red-500 text-xs mt-1';
                errorDiv.textContent = errors[field][0];

                input.parentNode.appendChild(errorDiv);
            }
        });
        showNotification('Please fix the form errors', 'error');
    }

    // Enhanced notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform ${
            type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                    'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
        <div class="flex items-center space-x-2">
            ${type === 'success' ?
            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' :
            type === 'error' ?
                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' :
                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        }
            <span>${message}</span>
        </div>
    `;
        notification.style.transform = 'translateX(100%)';

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 4000);
    }

    // Open edit modal and populate with task data
    async function openEditModal(taskId) {
        try {
            const response = await fetch(`/tasks/${taskId}`);
            if (response.ok) {
                const task = await response.json();

                // Format due_date for HTML input (YYYY-MM-DD)
                let formattedDueDate = '';
                if (task.due_date) {
                    const dueDate = new Date(task.due_date);
                    formattedDueDate = dueDate.toISOString().split('T')[0];
                }

                // Populate form fields
                document.getElementById('edit_task_id').value = task.id;
                document.getElementById('edit_title').value = task.title;
                document.getElementById('edit_description').value = task.description || '';
                document.getElementById('edit_status').value = task.status;
                document.getElementById('edit_priority').value = task.priority || 'medium';
                document.getElementById('edit_due_date').value = formattedDueDate;
                document.getElementById('edit_labels').value = task.labels ? task.labels.join(', ') : '';
                document.getElementById('edit_assigned_to').value = task.assigned_to || '';

                // Set form action
                document.getElementById('editTaskForm').action = `/tasks/${task.id}`;

                // Open modal
                document.getElementById('editTaskModal').classList.remove('hidden');
                document.getElementById('editTaskModal').classList.add('flex');
                document.documentElement.style.overflow = 'hidden';
            }
        } catch (error) {
            console.error('Error fetching task:', error);
            showNotification('Failed to load task data', 'error');
        }
    }

    // Delete task function
    async function deleteTask() {
        const taskId = document.getElementById('edit_task_id').value;

        if (!confirm('Are you sure you want to delete this task?')) {
            return;
        }

        try {
            const response = await fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (response.ok) {
                showNotification('Task deleted successfully!', 'success');
                closeModal('editTaskModal');

                // Refresh the page
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification(result.message || 'Failed to delete task', 'error');
            }
        } catch (error) {
            console.error('Error deleting task:', error);
            showNotification('An error occurred while deleting the task', 'error');
        }
    }

    // Update closeModal function
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.documentElement.style.overflow = '';

            // Reset any loading states
            const spinners = modal.querySelectorAll('.animate-spin');
            spinners.forEach(spinner => {
                spinner.classList.add('hidden');
            });

            const buttons = modal.querySelectorAll('button[type="submit"]');
            buttons.forEach(button => {
                button.disabled = false;
            });
        }
    }

    // Add to your existing openModal function
    function openModal(modalName) {
        const modal = document.getElementById(modalName);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.documentElement.style.overflow = 'hidden';
        }
    }

    // Filter functions
    let currentFilters = {
        status: ['backlog', 'in-progress', 'review', 'done'],
        priority: ['low', 'medium', 'high', 'urgent'],
        due_date: '',
        labels: ''
    };

    // Apply filters
    function applyFilters() {
        const form = document.getElementById('filterForm');
        if (!form) return;

        const formData = new FormData(form);

        // Get selected statuses
        const selectedStatuses = [];
        document.querySelectorAll('input[name="status[]"]:checked').forEach(checkbox => {
            selectedStatuses.push(checkbox.value);
        });

        // Get selected priorities
        const selectedPriorities = [];
        document.querySelectorAll('input[name="priority[]"]:checked').forEach(checkbox => {
            selectedPriorities.push(checkbox.value);
        });

        // Update current filters
        currentFilters = {
            status: selectedStatuses.length > 0 ? selectedStatuses : ['backlog', 'in-progress', 'review', 'done'],
            priority: selectedPriorities.length > 0 ? selectedPriorities : ['low', 'medium', 'high', 'urgent'],
            due_date: formData.get('due_date') || '',
            labels: formData.get('labels') || ''
        };

        // Apply filters to tasks
        filterTasks();
        closeModal('filterModal');

        showNotification('Filters applied successfully!', 'success');
    }

    // Clear all filters
    function clearFilters() {
        currentFilters = {
            status: ['backlog', 'in-progress', 'review', 'done'],
            priority: ['low', 'medium', 'high', 'urgent'],
            due_date: '',
            labels: ''
        };

        // Reset form
        const form = document.getElementById('filterForm');
        if (form) {
            form.reset();
        }

        filterTasks();
        showNotification('Filters cleared!', 'info');
    }

    // Filter tasks based on current filters
    function filterTasks() {
        if (!window.tasksData) return;

        const filteredTasks = window.tasksData.filter(task => {
            let shouldInclude = true;

            // Filter by status
            if (currentFilters.status.length > 0) {
                shouldInclude = shouldInclude && currentFilters.status.includes(task.status);
            }

            // Filter by priority
            if (currentFilters.priority.length > 0) {
                shouldInclude = shouldInclude && currentFilters.priority.includes(task.priority || 'medium');
            }

            // Filter by due date
            if (currentFilters.due_date && task.due_date) {
                shouldInclude = shouldInclude && filterByDueDate(task.due_date, currentFilters.due_date);
            }

            // Filter by labels
            if (currentFilters.labels && task.labels) {
                shouldInclude = shouldInclude && filterByLabels(task.labels, currentFilters.labels);
            }

            return shouldInclude;
        });

        // Render the filtered tasks
       // renderTasks(filteredTasks);
    }

    // Helper functions for due date and label filtering
    function filterByDueDate(taskDueDate, filterType) {
        const dueDate = new Date(taskDueDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        switch (filterType) {
            case 'today':
                return dueDate.toDateString() === today.toDateString();
            case 'tomorrow':
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                return dueDate.toDateString() === tomorrow.toDateString();
            case 'week':
                const weekEnd = new Date(today);
                weekEnd.setDate(weekEnd.getDate() + 7);
                return dueDate >= today && dueDate <= weekEnd;
            case 'overdue':
                return dueDate < today;
            case 'upcoming':
                return dueDate > today;
            default:
                return true;
        }
    }

    function filterByLabels(taskLabels, filterLabels) {
        if (!taskLabels || !Array.isArray(taskLabels)) return false;

        const searchTerms = filterLabels.toLowerCase().split(',').map(term => term.trim());
        return searchTerms.some(term =>
            taskLabels.some(label =>
                label.toLowerCase().includes(term)
            )
        );
    }

    // Open filter modal
    function openFilterModal() {
        // Set current filter values in the form
        const form = document.getElementById('filterForm');
        if (!form) return;

        // Set status checkboxes
        document.querySelectorAll('input[name="status[]"]').forEach(checkbox => {
            checkbox.checked = currentFilters.status.includes(checkbox.value);
        });

        // Set priority checkboxes
        document.querySelectorAll('input[name="priority[]"]').forEach(checkbox => {
            checkbox.checked = currentFilters.priority.includes(checkbox.value);
        });

        // Set due date
        const dueDateSelect = form.querySelector('select[name="due_date"]');
        if (dueDateSelect) {
            dueDateSelect.value = currentFilters.due_date;
        }

        // Set labels
        const labelsInput = form.querySelector('input[name="labels"]');
        if (labelsInput) {
            labelsInput.value = currentFilters.labels;
        }

        openModal('filterModal');
    }

</script>
