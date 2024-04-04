<?php
session_start();
include 'nav1.php';
include 'footer.php';
require 'connection.php';

function fetchBookings() {
    global $conn;
    $sql = "SELECT b.booking_id, b.user_id, b.username, b.workspace_id, b.start_date, b.end_date, w.workspace_name 
            FROM bookings b 
            INNER JOIN workspaces w ON b.workspace_id = w.workspace_id";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
$bookings = fetchBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Users Bookings</h1>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Workspace Name</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?php echo $booking['booking_id']; ?></td>
                <td><?php echo $booking['user_id']; ?></td>
                <td><?php echo $booking['username']; ?></td>
                <td><?php echo $booking['workspace_name']; ?></td>
                <td><?php echo $booking['start_date']; ?></td>
                <td><?php echo $booking['end_date']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
