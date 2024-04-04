<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected start date, end date, workspace, and time slot from the form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $selectedWorkspace = $_POST['workspace'];
    $timeSlot = $_POST['time_slot'];

    require 'connection.php';

    $currentDate = $start_date;
    while (strtotime($currentDate) <= strtotime($end_date)) {
        $start_time = "$currentDate $timeSlot";
        $end_time = date("Y-m-d H:i:s", strtotime("$start_time +1 hour"));

        $sql = "INSERT INTO bookings (user_id, workspace_id, start_time, end_time) VALUES ('{$_SESSION['user_id']}', '$selectedWorkspace', '$start_time', '$end_time')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            break;
        }

        $currentDate = date("Y-m-d", strtotime("$currentDate +1 day"));
    }

    header("Location: confirmation.php");

    $conn->close();
}
?>
