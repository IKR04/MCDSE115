<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkHub Dedicated Desk | WorkHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        .details {
            text-align: center;
            margin-bottom: 30px;
        }

        .membership-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .membership {
            width: 300px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .details img {
            max-width: 200px; 
            width: 100%;
            border-radius: 5px;
            margin: 0 auto; 
            margin-bottom: 10px; 
        }

        button {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    require 'connection.php';

    if (!isset($_SESSION['username'])) {
        include 'nav.php';
    } else {
        include 'nav1.php';
    }
    ?>

    <div class="container">
        <h1>Dedicated Desk</h1>

        <div class="details">
            <h4>SPACE DETAILS</h4>
            <p>Good for individuals and small teams </p>
            <p>Keycard access to your own desk in a shared office</p>
            <p>Enjoy fast Wi-Fi, printing, unlimited coffee, and on-site support</p>
            <img src="photo/dedicated_desk.jpeg" alt="Workspace Image">
        </div>

        <div class="membership-row">
            <div class="membership">
                <h3>Dedicated Desk</h3>
                <p>A designated desk within a shared lockable office with access to the building's shared professional amenities</p>
                <h5>WHO IT"S FOR</h5>
                <p>1-4 people</p>
                <h5>PROFESSIONAL AMENITIES</h5>
                <p>Shared pantries, lounges, phone booths, and print nooks</p>

                <h4>Price</h4>
                <p>RM30 Per Day</p> 

                <?php
                // Check if the user is logged in
                if(isset($_SESSION['username'])) {
                    // User is logged in, redirect to buynow.php
                    echo '<a href="workspace_selection.php"><button type="button">Buy Now!</button></a>';
                } else {
                    // User is not logged in, redirect to login.php
                    echo '<a href="login.php"><button type="button">Login to Buy Now!</button></a>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php';?>
</body>
</html>
