<?php
session_start();
include 'nav1.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'connection.php'; 
    $stmt = $conn->prepare("INSERT INTO workspaces (workspace_name, categories, description, plan_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $workspace_name, $categories, $description, $plan_name);


    // Set parameters and execute
    $workspace_name = $_POST["workspace_name"];
    $categories = $_POST["categories"];
    $description = $_POST["description"];
    $plan_name = $_POST["plan_name"];
    $stmt->execute();
    
    $stmt->close();
    $conn->close();

    // Set success message
    $_SESSION['workspace_success'] = "Workspace added successfully!";
    header("Location: admin_workspace_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Management</title>
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

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .workspace-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
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
    <div class="container">
        <h1>Workspace Management</h1>
        <?php
            // Check for any success or error messages
            if (isset($_SESSION['workspace_success'])) {
                echo '<div class="success-message">' . $_SESSION['workspace_success'] . '</div>';
                unset($_SESSION['workspace_success']);
            }
            if (isset($_SESSION['workspace_error'])) {
                echo '<div class="error-message">' . $_SESSION['workspace_error'] . '</div>';
                unset($_SESSION['workspace_error']);
            }
        ?>
        <div class="workspace-form">
            <h2>Add Workspace</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="workspace_name">Workspace Name:</label>
                    <input type="text" id="workspace_name" name="workspace_name" required>
                </div>
                <div class="form-group">
                    <label for="categories">Categories:</label>
                    <input type="text" id="categories" name="categories" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="plan_name">Plan:</label>
                    <input type="text" id="plan_name" name="plan_name" required>
                </div>
                <button type="submit" name="add_workspace">Add Workspace</button>
            </form>
        </div>
    </div>
</body>
</html>



