<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "stylefixclothing"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password'];

    // SQL query to fetch user details
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Redirect to the homepage
            header("Location: home.html");
            exit();
        } else {
            echo "<p style='color: red; text-align: center;'>Incorrect password!</p>";
        }
    } else {
        echo "<p style='color: red; text-align: center;'>No account found with that username!</p>";
    }

    $stmt->close();
}

$conn->close();
?>
