<?php
require 'connection.php'; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Prepare and execute SQL statement to insert update into database
    $sql = "INSERT INTO updates (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $description);
    $stmt->execute();

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect back to admin interface or to a confirmation page
    header("Location: admin_dashboard.php");
    exit();
}
?>
