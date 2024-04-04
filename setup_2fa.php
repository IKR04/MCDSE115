<?php
session_start();


require 'connection.php';
require 'GoogleAuthenticator.php'; 

// Check if user is logged in
if (!isset($_SESSION['new_username']) || !isset($_SESSION['secret_key'])) {
    header("Location: mainpage.php");
    exit();
}

// Retrieve username and secret key from the session
$username = $_SESSION['new_username'];
$secretKey = $_SESSION['secret_key'];


// Check if the "Done" button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['done'])) {
    // Store the secret key in the database
    $stmt = $conn->prepare("UPDATE users SET secret_key = ? WHERE username = ?");
    $stmt->bind_param("ss", $secretKey, $username);
    if ($stmt->execute()) {
        // Successfully updated the secret key
        $stmt->close();
        header("Location: login.php"); // Redirect to the main page after saving the secret key
        exit();
    } else {
        // Error occurred while updating the secret key
        echo "Error updating secret key: " . $stmt->error;
    }
}

// Generate QR code URL for Google Authenticator
$ga = new PHPGangsta_GoogleAuthenticator();
$qrCodeUrl = $ga->getQRCodeGoogleUrl($username, $secretKey, 'Google Authenticator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup 2FA</title>
</head>
<body>
    <h2>Setup Two-Factor Authentication</h2>
    <p>Username: <?php echo $username; ?></p>
    <p>Scan the QR code below using the Google Authenticator app:</p>
    <p>Secret Key: <?php echo $secretKey; ?></p>
    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
    

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type="submit" name="done">Done</button>
    </form>
</body>
</html>
