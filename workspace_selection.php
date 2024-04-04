<?php
session_start();
include 'nav1.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Workspace Selection</h1>
    <form action="workspace_selection_process.php" method="post" class="container">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <?php
        // Function to fetch and display workspaces
        function displayWorkspaces() {
            require 'connection.php';

            // Fetch workspaces from the database excluding the location field
            $sql = "SELECT workspace_id, workspace_name FROM workspaces";
            $result = $conn->query($sql);

            // Display workspaces in a dropdown list
            echo '<label for="workspace">Select Workspace:</label>';
            echo '<select id="workspace" name="workspace">';
            echo '<option value="">Select Workspace</option>';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['workspace_id'] . '">' . $row['workspace_name'] . '</option>';
                }
            } else {
                echo '<option value="">No workspaces available</option>';
            }
            echo '</select>';

        }

        // Call the function to display workspaces
        displayWorkspaces();
        ?>

        <!-- Dropdown menu for categories -->
        <label for="category">Select Category:</label>
        <select id="category" name="category">
            <option value="">All Categories</option>
            <?php
            // Fetch unique categories from the database
            require 'connection.php';
            $sql = "SELECT DISTINCT categories FROM workspaces";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['categories'] . '">' . $row['categories'] . '</option>';
                }
            }

            $conn->close();
            ?>
        </select>

      <label for="plan">Select Plan:</label>
      <select id="plan" name="plan">
          <option value="">All Plans</option>
          <?php
    // Fetch unique plan names from the database
        require 'connection.php';
        $sql = "SELECT DISTINCT plan_name FROM workspaces";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['plan_name'] . '">' . $row['plan_name'] . '</option>';
            }
        }
    $conn->close();
    ?>
</select>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
