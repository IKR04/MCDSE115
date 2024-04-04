<?php
session_start();
include 'nav1.php';
include 'footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-top: 50px;
        }

        .btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Admin Dashboard</h1>
        <a href="admin_workspace_management.php" class="btn">Workspace Management</a>
        <a href="admin_bookings.php" class="btn">User Bookings</a>
        <a href="update_information.php" class="btn">Share Update</a>
    </div>
</body>
</html>
