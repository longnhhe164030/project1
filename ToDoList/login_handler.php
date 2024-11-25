<?php
$file = "users.json";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = json_decode(file_get_contents($file),true);
    foreach ($users as $user) {
        if($user["username"] == $username && $user["password"]== $password){
            session_start();
            $_SESSION["username"] = $username;
            header("Location: todos.php");
            exit();
        }
    }
echo "Invalid username or password";
}
?>