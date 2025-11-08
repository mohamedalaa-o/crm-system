
<!DOCTYPE html>
<html lang="en" dir="ltr" id="htmlTag">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRM Dashboard - Ultimate Redesign</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
/* Base Styles */
body {
    background-color: #f9fafb;
    color: #1f2937; /* نص أسود/رمادي غامق */
    font-family: 'Inter', sans-serif;
    transition: background-color 0.5s ease, color 0.5s ease;
}
.dark body {
    background-color: #111827;
    color: #f3f4f6; /* نص أبيض/رمادي فاتح */
}

/* Sidebar */
#sidebar {
    background-color: #ffffff;
    border-right: 1px solid #e5e7eb;
    transition: margin-left 0.3s ease, background-color 0.5s ease;
}
.dark #sidebar {
    background-color: #1f2937;
    border-color: #374151;
}
#sidebar.collapsed {
    margin-left: -16rem;
}
#sidebar .sidebar-item {
    color: #1f2937;
    padding: 8px 12px;
    border-radius: 8px;
    transition: background-color 0.3s;
}
.dark #sidebar .sidebar-item {
    color: #e5e7eb;
}
#sidebar .sidebar-item:hover {
    background-color: #f3f4f6;
}
.dark #sidebar .sidebar-item:hover {
    background-color: #374151;
}

/* Main Content */
.main-content {
    background-color: #f9fafb;
}
.dark .main-content {
    background-color: #111827;
}

/* Board */
.board {
    background-color: #ffffff;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 20px;
    min-width: 340px;
}
.dark .board {
    background-color: #1f2937;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
}

