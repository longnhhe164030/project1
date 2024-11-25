        <?php
        class Task {
            private $title;
            private $status;
            private $content;

            public function __construct($title, $status, $content){
                $this->title = $title;
                $this->status = $status;    
                $this->content = $content;
            }
            
            public function toArray(){
                return [
                    'title' => $this->title,
                    'status' => $this->status,
                    'content' => $this->content
                ];
            }
        }

        class user {
            private $username;
            private $password;
        
            public function __construct($username, $password) {
                $this->username = $username;
                $this->password = $password;
            }
        }

        class ToDoList {
            private $username;
            private $file;

        public function __construct($username, $file = 'ToDoList.json') {
            $this->username = $username;
            $this->file = $file;
            } 

        private function loadTodos() {
            return json_decode(file_get_contents($this->file), true) ?? [];
        }

        private function saveTodos($todos) {
            file_put_contents($this->file, json_encode($todos, JSON_PRETTY_PRINT));
        }

        public function getTodos() {
            $todos = $this->loadTodos();
            foreach ($todos as $userTodos) {
                if ($userTodos['username'] === $this->username) {
                    return $userTodos['tasks'];
                }
            }
            return [];
        }

        public function addTask(Task $task){
            $todos = $this->loadTodos();
            foreach ($todos as &$userTodos) {
                if ($userTodos['username'] === $this->username) {
                    $userTodos['tasks'][] = $task->toArray();
                    $this->saveTodos($todos);
                    return "Task add successfully!";   
                }
            }
            $todos[] = ['username' => $this->username, 'tasks' => [$task->toArray()]];
            $this->saveTodos($todos);
            return "Task added successfully!";
        }

        public function editTask($title,Task $newTask){
            $todos = $this->loadTodos();
            foreach($todos as &$userTodos){
                if ($userTodos['username'] === $this->username){
                    foreach ($userTodos['tasks'] as &$task) {
                        if ($task['title'] === $title) {
                            $task = $newTask->toArray();
                            $this->saveTodos($todos);
                            return "Task updated successfully!";
                        }
                    }
                }
            }
            return "Task not found!"; 
        }
        public function deleteTask($title){
            $todos = $this->loadTodos();
            foreach($todos as &$userTodos){
                if ($userTodos['username'] === $this->username){
                    $userTodos['tasks'] = array_filter($userTodos['tasks'], function ($task) use ($title) {
                        return $task['title'] !== $title;
                    });
                    $this->saveTodos($todos);
                    return "Task delete successfully!";
                }
            }
            return "Task not found";
        }
    }
?>
