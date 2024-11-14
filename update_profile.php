<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: page.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; // Database password
$dbname = "registration_db";
$user_id = $_SESSION['user_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash new password
    $country = $_POST['country'];

    // Prepare and bind SQL statement
    $sql = "UPDATE users SET name = ?, email = ?, password = ?, country = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $password, $country, $user_id);

    // Execute the update
    if ($stmt->execute()) {
        echo "Profile updated successfully!";
        header("Location: maindash.php"); // Redirect to dashboard after update
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
