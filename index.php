<?php
session_start(); 
session_destroy(); 

include 'nav.php';
include 'footer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-top: 50px;
        }

        .content {
            margin-top: 50px;
            margin-bottom: 100px; 
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 30px;
        }

        .workspace-section {
            width: 300px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            text-align: center;
        }

        .workspace-section img {
            width: 100%;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to WorkHub</h1>
        <p>This is the homepage content.</p>
    </div>
    <div class="content">
       
        <div class="workspace-section">
            <h4>Private Office</h4>
            <img src="photo/private_office.jpg" alt="Private Office">
            <p>Settle into a fully-furnished office with access to professional amenities and meeting rooms.</p>
            <a href="private_office.php"><button type="button">Learn More!</button></a>
        </div>

        <div class="workspace-section">
            <h4>Dedicated Desk</h4>
            <img src="photo/dedicated_desk.jpeg" alt="Dedicated Desk">
            <p>Have your own personal desk in a shared office, including access to professional amenities and meeting rooms.</p>
            <a href="dedicated_desk.php"><button type="button">Learn More!</button></a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("active");
        }
    </script>
</body>
</html>

