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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
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

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        select, input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            resize: vertical;
        }

        textarea {
            height: 100px; 
        }

        button[type="submit"] {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Submit Review</h2>
    <form action="submit_review.php" method="post">
        <label for="workspace_id">Select Workspace:</label>
        <select id="workspace_id" name="workspace_id" required>
            <option value="">Select Workspace</option>
            <?php
            session_start();
            require 'connection.php';

            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                // Retrieve username from session
                $username = $_SESSION['username'];

                // Prepare and execute SQL statement to get user ID based on username
                $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    // Fetch user ID
                    $row = $result->fetch_assoc();
                    $user_id = $row['user_id'];

                    // Fetch workspace IDs booked by the user
                    $stmt = $conn->prepare("SELECT workspace_id FROM bookings WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $workspaces = [];

                    // Store fetched workspace IDs
                    while ($row = $result->fetch_assoc()) {
                        $workspaces[] = $row["workspace_id"];
                    }

                    // Loop through each workspace ID
                    foreach ($workspaces as $workspace_id) {
                        // Fetch the workspace name associated with the workspace ID
                        $stmt = $conn->prepare("SELECT workspace_name FROM workspaces WHERE workspace_id = ?");
                        $stmt->bind_param("i", $workspace_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $workspace_name = $row['workspace_name'];
                        // Output an option element with the workspace name as the value
                        echo "<option value='$workspace_id'>$workspace_name</option>";
                    }
                } else {
                    // Handle case where user ID is not found
                    echo "User ID not found!";
                }

                $stmt->close();
            } else {
                // Redirect the user to the login page if not logged in
                header("Location: login.php");
                exit();
            }

            $conn->close();
            ?>
        </select><br><br>

        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>
        
        <label for="comments">Comments:</label><br>
        <textarea id="comments" name="comments" rows="4" cols="50" required></textarea><br><br>
        
        <button type="submit">Submit Review</button>
    </form>
</body>
</html>
