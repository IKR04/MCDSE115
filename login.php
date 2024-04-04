<?php
session_start();
 include 'nav1.php';
include 'footer.php';
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
          body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding-top: 50px;
        }
        form {
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Form</h2>
        <?php 
        // Display login error message if set
        if (isset($_SESSION['login_error'])) {
            echo "<p>{$_SESSION['login_error']}</p>";
            unset($_SESSION['login_error']); // Clear error message
        }
        ?>
        <form action="login_process.php" method="POST">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="code"><b>2FA Code</b></label>
            <input type="text" placeholder="Enter 2FA Code" name="code" required>

            <button type="submit">Login</button>
        </form>
    </div>
    <?php include 'footer.php';?>
</body>
</html>
