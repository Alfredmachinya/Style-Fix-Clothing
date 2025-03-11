<?php
// Start the session
session_start();

// Connect to the database
$servername = "localhost"; // Database server
$username = "root";        // Database username
$password = "2025";            // Database password
$dbname = "stylefix";      // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query the database for user details
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password_hash'])) {
            // Store user info in session and redirect
            $_SESSION['username'] = $user['username'];
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No user found with that username.";
    }
}

$conn->close();
?>
