<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .register-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .register-container label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .register-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </div>
    <?php
    $file = "users.json";

    function saveDataJSON($file, $username, $email, $password) {
        $contact = [
            "username" => $username,
            "email" => $email,
            "password" => $password
        ];
        $data = [];
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
        }
        $data[] = $contact;
        $result = file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        return $result !== false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $email = trim($_POST["email"]);

        if (empty($username) || empty($password) || empty($email)) {
            echo "<p style='color: red; text-align: center;'>Must fill all the information.</p>";
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color: red; text-align: center;'>Invalid email</p>";
            exit();
        }

        if (saveDataJSON($file, $username, $email, $password)) {
            echo "<p style='color: green; text-align: center;'>Registration successful!</p>";
            echo "<p style='text-align: center;'>Your data has been saved.</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Failed to save data.</p>";
        }
    }
    ?>
</body>
</html>
