<?php
session_start();
 include 'nav1.php';
include 'footer.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'connection.php'; 

// Retrieve user information from session or database
$username = $_SESSION['username'];

// Check if form is submitted for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if new username is provided
    if (!empty($_POST['new_username'])) {
        $newUsername = $_POST['new_username'];
        // Update username in the database
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
        $stmt->bind_param("ss", $newUsername, $username);
        $stmt->execute();
        // Update username in session
        $_SESSION['username'] = $newUsername;
        $username = $newUsername; // Update username variable
        $stmt->close();
    }

    // Check if new email is provided
    if (!empty($_POST['new_email'])) {
        $newEmail = $_POST['new_email'];
        // Update email in the database
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
        $stmt->bind_param("ss", $newEmail, $username);
        $stmt->execute();
        $stmt->close();
    }

    // Check if new password is provided
    if (!empty($_POST['new_password'])) {
        $newPassword = $_POST['new_password'];
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        // Update password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashedPassword, $username);
        $stmt->execute();
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
       <style>
          body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 50px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            margin-bottom: 10px;
        }
        form {
            display: inline-block;
            text-align: left;
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .logout {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        <p><strong>Username:</strong> <?php echo $username; ?></p>
     
        <form action="" method="POST">
            <label for="new_username">New Username:</label>
            <input type="text" id="new_username" name="new_username" placeholder="Enter New Username">

            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="new_email" placeholder="Enter New Email">

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter New Password">

            <button type="submit">Update</button>
        </form>

        <form action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