/* Task Column */
.task-column {
    background-color: #f3f4f6;
    border-radius: 8px;
    padding: 12px;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.dark .task-column {
    background-color: #374151;
}

/* Task Card */
.task-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    cursor: grab;
    position: relative;
    color: #1f2937;
}
.dark .task-card {
    background-color: #374151;
    border-color: #4b5563;
    color: #f3f4f6;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Priority Borders */
.priority-high { border-left: 5px solid #ef4444; }
.priority-medium { border-left: 5px solid #f97316; }
.priority-low { border-left: 5px solid #22c55e; }

/* Priority Text */
.text-priority-high { color: #dc2626; }
.text-priority-medium { color: #ea580c; }
.text-priority-low { color: #16a34a; }
.dark .text-priority-high { color: #f87171; }
.dark .text-priority-medium { color: #fb923c; }
.dark .text-priority-low { color: #4ade80; }

/* Sortable Ghost */
.sortable-ghost {
    opacity: 0.3;
    background-color: #e5e7eb !important;
    border: 1px dashed #9ca3af !important;
}
.dark .sortable-ghost {
    background-color: #4b5563 !important;
    border: 1px dashed #6b7280 !important;
}

/* Modal */
.modal-content {
    background-color: #ffffff;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}
.dark .modal-content {
    background-color: #1f2937;
}
.modal-input {
    background-color: #f9fafb;
    border: 1px solid #d1d5db;
    color: #1f2937;
    padding: 12px;
    border-radius: 8px;
}
.dark .modal-input {
    background-color: #374151;
    border-color: #4b5563;
    color: #f3f4f6;
}
.modal-button {
    background-color: #6366f1;
    color: white;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
}
.modal-button:hover {
    opacity: 0.9;
}

/* Calendar */
#calendarContainer {
    background-color: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
.dark #calendarContainer {
    background-color: #1f2937;
}
.fc .fc-toolbar-title,
.fc .fc-col-header-cell,
.fc .fc-daygrid-day-number {
    color: #1f2937;
}
.dark .fc .fc-toolbar-title,
.dark .fc .fc-col-header-cell,
.dark .fc .fc-daygrid-day-number {
    color: #f3f4f6;
}
.fc .fc-button-primary {
    background-color: #3b82f6 !important;
    border: none !important;
    color: white !important;
}
.fc .fc-button-primary:hover {
    background-color: #2563eb !important;
}
.dark .fc .fc-button-primary {
    background-color: #1d4ed8 !important;
}
.dark .fc .fc-button-primary:hover {
    background-color: #1e40af !important;
}
</style>
</head>

<body class="font-sans flex transition-all duration-500 min-h-screen">
<div id="sidebar" class="w-64 flex-shrink-0 flex flex-col transition-all duration-300">
    <div class="sidebar-header p-4 text-xl font-bold border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        My Workspace
        <button id="toggleSidebar" class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white text-2xl leading-none">
            <span id="sidebarIcon"><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-2">
        <button id="addBoardSidebarBtn" class="w-full text-left px-3 py-2 mb-2 rounded sidebar-item font-semibold text-blue-600 dark:text-blue-400 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> New Board
        </button>
        <div id="boardsList" class="space-y-1"></div>
    </div>
</div>

<div class="flex-1 flex flex-col overflow-auto p-8 main-content transition-all duration-500">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-extrabold text-blue-700 dark:text-blue-400 tracking-wide">
            <i class="fas fa-cubes text-blue-500 dark:text-blue-300 mr-2"></i> CRM Dashboard
        </h1>
        <button id="toggleTheme" class="bg-gray-800 dark:bg-white text-white dark:text-gray-900 px-5 py-2 rounded-lg font-medium shadow-md transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-moon"></i> Dark Mode
        </button>
    </div>

    <div class="flex flex-wrap gap-4 mb-8">
        <button class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center gap-2">
            <i class="fas fa-chart-bar"></i> Reports
        </button>
        <button class="bg-green-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors duration-300 flex items-center gap-2" id="showCalendar">
            <i class="fas fa-calendar-alt"></i> Calendar
        </button>
        <button class="bg-purple-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors duration-300 flex items-center gap-2" id="addBoardBtn">
            <i class="fas fa-plus-square"></i> Add Board
        </button>
    </div>

    <div class="flex gap-8 overflow-x-auto pb-6" id="boards-container"></div>

    <div id="calendarContainer" class="hidden mt-8">
        <div id="calendar" class="h-[600px]"></div>
    </div>
</div>

<!-- Board Modal -->
<div id="boardModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50">
    <div class="modal-content w-96 transform scale-95 opacity-0 transition-all duration-300">
        <h3 class="text-2xl font-bold mb-5">Add New Board</h3>
        <input type="text" id="boardTitle" placeholder="Board Title" class="modal-input w-full mb-4 rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
        <div class="mb-5">
            <label for="boardColor" class="block text-sm font-medium mb-2">Select Board Color</label>
            <input type="color" id="boardColor" value="#4f46e5" class="w-full h-12 p-1 border border-gray-300 dark:border-gray-600 rounded-md cursor-pointer">
        </div>
        <button id="saveBoardBtn" class="modal-button bg-purple-600 w-full py-3 text-lg">
            <i class="fas fa-save"></i> Save Board
        </button>
        <button id="closeBoardModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white text-3xl">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- Task Modal -->
<div id="taskModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50">
    <div class="modal-content w-96 transform scale-95 opacity-0 transition-all duration-300">
        <h3 class="text-2xl font-bold mb-5">Add / Edit Task</h3>
        <input type="text" id="taskTitle" placeholder="Task Title" class="modal-input w-full mb-4 rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
        <select id="taskPriority" class="modal-input w-full mb-4 rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="High">High Priority</option>
            <option value="Medium">Medium Priority</option>
            <option value="Low">Low Priority</option>
        </select>
        <input type="date" id="taskDeadline" class="modal-input w-full mb-5 rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
        <button id="saveTaskBtn" class="modal-button bg-blue-600 w-full py-3 text-lg">
            <i class="fas fa-check-circle"></i> Save Task
        </button>
        <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white text-3xl">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<script>
// Utility: Contrast Color
function getContrastColor(hex) {
    if (!hex) return '#000000';
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    const yiq = (r * 299 + g * 587 + b * 114) / 1000;
    return yiq >= 128 ? '#000000' : '#ffffff';
}

let calendarInstance = null;

// Theme Toggle
function initializeTheme() {
    const html = document.getElementById('htmlTag');
    const btn = document.getElementById('toggleTheme');
    const isDark = localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

    if (isDark) {
        html.classList.add('dark');
        btn.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
    } else {
        html.classList.remove('dark');
        btn.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
    }
}

document.getElementById('toggleTheme').addEventListener('click', () => {
    const html = document.getElementById('htmlTag');
    const btn = document.getElementById('toggleTheme');
    html.classList.toggle('dark');
    const isDark = html.classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    btn.innerHTML = isDark ? '<i class="fas fa-sun"></i> Light Mode' : '<i class="fas fa-moon"></i> Dark Mode';

    if (!document.getElementById('calendarContainer').classList.contains('hidden')) {
        renderCalendar();
    }
});

// Sidebar Toggle
document.getElementById('toggleSidebar').addEventListener('click', () => {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('sidebarIcon');
    sidebar.classList.toggle('collapsed');
    icon.innerHTML = sidebar.classList.contains('collapsed') ? '<i class="fas fa-bars"></i>' : '<i class="fas fa-times"></i>';
});

// Modal Functions
function openModal(id) {
    const modal = document.getElementById(id);
    const content = modal.querySelector('.modal-content');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.style.opacity = '1';
        content.classList.replace('scale-95', 'scale-100');
        content.classList.replace('opacity-0', 'opacity-100');
    }, 10);
}

function closeCustomModal(id) {
    const modal = document.getElementById(id);
    const content = modal.querySelector('.modal-content');
    modal.style.opacity = '0';
    content.classList.replace('scale-100', 'scale-95');
    content.classList.replace('opacity-100', 'opacity-0');
    modal.addEventListener('transitionend', () => modal.classList.add('hidden'), { once: true });
}

// Board & Task Logic
const boardsContainer = document.getElementById('boards-container');
const boardsList = document.getElementById('boardsList');

document.getElementById('addBoardBtn').addEventListener('click', () => openModal('boardModal'));
document.getElementById('addBoardSidebarBtn').addEventListener('click', () => openModal('boardModal'));
document.getElementById('closeBoardModal').addEventListener('click', () => closeCustomModal('boardModal'));

document.getElementById('saveBoardBtn').addEventListener('click', () => {
    const title = document.getElementById('boardTitle').value.trim();
    const color = document.getElementById('boardColor').value;
    if (!title) return alert('Please enter a board title.');

    const id = title.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');

    // Sidebar
    const item = document.createElement('div');
    item.className = 'px-3 py-2 sidebar-item rounded cursor-pointer flex items-center gap-2';
    item.innerHTML = `<i class="fas fa-project-diagram"></i> ${title}`;
    item.dataset.boardId = id;
    boardsList.appendChild(item);

    // Board
    const board = createBoardElement(id, title, color);
    boardsContainer.appendChild(board);

    closeCustomModal('boardModal');
    document.getElementById('boardTitle').value = '';
    initializeTasks();
    initializeSortable();
});

function createBoardElement(id, title, color) {
    const div = document.createElement('div');
    div.className = 'board min-w-[340px] flex-shrink-0 border-t-4';
    div.style.borderTopColor = color;
    div.dataset.boardId = id;

    const btnStyle = `background-color: ${color}; color: ${getContrastColor(color)};`;

    div.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">${title}</h2>
            <span class="text-sm text-green-600 dark:text-green-400">Active</span>
        </div>
        <div class="flex flex-col sm:flex-row gap-4">
            ${['TODO', 'IN-PROGRESS', 'DONE'].map(status => `
                <div class="flex-1">
                    <h3 class="font-semibold text-lg mb-3">${status}</h3>
                    <div class="task-column" data-status="${status.toLowerCase().replace('-', '')}" data-board-id="${id}"></div>
                    <button class="add-task-btn mt-4 w-full py-2 rounded-md text-sm font-medium flex items-center justify-center gap-1" style="${btnStyle} hover:opacity-80">
                        <i class="fas fa-plus"></i> Add Task
                    </button>
                </div>
            `).join('')}
        </div>
    `;
    return div;
}

let currentColumn = null;
function initializeTasks() {
    document.querySelectorAll('.add-task-btn').forEach(btn => {
        btn.onclick = e => {
            currentColumn = e.target.previousElementSibling;
            openModal('taskModal');
            document.getElementById('taskTitle').value = '';
            document.getElementById('taskPriority').value = 'Medium';
            document.getElementById('taskDeadline').value = '';
        };
    });

    document.getElementById('closeModal').onclick = () => closeCustomModal('taskModal');
    document.getElementById('saveTaskBtn').onclick = () => {
        const title = document.getElementById('taskTitle').value.trim();
        const priority = document.getElementById('taskPriority').value;
        const deadline = document.getElementById('taskDeadline').value;
        if (!title) return alert('Please enter a task title.');

        const card = document.createElement('div');
        card.className = `task-card priority-${priority.toLowerCase()}`;
        card.dataset.priority = priority;
        card.dataset.deadline = deadline;

        card.innerHTML = `
            <div class="handle">
                <h4 class="font-bold">${title}</h4>
                <p class="text-xs text-priority-${priority.toLowerCase()}"><i class="fas fa-exclamation-circle"></i> ${priority}</p>
                ${deadline ? `<p class="text-xs text-gray-500 dark:text-gray-400"><i class="fas fa-calendar-alt"></i> ${deadline}</p>` : ''}
            </div>
            <button class="delete-task absolute top-2 right-2 text-gray-400 hover:text-red-500">
                <i class="fas fa-trash-alt"></i>
            </button>
        `;
        currentColumn.appendChild(card);
        closeCustomModal('taskModal');
        initializeSortable();
        initializeDelete();
    };
}

function initializeSortable() {
    document.querySelectorAll('.task-column').forEach(col => {
        if (!col._sortable) {
            col._sortable = new Sortable(col, {
                group: 'tasks',
                animation: 150,
                draggable: '.task-card',
                handle: '.handle',
                ghostClass: 'sortable-ghost'
            });
        }
    });
}

function initializeDelete() {
    document.querySelectorAll('.delete-task').forEach(btn => {
        if (!btn.dataset.listener) {
            btn.onclick = () => btn.closest('.task-card').remove();
            btn.dataset.listener = 'true';
        }
    });
}

// Calendar
document.getElementById('showCalendar').onclick = () => {
    const container = document.getElementById('calendarContainer');
    container.classList.toggle('hidden');
    if (!container.classList.contains('hidden')) renderCalendar();
};

function renderCalendar() {
    const events = [];
    document.querySelectorAll('.task-card').forEach(card => {
        const title = card.querySelector('h4').textContent;
        const deadline = card.dataset.deadline;
        const priority = card.dataset.priority;
        if (deadline) {
            events.push({
                title: `${title} (${priority})`,
                start: deadline,
                allDay: true,
                color: priority === 'High' ? '#ef4444' : priority === 'Medium' ? '#f97316' : '#22c55e'
            });
        }
    });

    const el = document.getElementById('calendar');
    if (calendarInstance) calendarInstance.destroy();

    calendarInstance = new FullCalendar.Calendar(el, {
        initialView: 'dayGridMonth',
        events: events,
        height: 'auto',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
        themeSystem: 'standard'
    });
    calendarInstance.render();
}

// Initial Setup
function initialAppSetup() {
    initializeTheme();

    const defaultBoards = [
        { id: 'alpha', title: 'Project Alpha', color: '#3b82f6' },
        { id: 'beta', title: 'Project Beta', color: '#9333ea' },
        { id: 'backend', title: 'Back-end', color: '#ef4444' }
    ];

    defaultBoards.forEach(b => {
        const item = document.createElement('div');
        item.className = 'px-3 py-2 sidebar-item rounded cursor-pointer flex items-center gap-2';
        item.innerHTML = `<i class="fas fa-project-diagram"></i> ${b.title}`;
        item.dataset.boardId = b.id;
        boardsList.appendChild(item);

        boardsContainer.appendChild(createBoardElement(b.id, b.title, b.color));
    });

    // Example Tasks
    const add = (board, status, title, pri, date) => {
        const col = document.querySelector(`.task-column[data-board-id="${board}"][data-status="${status}"]`);
        if (col) {
            const card = document.createElement('div');
            card.className = `task-card priority-${pri.toLowerCase()}`;
            card.dataset.priority = pri;
            card.dataset.deadline = date;
            card.innerHTML = `
                <div class="handle">
                    <h4 class="font-bold">${title}</h4>
                    <p class="text-xs text-priority-${pri.toLowerCase()}"><i class="fas fa-exclamation-circle"></i> ${pri}</p>
                    ${date ? `<p class="text-xs text-gray-500 dark:text-gray-400"><i class="fas fa-calendar-alt"></i> ${date}</p>` : ''}
                </div>
                <button class="delete-task absolute top-2 right-2 text-gray-400 hover:text-red-500"><i class="fas fa-trash-alt"></i></button>
            `;
            col.appendChild(card);
        }
    };

    add('alpha', 'todo', 'Implement User Auth', 'High', '2025-12-25');
    add('alpha', 'in-progress', 'Design UI/UX', 'Medium', '2025-11-20');
    add('beta', 'todo', 'Market Research', 'Low', '2025-11-30');
    add('backend', 'done', 'API Setup', 'High', '2025-10-01');

    initializeTasks();
    initializeSortable();
    initializeDelete();
}

document.addEventListener('DOMContentLoaded', initialAppSetup);
</script>
</body>
</html>



