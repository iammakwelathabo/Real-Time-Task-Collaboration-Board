 Real-Time Task Collaboration Board

A real-time Kanban-style task management system built with Laravel, JavaScript, and Laravel Reverb.
This app allows teams to create, assign, and update tasks live — no page refresh required. Perfect for project tracking, collaboration, and team productivity.

 Features

 Real-Time Updates – Task status and changes update instantly for all users via Laravel Echo and Pusher.
 Drag & Drop Kanban Board – Move tasks easily between columns (Backlog, In Progress, Review, Done).
 Task CRUD – Create, read, update, and delete tasks directly from the board.
 Statistics Dashboard – Auto-updating task stats (total, completed, overdue, etc.).
 User Authentication – Secure login and logout functionality via Laravel Breeze.
 Responsive Design – Works seamlessly on desktop, tablet, and mobile.

1.Clone the Repository
    git clone https://github.com/iammakwelathabo/Real-Time-Task-Collaboration-Board.git
    cd Real-Time-Task-Collaboration-Board
    
2.Install Dependencies
    composer install
    npm install
    
3.Create Environment File
    cp .env.example .env

APP_NAME="Real-Time Task Board"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskboard
DB_USERNAME=root
DB_PASSWORD=

4.Run Migrations
    php artisan migrate

5.Compile Frontend Assets
    npm run dev

6.Start the Server
    php artisan serve

How It Works

User Authentication – Login or register to access your dashboard.
Task Creation – Click the “Add Task” button and fill in details.
Drag & Drop – Move tasks between columns (Backlog → In Progress → Review → Done).
Real-Time Sync – All changes are instantly broadcast to other users via Reverb.
Statistics Update – The dashboard updates counts dynamically (completed, overdue, etc.).

{
  "id": 12,
  "title": "Fix login bug",
  "description": "Resolve redirect issue after login",
  "status": "in-progress",
  "priority": "high",
  "assignee": {
    "id": 5,
    "name": "Thabo Makwela"
  },
  "due_date": "2025-10-28"
}

Step 1: Install Laravel Reverb
    composer require laravel/reverb

Step 2: Publish Reverb Configuration
    php artisan vendor:publish --tag=reverb-config

Step 3: Configure .env
    BROADCAST_CONNECTION=reverb
    BROADCAST_DRIVER=reverb
    REVERB_APP_ID=******
    REVERB_APP_KEY=*****
    REVERB_APP_SECRET=******
    REVERB_HOST="localhost"
    REVERB_PORT=8080
    REVERB_SCHEME=http
    VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
    VITE_REVERB_HOST="${REVERB_HOST}"
    VITE_REVERB_PORT="${REVERB_PORT}"
    VITE_REVERB_SCHEME="${REVERB_SCHEME}"

Step 4: Update Broadcasting Configuration
    open config/broadcasting.php - includes the Reverb connection: (create the file if it doesn't exist)
    'reverb' => [
    'driver' => 'reverb',
    'app_id' => env('REVERB_APP_ID'),
    'key' => env('REVERB_APP_KEY'),
    'secret' => env('REVERB_APP_SECRET'),
    'host' => env('REVERB_HOST', '127.0.0.1'),
    'port' => env('REVERB_PORT', 8080),
    'scheme' => env('REVERB_SCHEME', 'http'),
],

Step 5: Start the Reverb Server
    php artisan reverb:start - (Keep this running in a separate terminal tab.)

Step 6: Configure Laravel Echo (Frontend)
    import Echo from 'laravel-echo';
    import Reverb from 'reverb-js';
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT,
        forceTLS: false,
        disableStats: true,
});

Step 7: Listen for Events
    window.Echo.channel('tasks')
    .listen('App\\Events\\TaskUpdated', (e) => {
        console.log('Task updated:', e.task);
    });

Step 8: Broadcasting Events from Laravel
    use Illuminate\Broadcasting\InteractsWithSockets;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
    class TaskUpdated implements ShouldBroadcast
    {
        use InteractsWithSockets;
    
        public $task;
    
        public function __construct($task)
        {
            $this->task = $task;
        }
    
        public function broadcastOn()
        {
            return ['tasks'];
        }
    }

    
Broadcast the event from your controller:
event(new TaskUpdated($task));

Troubleshooting

Make sure the Reverb server is running.
Ensure BROADCAST_DRIVER=reverb in .env.
If using HTTPS, set REVERB_SCHEME=https.
If your frontend is on another port (e.g., Vite), allow CORS in config/reverb.php.

License
This project is licensed under the MIT License – you are free to use, modify, and distribute with attribution.

Author
Thabo Makwela

Full Stack Developer

platformdeveloping@gmail.com

Preview



https://github.com/user-attachments/assets/2d406b72-17d4-4494-9744-eae9e01ec01c



<img width="1336" height="600" alt="dashboard" src="https://github.com/user-attachments/assets/bdb9a127-fd34-4059-b3c4-4437c424dcb7" />


<img width="1336" height="593" alt="create task" src="https://github.com/user-attachments/assets/fa640ed8-c59d-49d9-bdc4-b3043997b87d" />


<img width="1340" height="597" alt="edit task" src="https://github.com/user-attachments/assets/fa509591-98d3-4948-abb3-89295d3f9590" />
