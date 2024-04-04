<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['username'])) {
    include 'nav.php';
} else {
    include 'nav1.php';
}
include 'footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px; 
            text-decoration: none; 
        }

        .button-container button:hover {
            background-color: #555;
        }

        a {
            text-decoration: none;
            color: white; 
        }

        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body>
    <h2>Booking Confirmation</h2>
    <p>Your workspace booking has been successfully confirmed!</p>
    <div class="button-container">
        <button><a href="workspace_selection.php">Book Another Workspace</a></button>
        <button><a href="logout.php">Logout</a></button>
    </div>
</body>
</html>


