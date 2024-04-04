<?php include 'nav.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
          body {
            margin: 0;
            font-family: Arial, sans-serif;
            padding-bottom: 60px;
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
        input[type=text], 
        input[type=password], 
        input[type=email], 
        select {
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
        .info {
            margin-top: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <?php 
        if (isset($_SESSION['registration_error'])) {
            echo "<p>{$_SESSION['registration_error']}</p>";
            unset($_SESSION['registration_error']);
        }
        ?>
        <form action="register_process.php" method="POST">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="role"><b>Role</b></label>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
            
            <div class="info">Two-Factor Authentication (2FA) is enabled by default for added security.</div>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
