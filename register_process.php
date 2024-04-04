<?php
session_start();
require 'connection.php';
require 'GoogleAuthenticator.php'; 

// Function to securely hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to create a new user account with 2FA
function createUserWith2FA($conn, $username, $email, $password, $role) {
    $hashedPassword = hashPassword($password);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, enable_2fa) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
    $stmt->execute();
    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Perform validation 
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['registration_error'] = "All fields are required!";
        header("Location: register.php");
        exit();
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($result->num_rows > 0) {
            $_SESSION['registration_error'] = "Username or email already exists!";
            header("Location: register.php");
            exit();
        } else {
            // Create new user with 2FA
            createUserWith2FA($conn, $username, $email, $password, $role);
            $_SESSION['registration_success'] = "Registration successful!";
            $_SESSION['new_username'] = $username;
            
            // Generate secret key for 2FA
            $ga = new PHPGangsta_GoogleAuthenticator();
            $secretKey = $ga->createSecret();
                
            // Store secret key in session
            $_SESSION['secret_key'] = $secretKey;
                
            // Redirect to setup 2FA page
            header("Location: setup_2fa.php");
            exit();
        }
    }
}
?>
