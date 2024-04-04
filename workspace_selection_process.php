<?php
session_start();
include 'nav1.php';


require 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $workspace_id = $_POST["workspace"];
    $category = $_POST["category"];
    $plan = $_POST["plan"];
    $username = $_SESSION['username']; 

    if ($endDate < $startDate) {
        header("Location: workspace_selection.php?error=end_date_before_start_date");
        exit();
    }


    // Fetch user ID based on the username
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];


// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO bookings (start_date, end_date, workspace_id, user_id, username, selected_plan, selected_categories) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiisss", $startDate, $endDate, $workspace_id, $user_id, $username, $plan, $category);



        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['booking_success'] = "Booking successful!";
            header("Location: confirmation.php");
            exit();
        } else {
            $_SESSION['booking_error'] = "Error: " . $stmt->error;
            header("Location: mainpage.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['booking_error'] = "User not found!";
        header("Location: logout.php");
        exit();
    }

    $conn->close();
} else {
    header("Location: mainpage.php");
    exit();
}
?>
