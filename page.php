<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "registration_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sign Up Process
if (isset($_POST['signUp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $country = $_POST['country'];
    $profile_image = 'default.jpg';

    // Insert into users table
    $sql = "INSERT INTO users (name, email, password, country) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $country); 

    if ($stmt->execute()) {
        header('Location: success.html');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Sign In Process
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['loggedin'] = true;
            header('Location: maindash.php');
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}

// Profile Update Process
if (isset($_POST['updateProfile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];

    // Update user data
    $sql = "UPDATE users SET name = ?, email = ?, country = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $country, $_SESSION['user_id']); 

    if ($stmt->execute()) {
        header('Location: maindash.php'); // Redirect to dashboard after update
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}


$conn->close();
?>
