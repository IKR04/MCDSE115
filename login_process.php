<?php
session_start();

require 'connection.php';
require 'GoogleAuthenticator.php'; // library PHPGangsta's GoogleAuthenticator

// Function to verify password against hashed password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Function to verify a 2FA code
function verify2FACode($secretKey, $code) {
    $ga = new PHPGangsta_GoogleAuthenticator();
    return $ga->verifyCode($secretKey, $code);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $code = $_POST['code']; // 2FA code entered by the user

    // Perform validation 
    if (empty($username) || empty($password) || empty($code)) {
        $_SESSION['login_error'] = "Username, password, and 2FA code are required!";
        header("Location: login.php");
        exit();
    }

    // Check if username exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows != 1) {
        // Username does not exist
        $_SESSION['login_error'] = "Invalid username!";
        header("Location: login.php");
        exit();
    }

    // Username exists, verify password
    $row = $result->fetch_assoc();
    if (!verifyPassword($password, $row['password'])) {
        // Invalid password
        $_SESSION['login_error'] = "Invalid password!";
        header("Location: login.php");
        exit();
    }

    // Password is correct, check if 2FA is enabled for the user
    if (isset($row['secret_key'])) {
        // 2FA is enabled for the user, verify 2FA code
        if (!verify2FACode($row['secret_key'], $code)) {
            // Invalid 2FA code
            $_SESSION['login_error'] = "Invalid 2FA code!";
            header("Location: login.php");
            exit();
        }
    }

    // Set up session
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user_id;

    // Redirect based on user role
    if ($row['role'] === 'Admin') {
        $role = "admin"; 
$_SESSION['role'] = $role; 
        header("Location: admin_dashboard.php");
    } else { 
        header("Location: mainpage.php");
    }
    exit();
}
?>
