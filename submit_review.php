<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $rating = $_POST["rating"];
    $comments = $_POST["comments"];
    $username = $_SESSION["username"]; 
    $workspace_id = $_POST["workspace_id"]; 

    // Prepare and execute SQL statement to get user ID based on username
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Prepare and bind SQL statement to insert review with workspace_id
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, workspace_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user_id, $workspace_id, $rating, $comments);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Review submitted successfully.";
            echo '<a href="mainpage.php"><button>Done</button></a>';
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: User not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: submit_review.php");
    exit();
}
?>
