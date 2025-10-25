Real-Time Task Collaboration Board

A real-time Kanban-style task management system built with Laravel, and JavaScript.
This app allows teams to create, assign, and update tasks . Perfect for project tracking, collaboration, and team productivity.

 Features

 Real-Time Updates – Task status and changes update instantly for all users via Laravel Echo and Pusher.
 Drag & Drop Kanban Board – Move tasks easily between columns (Backlog, In Progress, Review, Done).
 Task CRUD – Create, read, update, and delete tasks directly from the board.
 Statistics Dashboard – Auto-updating task stats (total, completed, overdue, etc.).
 User Authentication – Secure login and logout functionality via Laravel Breeze or Fortify.
 Responsive Design – Works seamlessly on desktop, tablet, and mobile.
 Dark Mode Support – Adaptive UI with light/dark theme toggling.

 Tech Stack
    Layer	Technology
    Backend	Laravel 11 / PHP 8+
    Frontend	HTML, Tailwind CSS, Vanilla JavaScript
    Database	MySQL / MariaDB
    Auth	Laravel Breeze
    Server	Apache / Nginx

Folder Structure

real-time-task-collaboration-board/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TaskController.php
│   │   │   └── Auth/
│   │   │       └── AuthenticatedSessionController.php
│   ├── Models/
│   │   └── Task.php
│   └── Events/
│       └── TaskUpdated.php
│
├── public/
│   ├── js/
│   │   └── tasks.js
│   └── css/
│       └── app.css
│
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php
│   │   ├── tasks/
│   │   │   └── index.blade.php
│   │   └── auth/
│   │       ├── login.blade.php
│   │       └── register.blade.php
│   └── js/
│       └── echo.js
│
├── routes/
│   └── web.php
│
├── composer.json
├── package.json
├── webpack.mix.js
└── README.md


⚙️ Installation Guide
1️⃣ Clone the Repository
    git clone https://github.com/your-username/Real-Time-Task-Collaboration-Board.git
    cd Real-Time-Task-Collaboration-Board
    
2️⃣ Install Dependencies
    composer install
    npm install

3️⃣ Create Environment File
    cp .env.example .env

Update your .env file with your local database and Pusher credentials:

APP_NAME="Real-Time Task Board"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskboard
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Run Migrations
    php artisan migrate

5️⃣ Compile Frontend Assets
    npm run dev

6️⃣ Start the Server
    php artisan serve
    http://127.0.0.1:8000

How It Works:

User Authentication – Login or register to access your dashboard.

Task Creation – Click the “Add Task” button and fill in details.

Drag & Drop – Move tasks between columns (Backlog → In Progress → Review → Done).

Statistics Update – The dashboard updates counts dynamically (completed, overdue, etc.).

Example Task Object

{
  "id": 12,
  "title": "Fix login bug",
  "description": "Resolve redirect issue after login",
  "status": "in-progress",
  "priority": "high",
  "assignee": {
    "id": 5,
    "name": "Thabo Moeti"
  },
  "due_date": "2025-10-28"
}


Contribution:
Contributions are welcome!
Fork this repo
Create your feature branch (git checkout -b feature/new-feature)
Commit your changes (git commit -m 'Add new feature')
Push to branch (git push origin feature/new-feature)
Create a Pull Request


License

This project is licensed under the MIT License – you are free to use, modify, and distribute with attribution.

Author

Thabo Makwela
Full Stack Developer


