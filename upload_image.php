<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit();
}

$target_dir = "uploads/";  // Directory to store uploaded files
$target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the file is an actual image
$check = getimagesize($_FILES["profilePic"]["tmp_name"]);
if($check === false) {
    echo "File is not an image.";
    exit();
}

// Move the uploaded file to the target directory
if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
    // Update the user's profile image in the database
    $conn = new mysqli("localhost", "root", "", "registration_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $target_file, $user_id);
    
    if ($stmt->execute()) {
        echo $target_file;  // Return the new profile image URL
    } else {
        echo "Error updating profile image.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error uploading file.";
}
?>
