<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "registration_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT name, email, country, profile_image FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $country = $row['country'];
        $profile_image = $row['profile_image'] ? $row['profile_image'] : 'default.jpg';
    } else {
        $name = "N/A";
        $email = "N/A";
        $country = "N/A";
        $profile_image = "default.jpg";
    }
} else {
    echo "User not logged in.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .btn {
            border: 2px solid gray;
            color: gray;
            background-color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .info {
            margin-top: 20px;
        }
        .update-profile-btn, .logout-btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn {
            background: #f44336;
        }
        .user-details {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo $name; ?></h1>
            <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-pic" id="profilePic">
            <div class="upload-btn-wrapper">
                <button class="btn">Upload a picture</button>
                <input type="file" name="profilePic" id="fileInput">
            </div>
        </div>
        <div class="info">
            <h2>Dashboard</h2>
            <p