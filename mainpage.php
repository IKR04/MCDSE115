<?php
include 'nav1.php';
include 'footer.php';
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
require 'connection.php';

// Fetch upcoming bookings for the logged-in user
$username = $_SESSION['username'];
$sql = "SELECT b.start_date, w.workspace_name 
        FROM bookings b 
        INNER JOIN workspaces w ON b.workspace_id = w.workspace_id 
        WHERE b.user_id = (SELECT user_id FROM users WHERE username = '$username')
        ORDER BY b.start_date ASC LIMIT 1";
$result = $conn->query($sql);

// Check if there are any upcoming bookings
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $start_date = date("F j, Y", strtotime($row['start_date']));
    $workspace_name = $row['workspace_name'];
    $reminder_message = "Hello $username, you have an upcoming booking on $start_date at $workspace_name.";
} else {
    $reminder_message = "Hello $username, you don't have any upcoming bookings.";
}

// Fetch updates
$sql = "SELECT * FROM updates ORDER BY timestamp DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        
        .updates-container {
            position: fixed;
            bottom: 50px;
            right: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            max-width: 300px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .updates-header {
            font-weight: bold;
            margin-bottom: 0px;
        }

        .update {
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .update:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .show-more {
            text-align: center;
            margin-top: 10px;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            padding-bottom: 60px;
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

       
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #45a049;
        }
        .reminder {
            text-align: center;
            margin-top: 10px;
            font-size: 18px;
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

    <div class="button-container">
        <a href="reviews.php"><button type="button">Submit Review</button></a>
        <a href="workspace_review.php"><button type="button">Review</button></a>
    </div>
  
     <div class="reminder">
        <?php echo $reminder_message; ?>
    </div>


    <div class="updates-container" id="updatesContainer">
        <h3 class="updates-header">Latest Updates</h3>
        <?php
        if ($result->num_rows > 0) {
            $num_updates_displayed = 0;
            while ($row = $result->fetch_assoc()) {
                if ($num_updates_displayed >= 1) {
                    break;
                }
                echo "<div class='update'>";
                echo "<h4>{$row['title']}</h4>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Posted on: {$row['timestamp']}</p>";
                echo "</div>";
                $num_updates_displayed++;
            }
            
        } else {
            echo "<p>No updates available.</p>";
        }
        ?>
    </div>
    </script>

</body>
</html>
