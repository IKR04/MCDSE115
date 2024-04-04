<body>
    <nav>
        <?php
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role']; // Retrieve user role from session
        } else {
            $role = 'user'; // Set a default role for guest users
        }
        
        // Display navigation links based on the user's role
        if ($role === 'admin') {
            // Display admin navigation links
            echo '<a href="index.php">Logout</a>';
            echo '<a href="user_profile.php">Profile</a>';
            echo '<a href="admin_dashboard.php">Admin</a>';
        } else {
            // Display regular user navigation links
            echo '<a href="index.php">Logout</a>';
            echo '<a href="user_profile.php">Profile</a>';
            echo '<a href="mainpage.php">Home</a>';
        }
        ?>
    </nav>
    <style>
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</body>
