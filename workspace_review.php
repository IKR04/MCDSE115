<?php
include 'nav1.php';
include 'footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Ratings</title>
    <style>
       
       body {
            margin: 0;
            font-family: Arial, sans-serif;
            padding-bottom: 60px;
        }
        .reviews {
            text-align: center;
            margin-top: 50px;
        }

        .reviews h4 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .reviews p {
            font-size: 18px;
        }

        .comment-section {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .comment {
            margin-bottom: 10px;
        }

        .comment p {
            margin: 0;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="reviews">
        <h4>Workspace Ratings</h4>
        <?php 
            require 'connection.php';

            // Fetch average ratings for each workspace from the database
            $sql = "SELECT w.workspace_name, AVG(r.rating) AS average_rating
                    FROM workspaces w 
                    LEFT JOIN reviews r ON w.workspace_id = r.workspace_id 
                    GROUP BY w.workspace_id 
                    LIMIT 10";
            $result = $conn->query($sql);
            $counter = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $workspace_name = $row['workspace_name'];
                    $average_rating = round($row['average_rating'], 1);
                    echo "<p>Workspace Name: $workspace_name | Average Rating: $average_rating</p>";
                    
                    $counter++;
                    if ($counter >= 10) {
                        break;
                    }
                }
            } else {
                echo "<p>No ratings available.</p>";
            }

            $conn->close();
        ?>
    </div>


</body>
</html>
