<?php
require_once 'class.php';

session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit(); 
}
$username = $_SESSION['username'];
$todoList = new ToDoList($username);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $action = $_POST['action'];
    if($action === 'add'){
        $task = new Task($_POST['title'],$_POST['status'],$_POST['content']);
        echo $todoList->addTask($task);
    }elseif($action === 'edit'){
        $task = new Task($_POST['title'],$_POST['status'],$_POST['content']);
        echo $todoList->editTask($_POST['original_title'],$task);
    }elseif($action === 'delete'){
        echo $todoList->deleteTask($_POST['title']);
    }
}

$tasks = $todoList->getTodos();
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Welcome, <?= htmlspecialchars($username) ?></h2>
    <h3>Your Todos:</h3>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li><?= htmlspecialchars($task['title']) ?> - <?= htmlspecialchars($task['status']) ?>: <?= htmlspecialchars($task['content']) ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="POST">
        <h3>Add Task</h3>
        <input type="text" name="title" placeholder="Task title" required>
        <select name="status">
            <option value="incompleted">Incompleted</option>
            <option value="completed">Completed</option>
        </select>
        <textarea name="content" placeholder="Task content"></textarea>
        <button type="submit" name="action" value="add">Add Task</button>
    </form>

    <form method="POST">
        <h3>Edit Task</h3>
        <input type="text" name="original_title" placeholder="Original title" required>
        <input type="text" name="title" placeholder="New title" required>
        <select name="status">
            <option value="incompleted">Incompleted</option>
            <option value="completed">Completed</option>
        </select>
        <textarea name="content" placeholder="New content"></textarea>
        <button type="submit" name="action" value="edit">Edit Task</button>
    </form>

    <form method="POST">
        <h3>Delete Task</h3>
        <input type="text" name="title" placeholder="Task title to delete" required>
        <button type="submit" name="action" value="delete">Delete Task</button>
    </form>
</body>
</html>